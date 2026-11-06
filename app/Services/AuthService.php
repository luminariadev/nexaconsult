<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;
use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use App\Models\User;

class AuthService
{
    protected ?Client $mongoClient = null;
    protected $collection = null;
    protected string $secret;
    protected int $expire;
    protected bool $useMongo = false;

    // In-memory blacklist for current cycle, and file/cache token blacklist
    protected static array $blacklist = [];

    public function __construct()
    {
        $this->secret = env('JWT_SECRET', 'bb7ff5b5c0b44ac29d3f702f9c7dd0cf86bc79baf92f1d4cd67adcf48e545e1a');
        $this->expire = (int) env('JWT_EXPIRE', 2592000); // 30 hari

        $this->initDriver();
    }

    protected function initDriver(): void
    {
        if (extension_loaded('mongodb')) {
            try {
                $uri = env('MONGODB_URI', 'mongodb://127.0.0.1:27017');
                $client = new Client($uri, [], ['serverSelectionTimeoutMS' => 800]);
                // Test ping
                $client->listDatabases();
                $this->mongoClient = $client;
                $dbName = env('MONGODB_DATABASE', 'nexaconsult');
                $db = $this->mongoClient->selectDatabase($dbName);
                $this->collection = $db->selectCollection('users');
                $this->useMongo = true;
            } catch (\Throwable $e) {
                $this->useMongo = false;
            }
        } else {
            $this->useMongo = false;
        }
    }

    public function isUsingMongo(): bool
    {
        return $this->useMongo;
    }

