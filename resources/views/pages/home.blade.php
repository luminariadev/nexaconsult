@extends('layouts.app')

@section('title', 'Home - NexaConsult')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="hero-badge">
                <svg class="badge-icon" viewBox="0 0 24 24">
                    <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" fill="none" />
                </svg>
                <span>AI-Powered Platform</span>
            </div>

            <h1 class="hero-title">
                Selamat Datang di <span class="gradient-text">NexaConsult</span>
            </h1>

            <p class="hero-subtitle">
                Platform AI untuk membantu mengembangkan ide bisnis dan mengelola usaha dengan lebih efektif
            </p>

            <div class="hero-buttons">
                <a href="/chatbot" class="btn btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24">
                        <path
                            d="M12 19V22M8 19V22M16 19V22M18 16H6C4.895 16 4 15.105 4 14V6C4 4.895 4.895 4 6 4H18C19.105 4 20 4.895 20 6V14C20 15.105 19.105 16 18 16Z"
                            stroke="currentColor" stroke-width="2" fill="none" />
                        <circle cx="9" cy="10" r="1" fill="currentColor" />
                        <circle cx="15" cy="10" r="1" fill="currentColor" />
                    </svg>
                    <span>Mulai Konsultasi</span>
                </a>
                <a href="#features" class="btn btn-outline">
                    <svg class="btn-icon" viewBox="0 0 24 24">
                        <path
                            d="M12 6V4M12 20v-2M6 12H4M20 12h-2M7.05 7.05l-1.41 1.41M17.66 17.66l-1.41 1.41M7.05 16.95l-1.41-1.41M17.66 6.34l-1.41-1.41"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none" />
                    </svg>
                    <span>Lihat Fitur</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="section-header">
            <h2 class="section-title">Fitur Utama</h2>
            <p class="section-subtitle">Kemudahan dalam mengelola bisnis Anda</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 19V22M8 19V22M16 19V22M18 16H6C4.895 16 4 15.105 4 14V6C4 4.895 4.895 4 6 4H18C19.105 4 20 4.895 20 6V14C20 15.105 19.105 16 18 16Z"
                            stroke="currentColor" stroke-width="2" fill="none" />
                        <circle cx="9" cy="10" r="1" fill="currentColor" />
                        <circle cx="15" cy="10" r="1" fill="currentColor" />
                    </svg>
                </div>
                <h3>Konsultasi AI</h3>
                <p>Dapatkan saran dan ide bisnis dari asisten AI</p>
                <a href="/chatbot" class="feature-link">
                    <span>Coba Sekarang</span>
                    <svg viewBox="0 0 24 24">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"
                            stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                </div>
                <h3>Manajemen Proyek</h3>
                <p>Kelola dan pantau perkembangan bisnis Anda</p>
                <a href="/project" class="feature-link">
                    <span>Kelola Proyek</span>
                    <svg viewBox="0 0 24 24">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none" />
                        <path d="M5 21v-2a7 7 0 0114 0v2" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                </div>
                <h3>Pengaturan Lengkap</h3>
                <p>Sesuaikan pengalaman Anda dengan berbagai opsi</p>
                <a href="/profile" class="feature-link">
                    <span>Lihat Profil</span>
                    <svg viewBox="0 0 24 24">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="workflow-section">
        <div class="section-header">
            <h2 class="section-title">Cara Kerjanya</h2>
            <p class="section-subtitle">Mulai dalam beberapa langkah mudah</p>
        </div>

        <div class="workflow-steps">
            <div class="step">
                <div class="step-number">1</div>
                <h4>Login / Register</h4>
                <p>Masuk atau daftar akun untuk memulai</p>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <h4>Konsultasi AI</h4>
                <p>Gunakan chatbot untuk ide dan saran bisnis</p>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <h4>Kelola Proyek</h4>
                <p>Buat dan atur proyek bisnis dengan mudah</p>
            </div>

            <div class="step">
                <div class="step-number">4</div>
                <h4>Pantau Perkembangan</h4>
                <p>Lihat kemajuan bisnis Anda kapan saja</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Siap Memulai?</h2>
            <p>Bergabunglah dengan NexaConsult hari ini</p>
            <div class="cta-buttons">
                <a href="/register" class="btn btn-primary">
                    <svg class="btn-icon" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <span>Daftar Gratis</span>
                </a>
                <a href="/login" class="btn btn-outline">
                    <svg class="btn-icon" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" stroke="currentColor" stroke-width="2"
                            fill="none" />
                        <path d="M10 17l5-5-5-5" stroke="currentColor" stroke-width="2" fill="none" />
                        <path d="M15 12H3" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <span>Masuk Sekarang</span>
                </a>
            </div>
        </div>
    </section>

    <style>
        /* ===== BASE STYLES ===== */
        .hero-section {
            padding: 40px 20px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 16px;
            margin: 20px 0 40px;
            text-align: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--card-bg);
            padding: 8px 16px;
            border-radius: 20px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .badge-icon {
            width: 16px;
            height: 16px;
        }

        .hero-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 32px;
            line-height: 1.6;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            box-shadow: 0 4px 12px rgba(126, 60, 169, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(126, 60, 169, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-outline:hover {
            background: var(--accent-color);
            color: white;
        }

        .btn-icon {
            width: 18px;
            height: 18px;
        }

        /* ===== SECTIONS ===== */
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .features-section,
        .workflow-section,
        .cta-section {
            margin-bottom: 60px;
        }

        /* ===== FEATURES ===== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 32px 24px;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-color);
        }

        .feature-icon {
            width: 64px;
            height: 64px;
            background: var(--bg-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--accent-color);
        }

        .feature-icon svg {
            width: 28px;
            height: 28px;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .feature-card p {
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .feature-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .feature-link svg {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }

        .feature-link:hover svg {
            transform: translateX(4px);
        }

        /* ===== WORKFLOW ===== */
        .workflow-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .step {
            text-align: center;
            padding: 24px;
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
        }

        .step-number {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 auto 16px;
        }

        .step h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .step p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* ===== CTA SECTION ===== */
        .cta-section {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            border-radius: 16px;
            padding: 48px 24px;
            text-align: center;
        }

        .cta-content h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 12px;
        }

        .cta-content p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 500px;
            margin: 0 auto 32px;
            line-height: 1.5;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-section .btn-primary {
            background: white;
            color: var(--accent-color);
        }

        .cta-section .btn-outline {
            background: transparent;
            color: white;
            border-color: white;
        }

        .cta-section .btn-outline:hover {
            background: white;
            color: var(--accent-color);
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .hero-section {
                padding: 32px 16px;
                margin: 16px 0 32px;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .feature-card {
                padding: 24px 20px;
            }

            .workflow-steps {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .cta-section {
                padding: 40px 20px;
            }

            .cta-content h2 {
                font-size: 1.5rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .cta-section .btn {
                width: 100%;
                max-width: 280px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .feature-icon {
                width: 56px;
                height: 56px;
            }

            .feature-icon svg {
                width: 24px;
                height: 24px;
            }

            .step {
                padding: 20px 16px;
            }

            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('token');
            if (token) {
                const ctaButtons = document.querySelector('.cta-buttons');
                if (ctaButtons) {
                    ctaButtons.innerHTML = `
                        <a href="/chatbot" class="btn btn-primary">
                            <svg class="btn-icon" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                            <span>Lanjut Konsultasi AI</span>
                        </a>
                        <a href="/project" class="btn btn-outline">
                            <svg class="btn-icon" viewBox="0 0 24 24"><path d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                            <span>Buka Project Manager</span>
                        </a>
                    `;
                }
            }
        });
    </script>
@endsection
