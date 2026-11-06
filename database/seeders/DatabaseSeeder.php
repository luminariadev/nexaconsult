<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@nexaconsult.id'],
            [
                'name'     => 'Administrator NexaConsult',
                'password' => Hash::make('AdminPassword2026!'),
                'role'     => 'admin',
            ]
        );

        // 2. Regular User (UMKM)
        $user = User::updateOrCreate(
            ['email' => 'user@nexaconsult.id'],
            [
                'name'     => 'Mawar Hitam (Owner Keripik Bu Mawar)',
                'password' => Hash::make('UserPassword2026!'),
                'role'     => 'user',
            ]
        );

        // 3. Sample UMKM Projects for Mawar Hitam
        Project::updateOrCreate(
            [
                'user_id' => $user->id,
                'name'    => 'Keripik Singkong Renyah Bu Mawar'
            ],
            [
                'description' => 'Pengembangan usaha olahan keripik singkong aneka rasa dengan kemasan standing pouch premium, sertifikasi Halal & PIRT, serta penjualan multichannel via TikTok Shop dan reseller lokal.',
                'user_prompt' => 'Saya ingin mengembangkan usaha keripik singkong rumahan agar bisa masuk minimarket dan viral di TikTok Shop.',
                'status'      => 'active',
                'tasks'       => [
                    [
                        'task'       => 'Riset kompetitor lokal dan uji coba 4 varian rasa (Balado, Keju Manis, Rumput Laut, Original)',
                        'done'       => true,
                        'created_at' => now()->subDays(5)->toISOString()
                    ],
                    [
                        'task'       => 'Pendaftaran Nomor Induk Berusaha (NIB) dan pengajuan Sertifikasi Halal Kemenag',
                        'done'       => true,
                        'created_at' => now()->subDays(4)->toISOString()
                    ],
                    [
                        'task'       => 'Desain kemasan standing pouch ziplock metalized tahan minyak dengan logo modern',
                        'done'       => false,
                        'created_at' => now()->subDays(3)->toISOString()
                    ],
                    [
                        'task'       => 'Kalkulasi HPP, menentukan harga jual Rp 15.000/pack dengan margin laba 45%',
                        'done'       => false,
                        'created_at' => now()->subDays(2)->toISOString()
                    ],
                    [
                        'task'       => 'Setup akun TikTok Shop dan Shopee Mall/Star Seller',
                        'done'       => false,
                        'created_at' => now()->subDays(1)->toISOString()
                    ],
                    [
                        'task'       => 'Membuat video TikTok estetik proses pembuatan keripik higienis (POV usaha rumahan)',
                        'done'       => false,
                        'created_at' => now()->toISOString()
                    ]
                ]
            ]
        );

        Project::updateOrCreate(
            [
                'user_id' => $user->id,
                'name'    => 'Kopi Susu Gula Aren Botolan'
            ],
            [
                'description' => 'Produk kopi susu literan siap minum untuk area perkantoran dan kampus dengan sistem langganan mingguan dan pesan antar.',
                'user_prompt' => 'Ide bisnis kopi susu botolan 1 liter dan 250ml untuk mahasiswa dan pekerja kantoran.',
                'status'      => 'draft',
                'tasks'       => [
                    [
                        'task'       => 'Eksperimen rasio biji kopi Robusta-Arabika dan sirup gula aren organik',
                        'done'       => true,
                        'created_at' => now()->subDays(2)->toISOString()
                    ],
                    [
                        'task'       => 'Pemilihan supplier botol PET 1 liter dan stiker label tahan air (waterproof)',
                        'done'       => false,
                        'created_at' => now()->subDays(1)->toISOString()
                    ],
                    [
                        'task'       => 'Penyusunan promo bundling buy 2 get 1 free di minggu pertama peluncuran',
                        'done'       => false,
                        'created_at' => now()->toISOString()
                    ]
                ]
            ]
        );

        // Also sync/seed into MongoDB if MongoDB is reachable
        if (extension_loaded('mongodb')) {
            try {
                $uri = env('MONGODB_URI', 'mongodb://127.0.0.1:27017');
                $client = new \MongoDB\Client($uri, [], ['serverSelectionTimeoutMS' => 1000]);
                $dbName = env('MONGODB_DATABASE', 'nexaconsult');
                $mongoDb = $client->selectDatabase($dbName);

                $usersCol = $mongoDb->selectCollection('users');
                $projectsCol = $mongoDb->selectCollection('projects');

                // Seed admin in MongoDB
                $adminDoc = $usersCol->findOne(['email' => 'admin@nexaconsult.id']);
                if (!$adminDoc) {
                    $insertAdmin = $usersCol->insertOne([
                        'name'       => 'Administrator NexaConsult',
                        'email'      => 'admin@nexaconsult.id',
                        'password'   => Hash::make('AdminPassword2026!'),
                        'role'       => 'admin',
                        'created_at' => now()->toIso8601String(),
                        'updated_at' => now()->toIso8601String(),
                    ]);
                    $adminId = (string) $insertAdmin->getInsertedId();
                } else {
                    $adminId = (string) $adminDoc['_id'];
                }

                // Seed user in MongoDB
                $userDoc = $usersCol->findOne(['email' => 'user@nexaconsult.id']);
                if (!$userDoc) {
                    $insertUser = $usersCol->insertOne([
                        'name'       => 'Mawar Hitam (Owner Keripik Bu Mawar)',
                        'email'      => 'user@nexaconsult.id',
                        'password'   => Hash::make('UserPassword2026!'),
                        'role'       => 'user',
                        'created_at' => now()->toIso8601String(),
                        'updated_at' => now()->toIso8601String(),
                    ]);
                    $userId = (string) $insertUser->getInsertedId();
                } else {
                    $userId = (string) $userDoc['_id'];
                }

                // Seed sample projects in MongoDB
                $keripikDoc = $projectsCol->findOne(['user_id' => $userId, 'name' => 'Keripik Singkong Renyah Bu Mawar']);
                if (!$keripikDoc) {
                    $projectsCol->insertOne([
                        'user_id'     => $userId,
                        'name'        => 'Keripik Singkong Renyah Bu Mawar',
                        'description' => 'Pengembangan usaha olahan keripik singkong aneka rasa dengan kemasan standing pouch premium, sertifikasi Halal & PIRT, serta penjualan multichannel via TikTok Shop dan reseller lokal.',
                        'user_prompt' => 'Saya ingin mengembangkan usaha keripik singkong rumahan agar bisa masuk minimarket dan viral di TikTok Shop.',
                        'status'      => 'active',
                        'tasks'       => [
                            [
                                'task'       => 'Riset kompetitor lokal dan uji coba 4 varian rasa (Balado, Keju Manis, Rumput Laut, Original)',
                                'done'       => true,
                                'created_at' => now()->subDays(5)->toIso8601String()
                            ],
                            [
                                'task'       => 'Pendaftaran Nomor Induk Berusaha (NIB) dan pengajuan Sertifikasi Halal Kemenag',
                                'done'       => true,
                                'created_at' => now()->subDays(4)->toIso8601String()
                            ],
                            [
                                'task'       => 'Desain kemasan standing pouch ziplock metalized tahan minyak dengan logo modern',
                                'done'       => false,
                                'created_at' => now()->subDays(3)->toIso8601String()
                            ],
                            [
                                'task'       => 'Kalkulasi HPP, menentukan harga jual Rp 15.000/pack dengan margin laba 45%',
                                'done'       => false,
                                'created_at' => now()->subDays(2)->toIso8601String()
                            ],
                            [
                                'task'       => 'Setup akun TikTok Shop dan Shopee Mall/Star Seller',
                                'done'       => false,
                                'created_at' => now()->subDays(1)->toIso8601String()
                            ],
                            [
                                'task'       => 'Membuat video TikTok estetik proses pembuatan keripik higienis (POV usaha rumahan)',
                                'done'       => false,
                                'created_at' => now()->toIso8601String()
                            ]
                        ],
                        'created_at'  => now()->toIso8601String(),
                        'updated_at'  => now()->toIso8601String(),
                    ]);
                }

                $kopiDoc = $projectsCol->findOne(['user_id' => $userId, 'name' => 'Kopi Susu Gula Aren Botolan']);
                if (!$kopiDoc) {
                    $projectsCol->insertOne([
                        'user_id'     => $userId,
                        'name'        => 'Kopi Susu Gula Aren Botolan',
                        'description' => 'Produk kopi susu literan siap minum untuk area perkantoran dan kampus dengan sistem langganan mingguan dan pesan antar.',
                        'user_prompt' => 'Ide bisnis kopi susu botolan 1 liter dan 250ml untuk mahasiswa dan pekerja kantoran.',
                        'status'      => 'draft',
                        'tasks'       => [
                            [
                                'task'       => 'Eksperimen rasio biji kopi Robusta-Arabika dan sirup gula aren organik',
                                'done'       => true,
                                'created_at' => now()->subDays(2)->toIso8601String()
                            ],
                            [
                                'task'       => 'Pemilihan supplier botol PET 1 liter dan stiker label tahan air (waterproof)',
                                'done'       => false,
                                'created_at' => now()->subDays(1)->toIso8601String()
                            ],
                            [
                                'task'       => 'Penyusunan promo bundling buy 2 get 1 free di minggu pertama peluncuran',
                                'done'       => false,
                                'created_at' => now()->toIso8601String()
                            ]
                        ],
                        'created_at'  => now()->toIso8601String(),
                        'updated_at'  => now()->toIso8601String(),
                    ]);
                }
            } catch (\Throwable $e) {
                // MongoDB seeder soft-fallback
            }
        }
    }
}
