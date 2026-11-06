<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\ProjectService;
use App\Services\LandingPageService;
use App\Models\User;
use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    protected AuthService $auth;
    protected ProjectService $projectService;
    protected LandingPageService $landingPageService;

    public function __construct(AuthService $auth, ProjectService $projectService, LandingPageService $landingPageService)
    {
        $this->auth = $auth;
        $this->projectService = $projectService;
        $this->landingPageService = $landingPageService;
    }

    /**
     * Verify that caller is admin
     */
    protected function ensureAdmin()
    {
        $user = $this->auth->me();
        if (!$user || ($user['role'] ?? 'user') !== 'admin') {
            abort(403, 'Akses Ditolak: Hanya Administrator yang diizinkan.');
        }
        return $user;
    }

    /**
     * GET /api/admin/stats
     */
    public function stats()
    {
        $this->ensureAdmin();

        $totalUsers = 0;
        $adminCount = 0;
        $userCount = 0;

        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                $totalUsers = $db->selectCollection('users')->countDocuments();
                $adminCount = $db->selectCollection('users')->countDocuments(['role' => 'admin']);
                $userCount = $totalUsers - $adminCount;
                $totalProjects = $db->selectCollection('projects')->countDocuments();
            } catch (\Throwable $e) {
                $totalUsers = User::count();
                $adminCount = User::where('role', 'admin')->count();
                $userCount = $totalUsers - $adminCount;
                $totalProjects = \App\Models\Project::count();
            }
        } else {
            $totalUsers = User::count();
            $adminCount = User::where('role', 'admin')->count();
            $userCount = $totalUsers - $adminCount;
            $totalProjects = \App\Models\Project::count();
        }

        $totalLandingPages = $this->landingPageService->countTotal();

        // Test AI Gateway status
        $aiOnline = false;
        try {
            $apiKey = env('AI_API_KEY', '');
            $testReq = Http::withToken($apiKey)->timeout(2)->get('http://127.0.0.1:20128/api/v1/models');
            $aiOnline = $testReq->successful() || $testReq->status() === 200 || $testReq->status() === 401;
        } catch (\Throwable $e) {
            $aiOnline = false;
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'total_users'         => $totalUsers,
                'admin_count'         => $adminCount,
                'user_count'          => $userCount,
                'total_projects'      => $totalProjects,
                'total_landing_pages' => $totalLandingPages,
                'database_driver'     => $this->auth->isUsingMongo() ? 'MongoDB (Utama)' : 'MySQL (Fallback)',
                'mongo_status'        => $this->auth->isUsingMongo() ? 'Active (Port 27017)' : 'Offline',
                'ai_gateway_status'   => $aiOnline ? 'Online (9Router Port 20128)' : 'Standby / Offline',
            ]
        ]);
    }

    /**
     * GET /api/admin/users
     */
    public function users()
    {
        $this->ensureAdmin();

        $usersList = [];

        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                $cursor = $db->selectCollection('users')->find([], ['sort' => ['created_at' => -1]]);
                foreach ($cursor as $doc) {
                    $u = (array)$doc;
                    $id = (string)($u['_id'] ?? $u['id'] ?? '');
                    $projCount = $db->selectCollection('projects')->countDocuments(['user_id' => $id]);
                    $usersList[] = [
                        'id'         => $id,
                        '_id'        => $id,
                        'name'       => $u['name'] ?? 'User',
                        'email'      => $u['email'] ?? '-',
                        'role'       => $u['role'] ?? 'user',
                        'projects'   => $projCount,
                        'created_at' => is_string($u['created_at'] ?? null) ? $u['created_at'] : now()->toIso8601String(),
                    ];
                }
            } catch (\Throwable $e) {
                $usersList = [];
            }
        }

        if (empty($usersList)) {
            $users = User::withCount('projects')->orderBy('created_at', 'desc')->get();
            foreach ($users as $u) {
                $usersList[] = [
                    'id'         => (string)$u->id,
                    '_id'        => (string)$u->id,
                    'name'       => $u->name,
                    'email'      => $u->email,
                    'role'       => $u->role,
                    'projects'   => $u->projects_count,
                    'created_at' => $u->created_at ? $u->created_at->toIso8601String() : now()->toIso8601String(),
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'data'   => $usersList
        ]);
    }

    /**
     * PUT /api/admin/users/{id}/role
     */
    public function updateUserRole($id, Request $request)
    {
        $this->ensureAdmin();
        $request->validate(['role' => 'required|in:admin,user']);
        $newRole = $request->role;

        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                try {
                    $objId = new ObjectId($id);
                } catch (\Throwable $e) {
                    $objId = $id;
                }
                $db->selectCollection('users')->updateOne(
                    ['_id' => $objId],
                    ['$set' => ['role' => $newRole, 'updated_at' => now()->toIso8601String()]]
                );
            } catch (\Throwable $e) {}
        }

        $user = User::find($id);
        if ($user) {
            $user->update(['role' => $newRole]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => "Role pengguna berhasil diubah menjadi {$newRole}"
        ]);
    }

    /**
     * DELETE /api/admin/users/{id}
     */
    public function deleteUser($id)
    {
        $currentAdmin = $this->ensureAdmin();
        if (($currentAdmin['_id'] ?? $currentAdmin['id'] ?? '') === $id) {
            return response()->json(['status' => 'error', 'message' => 'Anda tidak dapat menghapus akun Anda sendiri.'], 400);
        }

        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                try {
                    $objId = new ObjectId($id);
                } catch (\Throwable $e) {
                    $objId = $id;
                }
                $db->selectCollection('users')->deleteOne(['_id' => $objId]);
                $db->selectCollection('projects')->deleteMany(['user_id' => (string)$id]);
            } catch (\Throwable $e) {}
        }

        $user = User::find($id);
        if ($user) {
            $user->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Pengguna dan data proyeknya berhasil dihapus.'
        ]);
    }

    /**
     * GET /api/admin/projects
     */
    public function allProjects()
    {
        $this->ensureAdmin();

        $projects = [];
        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                $cursor = $db->selectCollection('projects')->find([], ['sort' => ['created_at' => -1], 'limit' => 100]);
                foreach ($cursor as $doc) {
                    $p = (array)$doc;
                    $p['id'] = (string)($p['_id'] ?? '');
                    $p['_id'] = $p['id'];
                    $projects[] = $p;
                }
            } catch (\Throwable $e) {}
        }

        if (empty($projects)) {
            $projects = \App\Models\Project::orderBy('created_at', 'desc')->limit(100)->get()->toArray();
        }

        return response()->json([
            'status' => 'success',
            'data'   => $projects
        ]);
    }

    /**
     * GET /api/admin/landing-pages
     */
    public function allLandingPages()
    {
        $this->ensureAdmin();

        $pages = [];
        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                $cursor = $db->selectCollection('landing_pages')->find([], ['sort' => ['created_at' => -1], 'limit' => 100]);
                foreach ($cursor as $doc) {
                    $lp = (array)$doc;
                    $lp['id'] = (string)($lp['_id'] ?? '');
                    $lp['_id'] = $lp['id'];
                    $lp['public_url'] = url('/site/' . ($lp['slug'] ?? ''));
                    $pages[] = $lp;
                }
            } catch (\Throwable $e) {}
        }

        if (empty($pages)) {
            $pages = \App\Models\LandingPage::orderBy('created_at', 'desc')->limit(100)->get()->map(function ($item) {
                $arr = $item->toArray();
                $arr['public_url'] = url('/site/' . $item->slug);
                return $arr;
            })->toArray();
        }

        return response()->json([
            'status' => 'success',
            'data'   => $pages
        ]);
    }

    /**
     * DELETE /api/admin/landing-pages/{id}
     */
    public function deleteLandingPage($id)
    {
        $this->ensureAdmin();

        if ($this->auth->isUsingMongo()) {
            try {
                $client = new Client(env('MONGODB_URI', 'mongodb://127.0.0.1:27017'));
                $db = $client->selectDatabase(env('MONGODB_DATABASE', 'nexaconsult'));
                try {
                    $objId = new ObjectId($id);
                } catch (\Throwable $e) {
                    $objId = $id;
                }
                $db->selectCollection('landing_pages')->deleteOne(['_id' => $objId]);
            } catch (\Throwable $e) {}
        }

        $lp = \App\Models\LandingPage::find($id);
        if ($lp) {
            $lp->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Landing page berhasil dihapus dari sistem.'
        ]);
    }
}