    /* =====================================================
     * REGISTER
     * ===================================================== */
    public function register(array $data)
    {
        $passwordPlain = $data['password'];
        $data['role'] = $data['role'] ?? 'user';
        $data['password'] = Hash::make($passwordPlain);
        $data['created_at'] = now();
        $data['updated_at'] = now();

        if ($this->useMongo && $this->collection) {
            $result = $this->collection->insertOne($data);
            $data['_id'] = (string) $result->getInsertedId();
            return $this->generateToken($data);
        }

        // Eloquent fallback (MySQL)
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role'     => $data['role'],
        ]);

        $arr = $user->toArray();
        $arr['_id'] = (string) $user->id;
        return $this->generateToken($arr);
    }

    /* =====================================================
     * FIND BY EMAIL
     * ===================================================== */
    public function findByEmail(string $email)
    {
        if ($this->useMongo && $this->collection) {
            return $this->collection->findOne(['email' => $email]);
        }

        return User::where('email', $email)->first();
    }

    /* =====================================================
     * LOGIN
     * ===================================================== */
    public function login(string $email, string $password)
    {
        if ($this->useMongo && $this->collection) {
            $user = $this->collection->findOne(['email' => $email]);
            if (!$user) return null;
            if (!Hash::check($password, $user->password)) return null;

            $arr = (array) $user;
            $arr['_id'] = (string) ($user->_id ?? $user['id'] ?? '');
            return $this->generateToken($arr);
        }

        // Eloquent fallback
        $user = User::where('email', $email)->first();
        if (!$user) return null;
        if (!Hash::check($password, $user->password)) return null;

        $arr = $user->toArray();
        $arr['_id'] = (string) $user->id;
        return $this->generateToken($arr);
    }

    /* =====================================================
     * TOKEN GENERATION
     * ===================================================== */
    public function generateToken(array $user): string
    {
        $id = (string) ($user['_id'] ?? $user['id'] ?? '');

        $payload = [
            'sub'   => $id,
            'email' => $user['email'] ?? '',
            'role'  => $user['role'] ?? 'user',
            'name'  => $user['name'] ?? '',
            'iat'   => time(),
            'exp'   => time() + $this->expire,
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }

    /* =====================================================
     * TOKEN FROM HEADER
     * ===================================================== */
    public function getToken(): ?string
    {
        $header = request()->header('Authorization');

        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return null;
        }

        return substr($header, 7);
    }

    /* =====================================================
     * VERIFY TOKEN
     * ===================================================== */
    public function verifyToken(?string $token)
    {
        if (!$token) return null;
        if (in_array($token, self::$blacklist)) return null;

        try {
            return JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (\Throwable $e) {
            return null;
        }
    }

    /* =====================================================
     * LOGOUT
     * ===================================================== */
    public function logout(): bool
    {
        $token = $this->getToken();
        if ($token) {
            self::$blacklist[] = $token;
            return true;
        }
        return false;
    }

    /* =====================================================
     * REFRESH TOKEN
     * ===================================================== */
    public function refresh(): ?string
    {
        $token = $this->getToken();
        if (!$token) return null;

        $decoded = $this->verifyToken($token);
        if (!$decoded) return null;

        self::$blacklist[] = $token;

        $user = $this->findUserById((string) $decoded->sub);
        if (!$user) return null;

        return $this->generateToken((array) $user);
    }

    /* =====================================================
     * ME
     * ===================================================== */
    public function me(): ?array
    {
        $decoded = $this->verifyToken($this->getToken());
        if (!$decoded) return null;

        $user = $this->findUserById((string) $decoded->sub);
        if (!$user) return null;

        $arr = (array) $user;
        unset($arr['password']);
        $arr['_id'] = (string) ($arr['_id'] ?? $arr['id'] ?? '');

        return $arr;
    }

    /* =====================================================
     * GET USER ID
     * ===================================================== */
    public function id(): ?string
    {
        $decoded = $this->verifyToken($this->getToken());
        if (!$decoded) return null;

        return (string) $decoded->sub;
    }

    /* =====================================================
     * UPDATE PROFILE
     * ===================================================== */
    public function updateProfile(string $userId, array $data): ?array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['updated_at'] = now();

        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($userId);
            } catch (\Throwable $e) {
                $objId = $userId;
            }
            $this->collection->updateOne(['_id' => $objId], ['$set' => $data]);
            return $this->me();
        }

        $user = User::find($userId);
        if ($user) {
            $user->update($data);
            $arr = $user->toArray();
            unset($arr['password']);
            $arr['_id'] = (string)$user->id;
            return $arr;
        }

        return null;
    }

    public function changePassword(string $userId, string $currentPassword, string $newPassword): array
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($userId);
            } catch (\Throwable $e) {
                $objId = $userId;
            }
            $user = $this->collection->findOne(['_id' => $objId]);
            if (!$user) {
                return ['success' => false, 'message' => 'Pengguna tidak ditemukan'];
            }
            if (!Hash::check($currentPassword, $user['password'])) {
                return ['success' => false, 'message' => 'Password saat ini salah'];
            }
            $this->collection->updateOne(
                ['_id' => $objId],
                ['$set' => [
                    'password'   => Hash::make($newPassword),
                    'updated_at' => now()->toIso8601String()
                ]]
            );
            return ['success' => true, 'message' => 'Password berhasil diubah'];
        }

        $user = User::find($userId);
        if (!$user) {
            return ['success' => false, 'message' => 'Pengguna tidak ditemukan'];
        }
        if (!Hash::check($currentPassword, $user->password)) {
            return ['success' => false, 'message' => 'Password saat ini salah'];
        }
        $user->update([
            'password' => Hash::make($newPassword),
            'updated_at' => now()
        ]);
        return ['success' => true, 'message' => 'Password berhasil diubah'];
    }

    protected function findUserById(string $id)
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $doc = $this->collection->findOne(['_id' => $objId]);
            if ($doc) {
                $arr = (array) $doc;
                $arr['_id'] = (string) ($doc->_id ?? $doc['id'] ?? '');
                return $arr;
            }
            return null;
        }

        $user = User::find($id);
        if ($user) {
            $arr = $user->toArray();
            $arr['_id'] = (string) $user->id;
            return $arr;
        }

        return null;
    }
}
