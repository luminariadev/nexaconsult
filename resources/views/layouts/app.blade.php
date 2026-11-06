<!DOCTYPE html>
<html lang="id" class="theme-light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="manifest" href="/pwa/manifest.json">
    <meta name="theme-color" content="#7E3CA9">
    <link rel="apple-touch-icon" href="/pwa/icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Google Fonts & SweetAlert2 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>NexaConsult - @yield('title', 'Platform AI Konsultasi & Roadmap Bisnis UMKM')</title>

    <!-- CSS Variables & Base Styles -->
    <style>
        :root {
            --bg-primary: #F4F3FA;
            --text-primary: #3C1B63;
            --bg-secondary: #FFFFFF;
            --text-secondary: #4A5568;
            --card-bg: #FFFFFF;
            --accent-color: #7E3CA9;
            --accent-hover: #672B8D;
            --accent-light: #F2E8FA;
            --border-color: #E2E0F0;
            --shadow: 0 4px 20px rgba(87, 30, 123, 0.08);
            --shadow-hover: 0 8px 30px rgba(87, 30, 123, 0.14);
            --gradient-start: #FAF9FF;
            --gradient-end: #EBE8F7;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
        }

        body.theme-dark {
            --bg-primary: #0F0F1A;
            --text-primary: #D4B2FF;
            --bg-secondary: #171626;
            --text-secondary: #CBD5E1;
            --card-bg: #1A192E;
            --accent-color: #A855F7;
            --accent-hover: #9333EA;
            --accent-light: #2D1B4E;
            --border-color: #2D2B4A;
            --shadow: 0 4px 25px rgba(0, 0, 0, 0.5);
            --shadow-hover: 0 8px 35px rgba(0, 0, 0, 0.7);
            --gradient-start: #0F0F1A;
            --gradient-end: #171626;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: var(--text-secondary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        main {
            flex: 1;
            padding: 24px 20px;
            max-width: 1240px;
            margin: 0 auto;
            width: 100%;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.03);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(126, 60, 169, 0.25);
            border-radius: 999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(126, 60, 169, 0.45);
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/protect.js'])
    @else
        <script src="/js/protect.js" defer></script>
    @endif

    @stack('styles')
</head>

<body>
    @if (!request()->is('admin*'))
        <div id="adminUserPreviewBanner" style="display: none; background: #fffbeb; border-bottom: 1px solid #fde68a; color: #92400e; padding: 7px 16px; font-size: 12.5px; font-weight: 600; text-align: center; position: sticky; top: 0; z-index: 1002;">
            <span>👑 <strong>Mode Pratinjau Pengguna:</strong> Anda masuk sebagai Administrator. Halaman ini adalah simulasi tampilan sisi pengguna UMKM.</span>
            <a href="/admin" style="margin-left: 12px; color: #b45309; font-weight: 800; text-decoration: underline;">Kembali ke Admin Panel &rarr;</a>
        </div>
    @endif

    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>

</html>
