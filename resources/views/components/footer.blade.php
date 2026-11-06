<footer class="footer">
    <div class="footer-container">
        <!-- Main Content -->
        <div class="footer-main">
            <!-- Logo & Description -->
            <div class="footer-brand">
                <a href="/home" class="footer-logo-link">
                    <svg class="footer-logo-icon" viewBox="0 0 32 32" fill="none">
                        <!-- Robot Head -->
                        <rect x="8" y="8" width="16" height="16" rx="4"
                            fill="url(#footer-logo-gradient)" />

                        <!-- Robot Eyes -->
                        <circle cx="13" cy="14" r="2" fill="white" opacity="0.9" />
                        <circle cx="19" cy="14" r="2" fill="white" opacity="0.9" />

                        <!-- Robot Mouth/Sensor -->
                        <rect x="13" y="18" width="6" height="2" rx="1" fill="white"
                            opacity="0.8" />

                        <!-- AI Brain Waves -->
                        <path d="M24 10C24 10 25 8 27 8" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.7" />
                        <path d="M24 14C24 14 25 12 27 12" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.7" />
                        <path d="M24 18C24 18 25 16 27 16" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.7" />

                        <path d="M8 10C8 10 7 8 5 8" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.7" />
                        <path d="M8 14C8 14 7 12 5 12" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.7" />
                        <path d="M8 18C8 18 7 16 5 16" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.7" />

                        <!-- Antenna -->
                        <circle cx="16" cy="6" r="1.5" fill="white" opacity="0.8" />
                        <path d="M16 7.5L16 9" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            opacity="0.8" />

                        <defs>
                            <linearGradient id="footer-logo-gradient" x1="8" y1="16" x2="24"
                                y2="16" gradientUnits="userSpaceOnUse">
                                <stop stop-color="var(--accent-color)" />
                                <stop offset="1" stop-color="var(--text-primary)" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="footer-logo-text">
                        <span class="logo-main">Nexa Consult</span>
                        <span class="logo-tag">AI Assistant</span>
                    </div>
                </a>
                <p class="footer-description">
                    Platform AI untuk membantu UMKM mengembangkan bisnis dari ide hingga eksekusi.
                </p>
            </div>

            <!-- Simple Links - Desktop Only -->
            <div class="footer-links desktop-only">
                <div class="footer-link-group">
                    <h4 class="link-group-title">Tentang</h4>
                    <a href="/about" class="footer-link">About Us</a>
                    <a href="/contact" class="footer-link">Contact</a>
                    <a href="/privacy" class="footer-link">Privacy Policy</a>
                    <a href="/terms" class="footer-link">Terms of Service</a>
                </div>

                <div class="footer-link-group">
                    <h4 class="link-group-title">Layanan</h4>
                    <a href="/chatbot" class="footer-link">AI Chatbot</a>
                    <a href="/project" class="footer-link">Project Manager</a>
                    <a href="/features" class="footer-link">Features</a>
                    <a href="/help" class="footer-link">Help Center</a>
                </div>
            </div>
        </div>

        <!-- Divider - Desktop Only -->
        <div class="footer-divider desktop-only"></div>

        <!-- Bottom Section -->
        <div class="footer-bottom">
            <div class="copyright">
                © {{ date('Y') }} Nexa Consult. All rights reserved.
            </div>

            <div class="footer-social">
                <a href="https://github.com" class="social-link" target="_blank" rel="noopener noreferrer"
                    aria-label="GitHub">
                    <svg class="social-icon" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <a href="https://linkedin.com" class="social-link" target="_blank" rel="noopener noreferrer"
                    aria-label="LinkedIn">
                    <svg class="social-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <rect x="2" y="9" width="4" height="12" rx="1" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="4" cy="4" r="2" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <a href="mailto:contact@nexaconsult.com" class="social-link" aria-label="Email">
                    <svg class="social-icon" viewBox="0 0 24 24" fill="none">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M22 6l-10 7L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>

