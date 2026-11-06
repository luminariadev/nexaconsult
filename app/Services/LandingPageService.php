<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use App\Models\LandingPage;
use Illuminate\Support\Str;

class LandingPageService
{
    protected ?Client $mongoClient = null;
    protected $collection = null;
    protected bool $useMongo = false;
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
        $this->initDriver();
    }

    protected function initDriver(): void
    {
        if (extension_loaded('mongodb')) {
            try {
                $uri = env('MONGODB_URI', 'mongodb://127.0.0.1:27017');
                $client = new Client($uri, [], ['serverSelectionTimeoutMS' => 800]);
                $client->listDatabases();
                $this->mongoClient = $client;
                $dbName = env('MONGODB_DATABASE', 'nexaconsult');
                $db = $this->mongoClient->selectDatabase($dbName);
                $this->collection = $db->selectCollection('landing_pages');
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

    /**
     * GENERATE LANDING PAGE HTML WITH AI
     */
    public function generateLandingPageHtml(string $title, string $description, string $themeColor = 'indigo', ?string $whatsapp = '081234567890', ?string $customPrompt = null): string
    {
        $cleanWa = preg_replace('/[^0-9]/', '', (string)$whatsapp);
        if (str_starts_with($cleanWa, '0')) {
            $cleanWa = '62' . substr($cleanWa, 1);
        }

        $systemPrompt = <<<SYS
Anda adalah Senior Full-stack Web Designer & Marketing Specialist spesialis landing page UMKM Indonesia dengan konversi tinggi (High-Converting Landing Page).
Tugas Anda adalah menghasilkan SATU FILE HTML LENGKAP & VALID yang siap tayang secara mandiri (standalone) dengan Tailwind CSS CDN.

ATURAN STRUKTUR:
1. Wajib gunakan Tailwind CSS CDN: <script src="https://cdn.tailwindcss.com"></script>
2. Wajib gunakan Google Fonts 'Plus Jakarta Sans' dan Font Awesome 6 atau Lucide Icon via CDN.
3. Struktur wajib:
   - Header / Navbar sticky dengan Logo brand, Link navigasi (Beranda, Keunggulan, Produk, Testimoni, FAQ), dan tombol CTA "Pesan Sekarang"
   - Hero Section: Headline memikat, Sub-headline, Badge kepercayaan, Tombol Pesan via WhatsApp (https://wa.me/{$cleanWa}), dan Mockup/Gambar ilustrasi relevan
   - Section Keunggulan / Value Proposition (3-4 kartu fitur unik)
   - Section Produk / Menu / Paket Harga (3 paket dengan badge "Paling Laris" pada paket tengah)
   - Section Testimoni Pelanggan (3 ulasan pembeli bintang 5 yang realistis)
   - Section FAQ (Tanya Jawab seputar pengiriman, halal/izin, rasa/kualitas)
   - Floating WhatsApp Action Button di pojok kanan bawah yang mengarah ke https://wa.me/{$cleanWa}?text=Halo%20saya%20tertarik%20dengan%20produk%20Anda
   - Footer profesional lengkap dengan hak cipta dan sosial media
4. Desain harus sangat estetik, modern, responsive (mobile-first), dan menggunakan aksen warna tema {$themeColor}.
5. JANGAN output markdown enclosing seperti ```html ... ``` jika memungkinkan, atau berikan kode HTML utuh yang valid mulai dari <!DOCTYPE html> hingga </html>.
SYS;

        $userPrompt = "Nama Bisnis / Usaha: {$title}\nDeskripsi Usaha: {$description}\nNomor WhatsApp: {$cleanWa}\nWarna Tema: {$themeColor}\n";
        if ($customPrompt) {
            $userPrompt .= "Permintaan Khusus Tambahan: {$customPrompt}\n";
        }
        $userPrompt .= "Buatkan landing page HTML berkelas tinggi untuk produk/usaha UMKM ini!";

        $htmlResult = '';
        try {
            $aiResponse = $this->aiService->consultOnly($userPrompt);
            if ($aiResponse) {
                // Extract HTML if wrapped in markdown
                if (preg_match('/```html\s*([\s\S]*?)\s*```/i', $aiResponse, $matches)) {
                    $htmlResult = trim($matches[1]);
                } elseif (stripos($aiResponse, '<!DOCTYPE html>') !== false || stripos($aiResponse, '<html') !== false) {
                    $htmlResult = trim($aiResponse);
                }
            }
        } catch (\Throwable $e) {
            $htmlResult = '';
        }

        // If AI generation is incomplete or empty, use our high quality fallback generator
        if (empty($htmlResult) || strlen($htmlResult) < 400 || stripos($htmlResult, '<body') === false) {
            $htmlResult = $this->buildFallbackHtml($title, $description, $themeColor, $cleanWa);
        }

        return $htmlResult;
    }

    /**
     * SAVE OR UPDATE LANDING PAGE
     */
    public function save(array $data)
    {
        $userId = (string) $data['user_id'];
        $title = $data['title'] ?? 'Landing Page Usaha';
        $slug = $data['slug'] ?? Str::slug($title);
        
        // Ensure slug is clean
        $slug = Str::slug($slug);
        if (empty($slug)) {
            $slug = 'site-' . Str::random(6);
        }

        $now = now()->toIso8601String();
        $recordData = [
            'user_id'         => $userId,
            'project_id'      => $data['project_id'] ?? null,
            'title'           => $title,
            'slug'            => $slug,
            'html_content'    => $data['html_content'],
            'theme_color'     => $data['theme_color'] ?? 'indigo',
            'whatsapp_number' => $data['whatsapp_number'] ?? null,
            'status'          => $data['status'] ?? 'published',
            'updated_at'      => $now,
        ];

        if ($this->useMongo && $this->collection) {
            $existing = $this->collection->findOne(['user_id' => $userId, 'slug' => $slug]);
            if ($existing) {
                $this->collection->updateOne(
                    ['_id' => $existing['_id']],
                    ['$set' => $recordData]
                );
                return $this->formatMongoDoc($this->collection->findOne(['_id' => $existing['_id']]));
            } else {
                $recordData['created_at'] = $now;
                $res = $this->collection->insertOne($recordData);
                $recordData['_id'] = (string) $res->getInsertedId();
                $recordData['id'] = $recordData['_id'];
                return $recordData;
            }
        }

        // Eloquent fallback
        $landingPage = LandingPage::updateOrCreate(
            ['user_id' => $userId, 'slug' => $slug],
            $recordData
        );

        $arr = $landingPage->toArray();
        $arr['_id'] = (string) $landingPage->id;
        $arr['id'] = (string) $landingPage->id;
        return $arr;
    }

    /**
     * FIND BY SLUG (PUBLIC AUTO-HOSTING)
     */
    public function findBySlug(string $slug)
    {
        if ($this->useMongo && $this->collection) {
            $doc = $this->collection->findOne(['slug' => $slug]);
            return $doc ? $this->formatMongoDoc($doc) : null;
        }

        $page = LandingPage::where('slug', $slug)->first();
        return $page ? $page->toArray() : null;
    }

    /**
     * FIND BY ID AND USER
     */
    public function findByIdAndUser($id, $userId)
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $doc = $this->collection->findOne(['_id' => $objId, 'user_id' => (string)$userId]);
            return $doc ? $this->formatMongoDoc($doc) : null;
        }

        $page = LandingPage::where('id', $id)->where('user_id', $userId)->first();
        return $page ? $page->toArray() : null;
    }

    /**
     * LIST BY USER
     */
    public function listByUser($userId): array
    {
        if ($this->useMongo && $this->collection) {
            $cursor = $this->collection->find(
                ['user_id' => (string) $userId],
                ['sort' => ['updated_at' => -1]]
            );
            $results = [];
            foreach ($cursor as $doc) {
                $results[] = $this->formatMongoDoc($doc);
            }
            return $results;
        }

        return LandingPage::where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toArray();
    }

    /**
     * LIST ALL (ADMIN)
     */
    public function listAll(): array
    {
        if ($this->useMongo && $this->collection) {
            $cursor = $this->collection->find([], ['sort' => ['created_at' => -1], 'limit' => 100]);
            $results = [];
            foreach ($cursor as $doc) {
                $results[] = $this->formatMongoDoc($doc);
            }
            return $results;
        }

        return LandingPage::orderBy('created_at', 'desc')->limit(100)->get()->toArray();
    }

    /**
     * COUNT TOTAL
     */
    public function countTotal(): int
    {
        if ($this->useMongo && $this->collection) {
            return $this->collection->countDocuments();
        }

        return LandingPage::count();
    }

    /**
     * DELETE
     */
    public function delete($id, $userId): bool
    {
        if ($this->useMongo && $this->collection) {
            try {
                $objId = new ObjectId($id);
            } catch (\Throwable $e) {
                $objId = $id;
            }
            $res = $this->collection->deleteOne(['_id' => $objId, 'user_id' => (string)$userId]);
            return $res->getDeletedCount() > 0;
        }

        $page = LandingPage::where('id', $id)->where('user_id', $userId)->first();
        return $page ? (bool) $page->delete() : false;
    }

    protected function formatMongoDoc($doc): array
    {
        $arr = (array) $doc;
        $arr['_id'] = (string) ($doc->_id ?? $doc['id'] ?? '');
        $arr['id'] = $arr['_id'];
        return $arr;
    }

    /**
     * FALLBACK HIGH CONVERTING TEMPLATE
     */
    protected function buildFallbackHtml(string $title, string $description, string $theme, string $wa): string
    {
        $safeTitle = htmlspecialchars($title);
        $safeDesc = htmlspecialchars($description);
        $waLink = "https://wa.me/{$wa}?text=" . urlencode("Halo, saya tertarik memesan produk {$title}!");

        return <<<HTML
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$safeTitle} - Website Resmi UMKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Header Navbar -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-md">
                    <i class="fa-solid fa-store text-lg"></i>
                </div>
                <div>
                    <span class="font-extrabold text-xl text-slate-900 tracking-tight block">{$safeTitle}</span>
                    <span class="text-xs text-indigo-600 font-semibold tracking-wider uppercase">Official UMKM Partner</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                <a href="#keunggulan" class="hover:text-indigo-600 transition">Keunggulan</a>
                <a href="#produk" class="hover:text-indigo-600 transition">Varian Produk</a>
                <a href="#testimoni" class="hover:text-indigo-600 transition">Testimoni</a>
                <a href="#faq" class="hover:text-indigo-600 transition">FAQ</a>
            </nav>
            <div>
                <a href="{$waLink}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-5 py-2.5 rounded-full shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5 text-sm">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                    <span>Order via WhatsApp</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-20 lg:py-28 bg-gradient-to-b from-indigo-50/70 via-white to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-100/80 border border-indigo-200 text-indigo-700 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>100% Produk Halal & Higienis Berkualitas</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 leading-[1.15]">
                        Cita Rasa Istimewa, <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Kualitas Pilihan</span> Keluarga Indonesia
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed max-w-xl">
                        {$safeDesc}
                    </p>
                    <div class="pt-2 flex flex-col sm:flex-row gap-4">
                        <a href="{$waLink}" target="_blank" class="inline-flex justify-center items-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-indigo-600/30 transition transform hover:-translate-y-1 text-base">
                            <i class="fa-brands fa-whatsapp text-xl"></i>
                            <span>Pesan Sekarang Langsung</span>
                        </a>
                        <a href="#produk" class="inline-flex justify-center items-center gap-2 bg-white hover:bg-slate-50 text-slate-800 border border-slate-300 font-semibold px-7 py-4 rounded-2xl shadow-sm transition text-base">
                            <span>Lihat Katalog Produk</span>
                            <i class="fa-solid fa-arrow-down text-sm"></i>
                        </a>
                    </div>
                    <div class="pt-4 flex items-center gap-6 text-sm text-slate-500 font-medium">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-shield-check text-emerald-500"></i> Teruji & Bersertifikat</div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-indigo-500"></i> Pengiriman Seluruh ID</div>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none rounded-3xl bg-gradient-to-tr from-indigo-600 to-purple-700 p-3 shadow-2xl shadow-indigo-500/25">
                        <div class="rounded-2xl bg-white p-8 text-center space-y-6">
                            <div class="w-20 h-20 mx-auto rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-3xl shadow-inner">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Penawaran Spesial Minggu Ini</span>
                                <h3 class="text-2xl font-extrabold text-slate-900">Diskon Bundling UMKM 25%</h3>
                                <p class="text-sm text-slate-500">Dapatkan kemasan premium dan bonus pengiriman ke area sekitar untuk pembelian pertama Anda.</p>
                            </div>
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-around text-center">
                                <div>
                                    <span class="block text-xl font-bold text-slate-900">100%</span>
                                    <span class="text-xs text-slate-500">Bahan Alami</span>
                                </div>
                                <div class="w-px h-8 bg-slate-200"></div>
                                <div>
                                    <span class="block text-xl font-bold text-slate-900">4.9/5</span>
                                    <span class="text-xs text-slate-500">Rating Pembeli</span>
                                </div>
                                <div class="w-px h-8 bg-slate-200"></div>
                                <div>
                                    <span class="block text-xl font-bold text-slate-900">1-2 Hari</span>
                                    <span class="text-xs text-slate-500">Pengiriman Cepat</span>
                                </div>
                            </div>
                            <a href="{$waLink}" target="_blank" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-600/20 transition">
                                <i class="fa-brands fa-whatsapp mr-2"></i> Klaim Promo via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan Section -->
    <section id="keunggulan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Mengapa Memilih Kami</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Kelebihan Produk {$safeTitle}</h2>
                <p class="text-slate-600">Dedikasi kami untuk memberikan mutu terbaik, rasa otentik, dan kepuasan pelanggan tanpa kompromi.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-indigo-300 hover:shadow-xl transition space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Bahan Baku Pilihan Segar</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Kami memilih bahan baku lokal terbaik langsung dari petani dan produsen terpercaya demi menjaga cita rasa alami yang autentik.</p>
                </div>
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-indigo-300 hover:shadow-xl transition space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 text-xl font-bold">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Kemasan Modern Higienis</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Diproses dengan standar higienis ketat serta kemasan tahan udara dan minyak agar kerenyahan dan kesegaran bertahan lama.</p>
                </div>
                <div class="p-8 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-indigo-300 hover:shadow-xl transition space-y-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl font-bold">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Pelayanan Ramah & Cepat</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">Respon cepat melalui WhatsApp, melayani pemesanan retail satuan, reseller partai besar, hingga pesanan katering khusus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Paket Produk -->
    <section id="produk" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Pilihan Paket Hemat</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Varian & Paket Paling Populer</h2>
                <p class="text-slate-600">Pilih paket yang paling cocok untuk konsumsi harian, keluarga, atau peluang usaha reseller.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                <!-- Paket 1 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="space-y-4">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Paket Coba-Coba</span>
                        <h3 class="text-2xl font-bold text-slate-900">Starter Pack</h3>
                        <div class="text-3xl font-extrabold text-slate-900">Rp 25.000 <span class="text-sm font-normal text-slate-500">/ 2 pack</span></div>
                        <ul class="space-y-2 text-sm text-slate-600 pt-4">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> 2 Varian Rasa Pilihan</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Kemasan Standing Pouch</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Cocok untuk tester harian</li>
                        </ul>
                    </div>
                    <div class="pt-8">
                        <a href="{$waLink}" target="_blank" class="block w-full py-3 rounded-xl border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold text-center text-sm transition">Pesan Paket Ini</a>
                    </div>
                </div>

                <!-- Paket 2 (Featured) -->
                <div class="bg-gradient-to-b from-indigo-600 to-purple-700 text-white rounded-3xl p-8 shadow-xl shadow-indigo-600/30 flex flex-col justify-between relative transform lg:-translate-y-3">
                    <span class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-amber-400 text-slate-900 text-xs font-extrabold uppercase rounded-full shadow-md tracking-wider">Paling Laris 🔥</span>
                    <div class="space-y-4">
                        <span class="text-xs font-bold text-indigo-200 uppercase tracking-widest">Paket Keluarga</span>
                        <h3 class="text-2xl font-bold text-white">Family Favorite Pack</h3>
                        <div class="text-3xl font-extrabold text-white">Rp 65.000 <span class="text-sm font-normal text-indigo-200">/ 6 pack</span></div>
                        <ul class="space-y-2 text-sm text-indigo-100 pt-4">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-300"></i> Komplit Semua Varian Rasa</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-300"></i> Kemasan ZipLock Ekstra Awet</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-300"></i> Bonus Stiker Eksklusif UMKM</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-amber-300"></i> Hemat Hingga 20%</li>
                        </ul>
                    </div>
                    <div class="pt-8">
                        <a href="{$waLink}" target="_blank" class="block w-full py-3.5 rounded-xl bg-white text-indigo-700 hover:bg-indigo-50 font-extrabold text-center text-sm transition shadow-md">Pesan Sekarang (Best Value)</a>
                    </div>
                </div>

                <!-- Paket 3 -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div class="space-y-4">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Peluang Usaha</span>
                        <h3 class="text-2xl font-bold text-slate-900">Paket Reseller UMKM</h3>
                        <div class="text-3xl font-extrabold text-slate-900">Rp 180.000 <span class="text-sm font-normal text-slate-500">/ 20 pack</span></div>
                        <ul class="space-y-2 text-sm text-slate-600 pt-4">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Harga Grosir Spesial Reseller</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Materi Foto & Video Promosi Siap Pakai</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Margin Keuntungan s/d 45%</li>
                        </ul>
                    </div>
                    <div class="pt-8">
                        <a href="{$waLink}" target="_blank" class="block w-full py-3 rounded-xl border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold text-center text-sm transition">Daftar Jadi Reseller</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni Section -->
    <section id="testimoni" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Testimoni Pelanggan</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Kata Mereka Tentang Kami</h2>
                <p class="text-slate-600">Ratusan pelanggan setia telah merasakan nikmatnya produk buatan tangan kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="text-amber-400 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-slate-600 text-sm italic">"Rasa bumbunya beneran nempel dan nggak bikin seret di tenggorokan. Cocok banget buat nemenin ngerjain tugas kampus!"</p>
                    <div class="pt-2 font-bold text-slate-900 text-sm">- Anisa Rahma, Mahasiswi</div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="text-amber-400 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-slate-600 text-sm italic">"Kemasan rapi banget, zip locknya kencang. Udah order 3 kali buat stok camilan di kantor bareng teman-teman."</p>
                    <div class="pt-2 font-bold text-slate-900 text-sm">- Budi Santoso, Karyawan Swasta</div>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="text-amber-400 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-slate-600 text-sm italic">"Gabung reseller 2 minggu yang lalu dan langsung laku 40 bungkus di arisan warga. Sangat menguntungkan!"</p>
                    <div class="pt-2 font-bold text-slate-900 text-sm">- Ibu Siti Maryam, Owner Warung</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center space-y-2">
                <h2 class="text-3xl font-extrabold text-slate-900">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-slate-600 text-sm">Informasi seputar pemesanan dan pengiriman produk kami.</p>
            </div>
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-base">Berapa lama masa simpan produk?</h4>
                    <p class="text-slate-600 text-sm">Produk kami tahan hingga 3-6 bulan pada suhu ruang dalam kondisi kemasan tertutup rapat tanpa bahan pengawet kimia berbahaya.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-base">Bagaimana cara pembayarannya?</h4>
                    <p class="text-slate-600 text-sm">Kami menerima transfer bank lokal (BCA, Mandiri, BRI, BNI) serta e-wallet (GoPay, OVO, Dana, ShopeePay, dan QRIS) setelah konfirmasi pesanan di WhatsApp.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-base">Apakah melayani pengiriman luar kota?</h4>
                    <p class="text-slate-600 text-sm">Tentu saja! Kami bekerja sama dengan JNE, J&T, SiCepat, dan Paxel dengan packing bubble wrap tebal dan kardus pengaman.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
            <div class="flex items-center justify-center gap-2 text-white font-extrabold text-xl">
                <i class="fa-solid fa-store text-indigo-400"></i>
                <span>{$safeTitle}</span>
            </div>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                Website UMKM Resmi yang dibuat & di-hosting otomatis via Platform NexaConsult.
            </p>
            <div class="pt-4 text-xs text-slate-600">
                &copy; {$safeTitle} " . date('Y') . ". All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="{$waLink}" target="_blank" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold px-5 py-3.5 rounded-full shadow-2xl shadow-emerald-500/50 transition transform hover:scale-105" title="Chat dengan Penjual di WhatsApp">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
        <span class="hidden sm:inline text-sm font-semibold">Tanya / Pesan di WA</span>
    </a>

</body>
</html>
HTML;
    }
}
