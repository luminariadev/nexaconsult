@php
    $isAdminRoute = request()->is('admin*');
@endphp

<header class="header {{ $isAdminRoute ? 'header-admin-mode' : '' }}">
    <div class="header-container">
        <!-- Logo -->
        <div class="header-logo">
            @if ($isAdminRoute)
                <a href="/admin" class="logo-link">
                    <div class="logo-badge-icon" style="background: linear-gradient(135deg, #f59e0b, #b45309); box-shadow: 0 4px 12px rgba(217, 119, 6, 0.35);">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="logo-text-group">
                        <span class="logo-title">NexaConsult</span>
                        <span class="logo-sub" style="color: #d97706; font-weight: 800;">Super Admin Console</span>
                    </div>
                </a>
            @else
                <a href="/home" class="logo-link">
                    <div class="logo-badge-icon">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div class="logo-text-group">
                        <span class="logo-title">NexaConsult</span>
                        <span class="logo-sub">AI UMKM Advisor</span>
                    </div>
                </a>
            @endif
        </div>

        <!-- Navigation Links: Completely Differentiated for Admin vs User -->
        <nav class="header-nav" id="headerNav">
            @if ($isAdminRoute)
                <!-- ============================================== -->
                <!-- KHUSUS HALAMAN ADMIN: HANYA 2 MENU BERSIH      -->
                <!-- ============================================== -->
                <a href="/admin" class="nav-item active">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    <span>Panel Kontrol</span>
                </a>

                <a href="/home" class="nav-item" title="Buka dan Pratinjau Tampilan Sisi Pengguna UMKM">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>
                    </svg>
                    <span>Portal Pengguna ↗</span>
                </a>
            @else
                <!-- ============================================== -->
                <!-- HALAMAN USER UMKM: FITUR BISNIS PENGGUNA       -->
                <!-- ============================================== -->
                <a href="/home" class="nav-item {{ request()->is('home') || request()->is('/') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path d="M9 22V12h6v10" />
                    </svg>
                    <span>Beranda</span>
                </a>

                <a href="/chatbot" class="nav-item {{ request()->is('chatbot') ? 'active' : '' }}" id="navChatbot">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                    </svg>
                    <span>Konsultasi AI</span>
                    <span class="nav-pill-badge">AI</span>
                </a>

                <a href="/project" class="nav-item {{ request()->is('project*') ? 'active' : '' }}" id="navProjects">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z" />
                    </svg>
                    <span>Project Manager</span>
                </a>

                <a href="/landing-page" class="nav-item {{ request()->is('landing-page*') ? 'active' : '' }}" id="navLandingPage">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="2" y1="12" x2="22" y2="12"/>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    <span>Landing Page AI</span>
                    <span class="nav-pill-badge" style="background: #10B981;">New</span>
                </a>

                <a href="/profile" class="nav-item {{ request()->is('profile') ? 'active' : '' }}" id="navProfile">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="7" r="4" />
                        <path d="M5 21v-2a7 7 0 0114 0v2" />
                    </svg>
                    <span>Profil</span>
                </a>
            @endif
        </nav>

        <!-- Right Side: Theme Toggle & Auth Buttons -->
        <div class="header-right">
            @if (!$isAdminRoute)
                <!-- Tombol Masuk ke Admin Panel (Hanya muncul jika yang login adalah Admin) -->
                <a href="/admin" id="btnAdminShortcut" style="display: none; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 7px 14px; border-radius: 10px; font-size: 12.5px; font-weight: 700; text-decoration: none; align-items: center; gap: 6px; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);">
                    <span>👑 Ke Admin Panel &rarr;</span>
                </a>
            @endif

            <!-- Theme Toggle Button -->
            <button class="theme-toggle-btn" id="themeToggleBtn" title="Ganti Tema">
                <svg class="sun-icon" viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <svg class="moon-icon" viewBox="0 0 24 24" width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            <!-- Auth Dynamic Container -->
            <div id="authGuestSection" class="auth-group">
                <a href="/login" class="btn-nav-outline">Masuk</a>
                <a href="/register" class="btn-nav-solid">Daftar</a>
            </div>

            <div id="authUserSection" class="auth-group" style="display: none;">
                <div class="user-greeting">
                    <div class="user-avatar-circle" id="headerUserAvatar">U</div>
                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                        <span class="user-name-text" id="headerUserName">User</span>
                        <span id="headerUserRoleBadge" class="user-role-badge" style="display: none; font-size: 10px; font-weight: 700; color: #92400e; background: #fef3c7; border: 1px solid #fde68a; padding: 0.5px 6px; border-radius: 999px; line-height: 1.2;">👑 Admin</span>
                    </div>
                </div>
                <button class="btn-logout" id="btnLogout" title="Keluar">
                    <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </div>

            <!-- Mobile Hamburger Button -->
            <button class="mobile-toggle-btn" id="mobileToggleBtn" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</header>

