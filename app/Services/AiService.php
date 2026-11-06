<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    protected string $primaryEndpoint;
    protected string $apiKey;
    protected string $model;
    protected string $ollamaEndpoint;

    public function __construct()
    {
        $this->primaryEndpoint = env('AI_BASE_URL', 'http://127.0.0.1:20128/api/v1') . '/chat/completions';
        $this->apiKey = env('AI_API_KEY', '');
        $this->model = env('AI_MODEL', 'mr-loverman');
        $this->ollamaEndpoint = env('OLLAMA_ENDPOINT', 'http://127.0.0.1:11434/api/generate');
    }

    /**
     * MODE 1 — KONSULTASI INTERAKTIF UMKM
     */
    public function consultOnly(string $userPrompt, ?string $context = null): string
    {
        $systemPrompt = "Anda adalah NexaConsult AI, asisten konsultan bisnis digital pintar khusus untuk pelaku UMKM (Usaha Mikro, Kecil, dan Menengah) di Indonesia.\n"
            . "Tugas Anda: Berikan analisa taktis, saran praktis, langkah nyata, estimasi atau pertimbangan biaya/operasional, serta strategi pemasaran digital (seperti TikTok, Instagram, WhatsApp, e-commerce) yang relevan dan aplikatif.\n"
            . "Format jawaban: Gunakan Markdown yang rapi (bolding, poin-poin terstruktur, paragraf ringkas dan berbobot).\n"
            . "Di akhir pesan Anda, SELALU tambahkan kalimat ajakan singkat: '💡 *Jika Anda ingin saya menyusun rencana roadmap proyek bisnis ini secara terstruktur, cukup balas dengan: **ya***'.";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        if ($context) {
            $messages[] = ['role' => 'user', 'content' => "Konteks ide bisnis saya sebelumnya: " . $context];
            $messages[] = ['role' => 'assistant', 'content' => "Baik, saya memahami konteks bisnis Anda sebelumnya."];
        }

        $messages[] = ['role' => 'user', 'content' => $userPrompt];

        $response = $this->query9Router($messages, 0.7);

        if ($response && trim($response) !== '') {
            return $response;
        }

        // Fallback ke Ollama
        $ollamaResponse = $this->queryOllama($systemPrompt . "\n\n" . ($context ? "Konteks: $context\n" : "") . "Pertanyaan: " . $userPrompt);
        if ($ollamaResponse && trim($ollamaResponse) !== '') {
            return $ollamaResponse;
        }

        // Fallback ke Expert Knowledge Engine Offline
        return $this->getSmartOfflineConsultation($userPrompt);
    }

    /**
     * MODE 2 — GENERATE STRUKTUR PROYEK (ROADMAP)
     */
    public function generateProject(string $userPrompt): array
    {
        $systemPrompt = "Anda adalah perancang roadmap bisnis UMKM profesional.\n"
            . "Tugas: Buat rencana eksekusi bisnis yang konkret berdasarkan ide pengguna.\n"
            . "Keluarkan HANYA JSON murni tanpa pembuka/penutup markdown seperti ```json.\n"
            . "Format JSON:\n"
            . "{\n"
            . "  \"title\": \"Nama Proyek Bisnis yang Menarik\",\n"
            . "  \"summary\": \"Ringkasan eksekutif strategi bisnis, nilai jual unik (USP), dan target pasar (2-3 paragraf).\",\n"
            . "  \"tasks\": [\n"
            . "    \"Langkah 1: Riset dan validasi pasar\",\n"
            . "    \"Langkah 2: Legalitas & Perizinan (NIB / PIRT / Halal jika F&B)\",\n"
            . "    \"Langkah 3: Pembuatan sample/prototype dan uji rasa/kualitas\",\n"
            . "    \"Langkah 4: Branding, packaging & identitas visual\",\n"
            . "    \"Langkah 5: Penentuan HPP, margin laba & strategi harga\",\n"
            . "    \"Langkah 6: Setup kanal penjualan (Instagram, TikTok Shop, WhatsApp Business)\",\n"
            . "    \"Langkah 7: Kampanye peluncuran & promosi pre-order\"\n"
            . "  ]\n"
            . "}";

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => "Ide bisnis UMKM: " . $userPrompt]
        ];

        $response = $this->query9Router($messages, 0.4);

        if ($response) {
            $json = $this->extractJson($response);
            if ($json && isset($json['title']) && isset($json['tasks']) && is_array($json['tasks'])) {
                return $json;
            }
        }

        return $this->createProjectFromPrompt($userPrompt);
    }

    /**
     * FITUR TAMBAHAN AI 1: EXPAND / SUGGEST TASKS UNTUK PROYEK
     */
    public function expandProjectTasks(string $projectName, string $summary, array $existingTasks): array
    {
        $existingList = implode("\n- ", array_map(fn($t) => is_array($t) ? ($t['task'] ?? '') : (string)$t, $existingTasks));

        $prompt = "Berikut adalah proyek UMKM:\n"
            . "Judul: $projectName\n"
            . "Ringkasan: $summary\n"
            . "Task yang sudah ada:\n- $existingList\n\n"
            . "Buatkan 5 langkah taktis/milestone baru yang belum ada dalam daftar di atas agar bisnis makin berkembang pesat (misal: scaling, digital marketing, pembukuan keuangan, retensi pelanggan, sertifikasi).\n"
            . "Output HANYA JSON array string: [\"Task 1\", \"Task 2\", \"Task 3\", \"Task 4\", \"Task 5\"].";

        $messages = [
            ['role' => 'system', 'content' => 'Anda adalah konsultan operasional bisnis UMKM. Balas hanya JSON array murni.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $response = $this->query9Router($messages, 0.5);

        if ($response) {
            $json = $this->extractJson($response);
            if (is_array($json) && count($json) > 0) {
                return array_values($json);
            }
        }

        // Fallback default expansion
        return [
            "Penyusunan Standard Operating Procedure (SOP) operasional harian",
            "Pencatatan pembukuan kas masuk & kas keluar menggunakan aplikasi digital",
            "Pembuatan program loyalitas pelanggan (diskon member / promo bundling)",
            "Optimasi profil Google Business Profile untuk menjaring pelanggan lokal",
            "Eksplorasi kerjasama endorsement dengan nano/micro-influencer relevan"
        ];
    }

    /**
     * FITUR TAMBAHAN AI 2: SWOT ANALYSIS
     */
    public function generateSwotAnalysis(string $projectName, string $summary): array
    {
        $prompt = "Buatkan Analisis SWOT (Strengths, Weaknesses, Opportunities, Threats) yang komprehensif untuk proyek bisnis UMKM ini:\n"
            . "Nama Bisnis: $projectName\n"
            . "Ringkasan Bisnis: $summary\n\n"
            . "Output HANYA JSON format berikut:\n"
            . "{\n"
            . "  \"strengths\": [\"Kekuatan 1\", \"Kekuatan 2\", \"Kekuatan 3\"],\n"
            . "  \"weaknesses\": [\"Kelemahan 1\", \"Kelemahan 2\", \"Kelemahan 3\"],\n"
            . "  \"opportunities\": [\"Peluang 1\", \"Peluang 2\", \"Peluang 3\"],\n"
            . "  \"threats\": [\"Ancaman 1\", \"Ancaman 2\", \"Ancaman 3\"],\n"
            . "  \"action_recommendations\": [\"Saran Taktis 1\", \"Saran Taktis 2\"]\n"
            . "}";

        $messages = [
            ['role' => 'system', 'content' => 'Anda adalah analis strategi bisnis UMKM. Balas hanya JSON valid murni.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $response = $this->query9Router($messages, 0.4);

        if ($response) {
            $json = $this->extractJson($response);
            if ($json && isset($json['strengths'])) {
                return $json;
            }
        }

        // Fallback SWOT
        return [
            'strengths' => [
                'Produk fleksibel dan mudah disesuaikan dengan selera pasar lokal',
                'Biaya operasional awal relatif efisien dan adaptif',
                'Pelayanan yang lebih personal dan dekat dengan konsumen'
            ],
            'weaknesses' => [
                'Kapasitas produksi awal masih terbatas',
                'Keterbatasan anggaran promosi skala besar',
                'Sistem operasional dan pencatatan kas belum sepenuhnya otomatis'
            ],
            'opportunities' => [
                'Tingginya penetrasi belanja online lewat media sosial (TikTok & Instagram)',
                'Tren dukungan masyarakat terhadap produk lokal / buatan UMKM',
                'Peluang kolaborasi dengan sesama pelaku usaha kreatif di kota setempat'
            ],
            'threats' => [
                'Kompetitor dengan modal lebih besar yang meniru produk',
                'Fluktuasi harga bahan baku di pasar',
                'Perubahan cepat pada tren preferensi konsumen'
            ],
            'action_recommendations' => [
                'Kuatkan keunikan produk (branding storytelling) agar tidak mudah di-copy pesaing',
                'Kunci harga dengan supplier bahan baku jangka menengah',
                'Bangun komunitas pelanggan setia via WhatsApp Business'
            ]
        ];
    }

    /**
     * FITUR TAMBAHAN AI 3: MARKETING PITCH & SOCIAL MEDIA HOOK GENERATOR
     */
    public function generateMarketingPitch(string $projectName, string $summary): array
    {
        $prompt = "Buatkan materi promosi marketing untuk bisnis UMKM ini:\n"
            . "Nama Bisnis: $projectName\n"
            . "Ringkasan: $summary\n\n"
            . "Output HANYA JSON format berikut:\n"
            . "{\n"
            . "  \"elevator_pitch\": \"Pitch singkat 30 detik untuk memperkenalkan bisnis ke calon mitra/investor/pelanggan\",\n"
            . "  \"tiktok_hook\": \"Ide video TikTok/Reels beserta hook 3 detik pertama yang bikin penasaran\",\n"
            . "  \"instagram_caption\": \"Draft caption Instagram siap posting lengkap dengan copywriting dan hashtag relevan\",\n"
            . "  \"whatsapp_broadcast\": \"Pesan broadcast WhatsApp ramah untuk menawarkan produk ke kontak pelanggan\"\n"
            . "}";

        $messages = [
            ['role' => 'system', 'content' => 'Anda adalah copywriter dan digital marketing strategist spesialis UMKM. Output hanya JSON murni.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $response = $this->query9Router($messages, 0.7);

        if ($response) {
            $json = $this->extractJson($response);
            if ($json && isset($json['elevator_pitch'])) {
                return $json;
            }
        }

        return [
            'elevator_pitch' => "$projectName hadir menghadirkan solusi berkualitas dengan sentuhan personal untuk memenuhi kebutuhan gaya hidup Anda dengan harga yang jujur dan bersahabat.",
            'tiktok_hook' => "POV: Kamu baru nemu produk lokal yang kualitasnya setara brand luar tapi harganya ramah kantong! Jangan di-skip ya!",
            'instagram_caption' => "Kualitas terbaik nggak harus bikin kantong bolong! Kenalan yuk sama $projectName ✨ Dibuat dengan dedikasi penuh untuk kamu yang mengutamakan mutu. Klik link di bio untuk order sekarang! #UMKMIndonesia #BanggaBuatanIndonesia #ProdukLokal",
            'whatsapp_broadcast' => "Halo kak! Kabar gembira dari $projectName ✨ Khusus minggu ini kami ada promo spesial untuk pelanggan setia. Yuk intip katalog kami sekarang, kuota promo terbatas lho kak!"
        ];
    }

    /**
     * FITUR TAMBAHAN AI 4: REGENERATE SUMMARY & STRATEGY
     */
    public function regenerateStrategySummary(string $projectName, string $currentSummary, ?string $instruction = null): string
    {
        $prompt = "Perbarui dan tingkatkan ringkasan strategi bisnis UMKM berikut ini:\n"
            . "Nama: $projectName\n"
            . "Ringkasan Saat Ini: $currentSummary\n"
            . ($instruction ? "Instruksi Khusus dari Pemilik Bisnis: $instruction\n" : "")
            . "Buatlah ringkasan eksekutif baru yang lebih tajam, profesional, realistis, dan berorientasi pada profitabilitas serta ekspansi pasar (2-3 paragraf ringkas).";

        $messages = [
            ['role' => 'system', 'content' => 'Anda adalah konsultan senior strategi bisnis UMKM.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $response = $this->query9Router($messages, 0.6);

        if ($response && trim($response) !== '') {
            return trim($response);
        }

        return "$projectName adalah bisnis UMKM yang berfokus pada diferensiasi produk unggul dan kepuasan konsumen. Dengan mengoptimalkan efisiensi rantai pasok dan memaksimalkan kanal pemasaran digital interaktif, bisnis ini diposisikan untuk mencapai pertumbuhan pendapatan yang stabil dan margin keuntungan yang sehat.";
    }

    /**
     * Core Query ke 9Router OpenAI-compatible API
     */
    protected function query9Router(array $messages, float $temperature = 0.7, int $timeout = 35): ?string
    {
        try {
            $res = Http::timeout($timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ])
                ->post($this->primaryEndpoint, [
                    'model'       => $this->model,
                    'messages'    => $messages,
                    'temperature' => $temperature,
                    'stream'      => false
                ]);

            if ($res->ok()) {
                $body = $res->json();
                return $body['choices'][0]['message']['content'] ?? null;
            }
        } catch (\Exception $e) {
            Log::warning("9Router call failed: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Fallback Query ke Ollama lokal
     */
    protected function queryOllama(string $prompt, int $timeout = 25): ?string
    {
        try {
            $res = Http::timeout($timeout)->post($this->ollamaEndpoint, [
                'model'  => 'qwen2.5:7b',
                'prompt' => $prompt,
                'stream' => false
            ]);

            if ($res->ok()) {
                $body = $res->json();
                return $body['response'] ?? null;
            }
        } catch (\Exception $e) {
            // Silently pass
        }

        return null;
    }

    /**
     * Helper Ekstraksi JSON dari teks AI
     */
    protected function extractJson(string $text)
    {
        $clean = trim($text);

        // Bersihkan markdown backticks ```json ... ```
        if (preg_match('/```(?:json)?\s*([\s\S]*?)\s*```/', $clean, $codeBlock)) {
            $clean = trim($codeBlock[1]);
        }

        $decoded = json_decode($clean, true);
        if ($decoded !== null) {
            return $decoded;
        }

        // Cari kurung kurawal pertama hingga terakhir
        $start = strpos($clean, '{');
        $end = strrpos($clean, '}');
        if ($start !== false && $end !== false && $end > $start) {
            $sub = substr($clean, $start, $end - $start + 1);
            $decoded = json_decode($sub, true);
            if ($decoded !== null) return $decoded;
        }

        // Cari bracket array
        $startArr = strpos($clean, '[');
        $endArr = strrpos($clean, ']');
        if ($startArr !== false && $endArr !== false && $endArr > $startArr) {
            $sub = substr($clean, $startArr, $endArr - $startArr + 1);
            $decoded = json_decode($sub, true);
            if ($decoded !== null) return $decoded;
        }

        return null;
    }

    /**
     * Smart Rule-Engine Offline Konsultasi
     */
    protected function getSmartOfflineConsultation(string $prompt): string
    {
        $p = strtolower($prompt);
        $type = $this->detectBusinessType($prompt);

        $tips = [
            'kuliner' => "### 🍲 Rekomendasi Bisnis Kuliner (F&B) UMKM\n\n"
                . "1. **Kualitas Rasa & Konsistensi HPP:** Pastikan kalkulasi *Food Cost* tidak melebihi 35-40% dari harga jual agar cashflow aman.\n"
                . "2. **Higienitas & Legalitas:** Segera urus NIB via OSS (gratis & instan) dan sertifikasi Halal Self-Declare melalui Kemenag.\n"
                . "3. **Visual Media Sosial:** Rekam proses memasak yang bersih (*behind the scenes*) dan upload ke TikTok & Instagram Reels untuk menciptakan *food craving*.",
            
            'fashion' => "### 👗 Rekomendasi Bisnis Fashion & Apparel UMKM\n\n"
                . "1. **Tentukan Niche & USP:** Jangan menjual untuk semua orang. Fokus pada segmen spesifik (misal: hijab kasual harian, oversized streetwear, atau busana kerja ramah wudhu).\n"
                . "2. **Foto & Video Lookbook:** Manfaatkan cahaya alami (*golden hour*) untuk foto katalog produk yang jernih dan berkelas.\n"
                . "3. **Sistem Pre-Order (PO):** Di tahap awal, gunakan sistem PO atau produksi batch kecil untuk meminimalisir risiko penumpukan stok *dead stock*.",

            'jasa' => "### 🛠️ Rekomendasi Bisnis Jasa & Layanan UMKM\n\n"
                . "1. **Paketkan Layanan (*Productized Service*):** Buat 3 tingkatan paket harga (Basic, Standard, Pro) yang jelas fitur dan waktu pengerjaannya.\n"
                . "2. **Kekuatan Testimoni & Portofolio:** Tampilkan hasil pengerjaan nyata (*before-after*) dan testimoni kepuasan klien di media sosial dan Google Profile.\n"
                . "3. **Responsivitas WhatsApp:** 80% konversi jasa terjadi di chat. Siapkan *quick replies* (template balasan cepat) yang sopan dan solutif.",

            'digital' => "### 📱 Rekomendasi Bisnis Digital & Toko Online UMKM\n\n"
                . "1. **Kuasai Satu Kanal Terlebih Dahulu:** Maksimalkan TikTok Shop atau Shopee sebelum menyebar ke platform lain.\n"
                . "2. **Content Marketing Organik:** Buat konten edukasi, tips, atau *problem solving* yang relevan dengan calon pembeli Anda.\n"
                . "3. **Manajemen Retensi:** Berikan kartu terima kasih (*thank you card*) berhadiah voucher repeat order di dalam paket kiriman."
        ];

        $output = $tips[$type] ?? (
            "### 🚀 Rekomendasi Pengembangan Bisnis UMKM\n\n"
            . "1. **Validasi Kebutuhan Pasar:** Pastikan produk/layanan Anda benar-benar menyelesaikan masalah nyata yang dihadapi calon pelanggan.\n"
            . "2. **Pengelolaan Arus Kas Terpisah:** Jangan pernah mencampurkan rekening pribadi dengan rekening usaha.\n"
            . "3. **Manfaatkan Ekosistem Digital:** Daftarkan lokasi usaha Anda di Google Maps dan aktifkan WhatsApp Business."
        );

        return $output . "\n\n💡 *Jika Anda ingin saya menyusun rencana roadmap proyek bisnis ini secara terstruktur, cukup balas dengan: **ya***";
    }

    protected function createProjectFromPrompt(string $prompt): array
    {
        $businessType = $this->detectBusinessType($prompt);
        $tasks = $this->generateTasksByBusinessType($businessType, $prompt);

        return [
            "title"   => "Proyek Bisnis " . ucfirst($businessType) . " Sukses",
            "summary" => "Rencana eksekusi dan peluncuran bisnis UMKM berbasis ide: " . substr($prompt, 0, 120) . "...",
            "tasks"   => $tasks
        ];
    }

    protected function detectBusinessType(string $prompt): string
    {
        $prompt = strtolower($prompt);

        if (preg_match('/makan|minum|kopi|cafe|resto|kuliner|snack|kue|keripik|roti|dapur|catering/i', $prompt)) {
            return 'kuliner';
        } elseif (preg_match('/baju|kaos|hijab|fashion|pakaian|sepatu|tas|butik|jahit/i', $prompt)) {
            return 'fashion';
        } elseif (preg_match('/jasa|servis|service|laundry|cuci|desain|bengkel|konsultan|kursus|fotografi/i', $prompt)) {
            return 'jasa';
        } elseif (preg_match('/online|digital|web|aplikasi|ecommerce|toko online|dropship|reseller/i', $prompt)) {
            return 'digital';
        }

        return 'usaha';
    }

    protected function generateTasksByBusinessType(string $type, string $prompt): array
    {
        switch ($type) {
            case 'kuliner':
                return [
                    "Riset menu favorit dan benchmark harga kompetitor terdekat",
                    "Uji coba resep (food testing) ke 20 responden dan perbaiki feedback",
                    "Pengurusan perizinan dasar NIB dan pendaftaran Sertifikasi Halal Kemenag",
                    "Penyusunan Standard Recipe & perhitungan Food Cost (HPP per porsi)",
                    "Desain kemasan higienis, menarik, dan aman untuk pengiriman delivery",
                    "Pendaftaran merchant di GrabFood / GoFood / ShopeeFood",
                    "Kampanye launching promosi 'Beli 1 Gratis 1' untuk menarik antrean pertama"
                ];
            case 'fashion':
                return [
                    "Menentukan target persona konsumen dan niche gaya busana",
                    "Mencari supplier bahan kain terpercaya dan penjahit konveksi berkualitas",
                    "Membuat 3 sample prototype model pakaian perdana",
                    "Sesi photoshoot katalog produk dengan model dan pencahayaan studio",
                    "Setup katalog Instagram Shopping dan etalase TikTok Shop",
                    "Menyiapkan packaging box cantik beserta kartu ucapan dan stiker brand",
                    "Peluncuran sistem pre-order perdana dengan penawaran free ongkir"
                ];
            case 'jasa':
                return [
                    "Merumuskan spesifikasi layanan dan paket harga yang transparan",
                    "Menyiapkan portofolio pengerjaan terbaik dalam format PDF dan web/sosmed",
                    "Menyiapkan peralatan kerja dan tools pendukung standar profesional",
                    "Membuat akun WhatsApp Business lengkap dengan jam operasional & catalog",
                    "Menyiapkan SOP penerimaan order, alur kerja, hingga serah terima hasil",
                    "Menawarkan jasa gratis/diskon 50% ke 3 klien awal untuk mendapatkan ulasan bintang 5",
                    "Membuat program rujukan (referral program): komisi bagi yang merekomendasikan"
                ];
            case 'digital':
                return [
                    "Analisis tren kata kunci pencarian produk di marketplace dan Google",
                    "Setup toko resmi di platform e-commerce dan integrasikan pembayaran digital",
                    "Membuat konten video edukasi dan demonstrasi keunggulan produk",
                    "Penyusunan SOP penanganan chat customer service dan pengemasan pesanan",
                    "Menerapkan strategi review bintang 5 dengan follow-up purnajual ramah",
                    "Aktivasi iklan digital beranggaran kecil (Meta Ads / TikTok Ads) untuk tes pasar"
                ];
            default:
                return [
                    "Analisis keunggulan produk dan validasi kebutuhan pasar target",
                    "Perhitungan modal awal, biaya operasional bulanan, dan titik impas (BEP)",
                    "Pengurusan legalitas dasar usaha (NIB) secara mandiri",
                    "Pembuatan identitas brand (Logo, warna khas, dan tagline menarik)",
                    "Menentukan saluran distribusi dan titik penjualan utama",
                    "Peluncuran promosi perkenalan ke jejaring komunitas dan media sosial",
                    "Evaluasi kepuasan pembeli gelombang pertama dan penyempurnaan produk"
                ];
        }
    }
}
