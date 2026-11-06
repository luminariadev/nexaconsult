<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>NexaConsult - @yield('title', 'Autentikasi')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            --shadow: 0 10px 30px rgba(87, 30, 123, 0.12);
            --gradient-start: #FAF9FF;
            --gradient-end: #EBE8F7;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .auth-card {
            background-color: var(--card-bg);
            border-radius: 24px;
            padding: 42px 36px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .auth-logo {
            font-size: 30px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .auth-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            opacity: 0.85;
        }

        .auth-title {
            color: var(--text-primary);
            font-size: 22px;
            font-weight: 700;
            margin-top: 6px;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 13.5px;
        }

        .form-input {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            font-size: 14.5px;
            color: var(--text-secondary);
            background-color: #FAF9FD;
            font-family: inherit;
            transition: all 0.25s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent-color);
            background-color: #FFFFFF;
            box-shadow: 0 0 0 4px var(--accent-light);
        }

        .auth-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(126, 60, 169, 0.25);
            font-family: inherit;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(126, 60, 169, 0.35);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            font-size: 14px;
            color: var(--text-secondary);
        }

        .auth-link {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 700;
            margin-left: 4px;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #EF4444;
            font-size: 13px;
            margin-top: 4px;
            display: none;
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/auth.css', 'resources/js/app.js', 'resources/js/auth.js'])
    @else
        <script src="/js/auth.js" defer></script>
    @endif
</head>

<body>
    <div class="auth-container">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