<style>
    /* ===== FOOTER BASE ===== */
    .footer {
        background: var(--card-bg);
        border-top: 1px solid var(--border-color);
        padding: 50px 0 30px;
        margin-top: auto;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ===== MAIN CONTENT ===== */
    .footer-main {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 60px;
        margin-bottom: 40px;
        align-items: start;
    }

    /* ===== BRAND SECTION ===== */
    .footer-brand {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 400px;
    }

    .footer-logo-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        transition: transform 0.2s ease;
    }

    .footer-logo-link:hover {
        transform: translateY(-2px);
    }

    .footer-logo-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
    }

    .footer-logo-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .logo-main {
        font-size: 22px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.3px;
    }

    .logo-tag {
        font-size: 12px;
        color: var(--accent-color);
        font-weight: 600;
        background: rgba(126, 60, 169, 0.1);
        padding: 2px 8px;
        border-radius: 10px;
        display: inline-block;
        width: fit-content;
    }

    .footer-description {
        color: var(--text-secondary);
        font-size: 15px;
        line-height: 1.6;
        margin: 0;
    }

    /* ===== LINKS SECTION (Desktop Only) ===== */
    .footer-links {
        display: flex;
        gap: 60px;
    }

    .footer-link-group {
        display: flex;
        flex-direction: column;
        gap: 14px;
        min-width: 150px;
    }

    .link-group-title {
        color: var(--text-primary);
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .footer-link {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
    }

    .footer-link:hover {
        color: var(--accent-color);
        transform: translateX(4px);
    }

    .footer-link::before {
        content: "→";
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .footer-link:hover::before {
        opacity: 1;
    }

    /* ===== DIVIDER (Desktop Only) ===== */
    .footer-divider {
        height: 1px;
        background: linear-gradient(to right,
                transparent 0%,
                var(--border-color) 50%,
                transparent 100%);
        margin: 30px 0;
    }

    /* ===== BOTTOM SECTION ===== */
    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .copyright {
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 500;
    }

    .footer-social {
        display: flex;
        gap: 16px;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--bg-secondary);
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .social-link:hover {
        background: var(--accent-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(126, 60, 169, 0.2);
    }

    .social-icon {
        width: 18px;
        height: 18px;
        stroke-width: 2;
    }

    /* =========================== */
    /* RESPONSIVE DESIGN - MOBILE */
    /* =========================== */

    /* Desktop (769px ke atas) - Tampilkan semua */
    @media (min-width: 769px) {
        .desktop-only {
            display: flex !important;
        }

        .footer-main {
            grid-template-columns: 1fr auto;
            gap: 60px;
        }

        /* Pastikan footer-links horizontal di desktop */
        .footer-links {
            display: flex;
            gap: 60px;
        }
    }

    /* Tablet (768px ke bawah) */
    @media (max-width: 768px) {
        .footer {
            padding: 35px 0 25px;
        }

        .desktop-only {
            display: none !important;
        }

        /* Hide Tentang & Layanan */
        .footer-links {
            display: none;
        }

        /* Hide divider */
        .footer-divider {
            display: none;
        }

        /* Atur ulang layout */
        .footer-main {
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .footer-brand {
            max-width: 100%;
            gap: 15px;
            text-align: center;
            align-items: center;
        }

        .footer-description {
            font-size: 14px;
            line-height: 1.5;
            max-width: 90%;
            margin: 0 auto;
        }

        /* Bottom section mobile layout */
        .footer-bottom {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 15px;
        }

        .copyright {
            font-size: 13px;
            order: 2;
        }

        .footer-social {
            order: 1;
            justify-content: center;
            gap: 15px;
        }
    }

    /* Mobile (480px ke bawah) */
    @media (max-width: 480px) {
        .footer {
            padding: 25px 0 20px;
        }

        .footer-container {
            padding: 0 16px;
        }

        .footer-main {
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Logo lebih kecil di mobile */
        .footer-logo-link {
            gap: 10px;
        }

        .footer-logo-icon {
            width: 32px;
            height: 32px;
        }

        .logo-main {
            font-size: 18px;
        }

        .logo-tag {
            font-size: 10px;
            padding: 1px 6px;
        }

        .footer-description {
            font-size: 13px;
            line-height: 1.4;
            max-width: 100%;
        }

        /* Social icons lebih kecil */
        .social-link {
            width: 32px;
            height: 32px;
            border-radius: 6px;
        }

        .social-icon {
            width: 16px;
            height: 16px;
        }

        .footer-bottom {
            gap: 12px;
        }

        .copyright {
            font-size: 12px;
        }
    }

    /* Mobile kecil (360px ke bawah) */
    @media (max-width: 360px) {
        .footer {
            padding: 20px 0 15px;
        }

        .footer-container {
            padding: 0 12px;
        }

        .footer-logo-icon {
            width: 28px;
            height: 28px;
        }

        .logo-main {
            font-size: 16px;
        }

        .footer-description {
            font-size: 12px;
        }

        .social-link {
            width: 28px;
            height: 28px;
        }

        .social-icon {
            width: 14px;
            height: 14px;
        }

        .copyright {
            font-size: 11px;
        }
    }
</style>