<style>
    .header {
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        box-shadow: 0 2px 14px rgba(0,0,0,0.04);
        position: sticky;
        top: 0;
        z-index: 1000;
        backdrop-filter: blur(12px);
    }

    .header-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 12px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    /* Logo */
    .header-logo .logo-link {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .logo-badge-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(126, 60, 169, 0.25);
    }

    .logo-text-group {
        display: flex;
        flex-direction: column;
    }

    .logo-title {
        font-size: 19px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.1;
        letter-spacing: -0.4px;
    }

    .logo-sub {
        font-size: 11px;
        font-weight: 600;
        color: var(--accent-color);
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    /* Nav items */
    .header-nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 10px;
        text-decoration: none;
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .nav-item:hover {
        color: var(--accent-color);
        background: var(--accent-light);
    }

    .nav-item.active {
        color: var(--accent-color);
        background: var(--accent-light);
        font-weight: 700;
    }

    .nav-pill-badge {
        font-size: 10px;
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        padding: 2px 6px;
        border-radius: 6px;
        font-weight: 800;
    }

    /* Right side */
    .header-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .theme-toggle-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-secondary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .theme-toggle-btn:hover {
        color: var(--accent-color);
        border-color: var(--accent-color);
        transform: rotate(15deg);
    }

    .auth-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-nav-outline {
        padding: 8px 18px;
        border-radius: 10px;
        border: 1.5px solid var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-nav-outline:hover {
        border-color: var(--accent-color);
        color: var(--accent-color);
    }

    .btn-nav-solid {
        padding: 8px 18px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
        color: white;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(126, 60, 169, 0.2);
        transition: all 0.2s ease;
    }

    .btn-nav-solid:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(126, 60, 169, 0.3);
    }

    .user-greeting {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 4px 10px 4px 4px;
        background: var(--accent-light);
        border-radius: 30px;
    }

    .user-avatar-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--accent-color);
        color: white;
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .user-name-text {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-primary);
        max-width: 140px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-logout {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid rgba(239, 68, 68, 0.25);
        background: rgba(239, 68, 68, 0.08);
        color: #DC2626;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .btn-logout:hover {
        background: #DC2626;
        color: white;
    }

    .mobile-toggle-btn {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 26px;
        height: 18px;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .mobile-toggle-btn span {
        display: block;
        height: 2.5px;
        width: 100%;
        background: var(--text-primary);
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    @media (max-width: 860px) {
        .header-nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--card-bg);
            flex-direction: column;
            padding: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-bottom: 1px solid var(--border-color);
        }

        .header-nav.mobile-active {
            display: flex;
        }

        .mobile-toggle-btn {
            display: flex;
        }

        .user-name-text {
            display: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Auth State Management
        const token = localStorage.getItem('token');
        const guestSec = document.getElementById('authGuestSection');
        const userSec = document.getElementById('authUserSection');
        const userNameEl = document.getElementById('headerUserName');
        const userAvatarEl = document.getElementById('headerUserAvatar');

        if (token) {
            if (guestSec) guestSec.style.display = 'none';
            if (userSec) userSec.style.display = 'flex';

            let user = null;
            try {
                user = JSON.parse(localStorage.getItem('user') || 'null');
            } catch (e) {}

            const applyUserRole = (u) => {
                let role = u?.role;
                if (!role && token) {
                    try {
                        const payload = JSON.parse(atob(token.split('.')[1]));
                        role = payload.role;
                    } catch (e) {}
                }
                const btnAdminShortcut = document.getElementById('btnAdminShortcut');
                const roleBadge = document.getElementById('headerUserRoleBadge');
                const adminBanner = document.getElementById('adminUserPreviewBanner');

                if (role === 'admin') {
                    if (btnAdminShortcut) btnAdminShortcut.style.display = 'inline-flex';
                    if (roleBadge) roleBadge.style.display = 'inline-block';
                    if (adminBanner) adminBanner.style.display = 'block';
                } else {
                    if (btnAdminShortcut) btnAdminShortcut.style.display = 'none';
                    if (roleBadge) roleBadge.style.display = 'none';
                    if (adminBanner) adminBanner.style.display = 'none';
                }
            };

            if (user && user.name) {
                if (userNameEl) userNameEl.textContent = user.name;
                if (userAvatarEl) userAvatarEl.textContent = user.name.charAt(0).toUpperCase();
                applyUserRole(user);
            } else {
                applyUserRole(null);
                // Fetch fresh me
                fetch('/api/auth/me', {
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                }).then(res => res.json()).then(data => {
                    if (data.user) {
                        localStorage.setItem('user', JSON.stringify(data.user));
                        if (userNameEl) userNameEl.textContent = data.user.name;
                        if (userAvatarEl) userAvatarEl.textContent = data.user.name.charAt(0).toUpperCase();
                        applyUserRole(data.user);
                    }
                }).catch(() => {});
            }
        } else {
            if (guestSec) guestSec.style.display = 'flex';
            if (userSec) userSec.style.display = 'none';
        }

        // 2. Logout Action
        const btnLogout = document.getElementById('btnLogout');
        if (btnLogout) {
            btnLogout.addEventListener('click', () => {
                const doLogout = () => {
                    fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                    }).finally(() => {
                        localStorage.removeItem('token');
                        localStorage.removeItem('user');
                        window.location.href = '/login';
                    });
                };

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Konfirmasi Keluar',
                        text: 'Apakah Anda yakin ingin logout dari akun NexaConsult?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#7E3CA9',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Keluar',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            doLogout();
                        }
                    });
                } else if (confirm('Apakah Anda yakin ingin logout?')) {
                    doLogout();
                }
            });
        }

        // 3. Theme Toggle (Light / Dark)
        const themeBtn = document.getElementById('themeToggleBtn');
        const sunIcon = themeBtn ? themeBtn.querySelector('.sun-icon') : null;
        const moonIcon = themeBtn ? themeBtn.querySelector('.moon-icon') : null;

        const applyTheme = (isDark) => {
            if (isDark) {
                document.body.classList.add('theme-dark');
                document.documentElement.classList.add('theme-dark');
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'block';
            } else {
                document.body.classList.remove('theme-dark');
                document.documentElement.classList.remove('theme-dark');
                if (sunIcon) sunIcon.style.display = 'block';
                if (moonIcon) moonIcon.style.display = 'none';
            }
        };

        const currentSavedTheme = localStorage.getItem('nexa_theme');
        applyTheme(currentSavedTheme === 'dark');

        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                const isCurrentlyDark = document.body.classList.contains('theme-dark');
                const nextDark = !isCurrentlyDark;
                localStorage.setItem('nexa_theme', nextDark ? 'dark' : 'light');
                applyTheme(nextDark);
            });
        }

        // 4. Mobile Menu Toggle
        const mobileToggleBtn = document.getElementById('mobileToggleBtn');
        const headerNav = document.getElementById('headerNav');
        if (mobileToggleBtn && headerNav) {
            mobileToggleBtn.addEventListener('click', () => {
                headerNav.classList.toggle('mobile-active');
            });
        }
    });
</script>
