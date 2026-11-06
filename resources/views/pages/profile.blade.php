@extends('layouts.app')

@section('title', 'Profil - NexaConsult')

@section('content')
    <script src="/js/protect.js"></script>
    <div class="profile-page">
        <!-- Loading State -->
        <div id="loading-state" class="loading-state">
            <div class="pulse-spinner">
                <div class="pulse-dot"></div>
                <div class="pulse-dot"></div>
                <div class="pulse-dot"></div>
            </div>
            <h3>Memuat Profil...</h3>
            <p>Sedang mengambil data profil Anda</p>
        </div>

        <!-- Content Area -->
        <div id="content-area" class="hidden">
            <!-- Header Section -->
            <div class="profile-header">
                <div class="header-content">
                    <div class="header-icon">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                fill="none" />
                            <path d="M5 21v-2a7 7 0 0114 0v2" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="header-info">
                        <h1>Profil Saya</h1>
                        <p>Kelola informasi dan preferensi akun Anda</p>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="profile-content">
                <div class="content-grid">
                    <!-- Left Column: Profile Info & Stats -->
                    <div class="left-column">
                        <!-- Profile Card -->
                        <div class="profile-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <svg viewBox="0 0 24 24">
                                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                        <path d="M5 21v-2a7 7 0 0114 0v2" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                    </svg>
                                </div>
                                <h3>Informasi Profil</h3>
                            </div>
                            <div class="card-content">
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor"
                                                    stroke-width="2" fill="none" />
                                                <circle cx="12" cy="7" r="4" stroke="currentColor"
                                                    stroke-width="2" fill="none" />
                                            </svg>
                                            <span>Nama Lengkap</span>
                                        </div>
                                        <div class="info-value" id="user-name">Memuat...</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                                <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2"
                                                    fill="none" />
                                            </svg>
                                            <span>Email</span>
                                        </div>
                                        <div class="info-value" id="user-email">Memuat...</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                                    stroke-width="2" fill="none" />
                                            </svg>
                                            <span>Bergabung Sejak</span>
                                        </div>
                                        <div class="info-value" id="join-date">-</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                            </svg>
                                            <span>Total Project</span>
                                        </div>
                                        <div class="info-value" id="total-projects">0</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 19V22M8 19V22M16 19V22M18 16H6C4.895 16 4 15.105 4 14V6C4 4.895 4.895 4 6 4H18C19.105 4 20 4.895 20 6V14C20 15.105 19.105 16 18 16Z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                                <circle cx="9" cy="10" r="1" fill="currentColor" />
                                                <circle cx="15" cy="10" r="1" fill="currentColor" />
                                            </svg>
                                            <span>Total Konsultasi</span>
                                        </div>
                                        <div class="info-value" id="total-chats">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Stats -->
                        <div class="stats-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                    </svg>
                                </div>
                                <h3>Statistik Akun</h3>
                            </div>
                            <div class="card-content">
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="stat-text">
                                            <h4 id="active-projects">0</h4>
                                            <p>Project Aktif</p>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                                    stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="stat-text">
                                            <h4 id="pending-tasks">0</h4>
                                            <p>Tasks Pending</p>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="stat-text">
                                            <h4 id="completion-rate">0%</h4>
                                            <p>Completion Rate</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Settings & Status -->
                    <div class="right-column">
                        <!-- Account Settings -->
                        <div class="settings-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                        <path
                                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"
                                            stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                </div>
                                <h3>Pengaturan Akun</h3>
                            </div>
                            <div class="card-content">
                                <div class="settings-list">
                                    <button class="setting-item" id="edit-profile-btn">
                                        <div class="setting-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2v-5"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="setting-content">
                                            <h4>Edit Profil</h4>
                                            <p>Ubah nama dan informasi profil</p>
                                        </div>
                                        <div class="setting-action">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2"
                                                    fill="none" />
                                            </svg>
                                        </div>
                                    </button>
                                    <button class="setting-item" id="change-password-btn">
                                        <div class="setting-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="setting-content">
                                            <h4>Ubah Password</h4>
                                            <p>Update kata sandi akun Anda</p>
                                        </div>
                                        <div class="setting-action">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2"
                                                    fill="none" />
                                            </svg>
                                        </div>
                                    </button>
                                    <button class="setting-item" id="notification-settings-btn">
                                        <div class="setting-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"
                                                    stroke="currentColor" stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="setting-content">
                                            <h4>Notifikasi</h4>
                                            <p>Kelola preferensi notifikasi</p>
                                        </div>
                                        <div class="setting-action">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2"
                                                    fill="none" />
                                            </svg>
                                        </div>
                                    </button>
                                    <button class="setting-item" id="privacy-settings-btn">
                                        <div class="setting-icon">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor"
                                                    stroke-width="2" fill="none" />
                                            </svg>
                                        </div>
                                        <div class="setting-content">
                                            <h4>Privasi & Keamanan</h4>
                                            <p>Kelola pengaturan privasi Anda</p>
                                        </div>
                                        <div class="setting-action">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2"
                                                    fill="none" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div class="status-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                            stroke-width="2" fill="none" />
                                    </svg>
                                </div>
                                <h3>Status Akun</h3>
                            </div>
                            <div class="card-content">
                                <div class="account-status">
                                    <div class="status-indicator active">
                                        <div class="status-dot"></div>
                                        <span>Aktif</span>
                                    </div>
                                    <div class="status-info">
                                        <p>Akun Anda aktif dan dapat menggunakan semua fitur</p>
                                    </div>
                                    {{-- <button class="logout-btn" id="logout-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor"
                                                stroke-width="2" fill="none" />
                                            <path d="M16 17l5-5-5-5" stroke="currentColor" stroke-width="2"
                                                fill="none" />
                                            <path d="M21 12H9" stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        <span>Logout</span>
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <div id="edit-profile-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Profil</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-name">Nama Lengkap</label>
                        <input type="text" id="edit-name" class="modal-input" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label for="edit-email">Email</label>
                        <input type="email" id="edit-email" class="modal-input" placeholder="Masukkan email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn primary save">Simpan Perubahan</button>
                </div>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div id="change-password-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Ubah Password</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current-password">Password Saat Ini</label>
                        <input type="password" id="current-password" class="modal-input"
                            placeholder="Masukkan password saat ini">
                    </div>
                    <div class="form-group">
                        <label for="new-password">Password Baru</label>
                        <input type="password" id="new-password" class="modal-input"
                            placeholder="Masukkan password baru">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Konfirmasi Password Baru</label>
                        <input type="password" id="confirm-password" class="modal-input"
                            placeholder="Konfirmasi password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn primary save">Ubah Password</button>
                </div>
            </div>
        </div>

        <!-- Export Data Modal -->
        <div id="export-data-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Export Data</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="export-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-profile" checked>
                            <span>Informasi Profil</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-projects" checked>
                            <span>Semua Project</span>
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" id="export-chats" checked>
                            <span>Riwayat Chat</span>
                        </label>
                    </div>
                    <div class="export-format">
                        <h4>Format Export</h4>
                        <div class="format-options">
                            <label class="radio-label">
                                <input type="radio" name="export-format" value="json" checked>
                                <span>JSON</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="export-format" value="csv">
                                <span>CSV</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="export-format" value="pdf">
                                <span>PDF</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn primary save">Export Data</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ===== VARIABLES ===== */
        :root {
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
            --border-radius: 12px;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
            --purple-dark: #5B21B6;
            /* Warna ungu gelap */
        }

        /* ===== BASE STYLES ===== */
        .profile-page {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        .hidden {
            display: none !important;
        }

        /* ===== LOADING STATE ===== */
        .loading-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            text-align: center;
        }

        .pulse-spinner {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .pulse-dot {
            width: 12px;
            height: 12px;
            background: var(--purple-dark);
            border-radius: 50%;
            animation: pulse 1.4s ease-in-out infinite;
        }

        .pulse-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .pulse-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        .loading-state h3 {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .loading-state p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* ===== HEADER SECTION ===== */
        .profile-header {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            border-radius: var(--border-radius);
            padding: 32px 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 24px;
            position: relative;
            z-index: 1;
        }

        .header-icon {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .header-icon svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .header-info h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-info p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 8px 0 0;
            font-weight: 500;
        }

        /* ===== MAIN CONTENT ===== */
        .profile-content {
            margin-bottom: 40px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        /* ===== LEFT COLUMN ===== */
        .left-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
            height: 100%;
        }

        /* ===== RIGHT COLUMN ===== */
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
            height: 100%;
        }

        /* ===== CARD STYLES ===== */
        .profile-card,
        .stats-card,
        .settings-card,
        .status-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: var(--transition);
            height: fit-content;
        }

        .profile-card:hover,
        .stats-card:hover,
        .settings-card:hover,
        .status-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 24px;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .card-header .header-icon {
            width: 48px;
            height: 48px;
            background: rgba(91, 33, 182, 0.1);
            border-radius: 12px;
            color: var(--purple-dark);
        }

        .card-header .header-icon svg {
            width: 24px;
            height: 24px;
        }

        .card-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .card-content {
            padding: 24px;
        }

        /* ===== INFO GRID ===== */
        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .info-label svg {
            width: 20px;
            height: 20px;
            color: var(--purple-dark);
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* ===== STATS GRID ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(91, 33, 182, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--purple-dark);
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
        }

        .stat-text h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .stat-text p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* ===== SETTINGS LIST ===== */
        .settings-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .setting-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            text-align: left;
            width: 100%;
        }

        .setting-item:hover {
            background: var(--card-bg);
            border-color: var(--purple-dark);
            transform: translateX(4px);
        }

        .setting-icon {
            width: 40px;
            height: 40px;
            background: rgba(91, 33, 182, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--purple-dark);
        }

        .setting-icon svg {
            width: 20px;
            height: 20px;
        }

        .setting-content {
            flex: 1;
        }

        .setting-content h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .setting-content p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .setting-action svg {
            width: 20px;
            height: 20px;
            color: var(--text-secondary);
        }

        /* ===== ACCOUNT STATUS ===== */
        .account-status {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: var(--border-radius);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-indicator.active {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background: var(--success-color);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-indicator span {
            font-weight: 600;
            color: var(--success-color);
        }

        .status-info p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0;
        }

        /* .logout-btn {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        padding: 16px;
                        background: var(--danger-color);
                        color: white;
                        border: none;
                        border-radius: var(--border-radius);
                        font-size: 1rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: var(--transition);
                        justify-content: center;
                    }

                    .logout-btn:hover {
                        background: #DC2626;
                        transform: translateY(-2px);
                        box-shadow: var(--card-shadow);
                    }

                    .logout-btn svg {
                        width: 20px;
                        height: 20px;
                    } */

        /* ===== MODAL STYLES ===== */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            box-shadow: var(--card-shadow-hover);
            animation: modalSlideIn 0.3s ease-out;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
            line-height: 1;
        }

        .close-modal:hover {
            color: var(--purple-dark);
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .modal-input {
            width: 100%;
            padding: 14px 16px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
            transition: var(--transition);
        }

        .modal-input:focus {
            outline: none;
            border-color: var(--purple-dark);
            box-shadow: 0 0 0 3px rgba(91, 33, 182, 0.1);
        }

        .export-options,
        .export-format {
            margin-bottom: 24px;
        }

        .export-format h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .format-options {
            display: flex;
            gap: 20px;
        }

        .checkbox-label,
        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .checkbox-label input,
        .radio-label input {
            width: 18px;
            height: 18px;
            accent-color: var(--purple-dark);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 24px;
            border-top: 1px solid var(--border-color);
        }

        .modal-btn {
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .modal-btn.secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .modal-btn.secondary:hover {
            background: var(--border-color);
        }

        .modal-btn.primary {
            background: linear-gradient(135deg, var(--purple-dark), #7C3AED);
            color: white;
        }

        .modal-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        /* ===== TOAST NOTIFICATION ===== */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: var(--border-radius);
            color: white;
            font-weight: 500;
            z-index: 9999;
            animation: slideInRight 0.3s ease-out;
            box-shadow: var(--card-shadow-hover);
        }

        .toast.success {
            background: var(--success-color);
        }

        .toast.error {
            background: var(--danger-color);
        }

        .toast.info {
            background: var(--info-color);
        }

        .toast.warning {
            background: var(--warning-color);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .profile-page {
                padding: 16px;
            }

            .profile-header {
                padding: 24px;
            }

            .header-info h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .format-options {
                flex-direction: column;
                gap: 12px;
            }

            .modal-content {
                margin: 0;
                max-height: 100vh;
                border-radius: 0;
            }
        }

        @media (max-width: 480px) {
            .profile-header {
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header-info h1 {
                font-size: 1.6rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .modal-footer {
                flex-direction: column;
            }

            .modal-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <script>
        class ProfileManager {
            constructor() {
                this.userData = null;
                this.projects = [];
                this.stats = {
                    totalProjects: 0,
                    activeProjects: 0,
                    totalTasks: 0,
                    completedTasks: 0,
                    pendingTasks: 0,
                    completionRate: 0,
                    totalChats: 0
                };
                this.initialize();
            }

            async initialize() {
                await this.loadUserData();
                await this.loadProjects();
                await this.loadChatHistory();
                this.updateUI();
                this.setupEventListeners();
                this.setupModals();
            }

            async loadUserData() {
                try {
                    const token = localStorage.getItem("token");
                    if (!token) {
                        console.warn("No token found");
                        this.showError("Silakan login terlebih dahulu");
                        return;
                    }

                    const res = await fetch("/api/auth/me", {
                        method: "GET",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        }
                    });

                    if (!res.ok) {
                        if (res.status === 401) {
                            this.showError("Sesi telah berakhir, silakan login kembali");
                            return;
                        }
                        throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                    }

                    const json = await res.json();
                    this.userData = json.user || json.data;

                    // Hide loading, show content
                    document.getElementById('loading-state').style.display = 'none';
                    document.getElementById('content-area').classList.remove('hidden');

                } catch (error) {
                    console.error("Failed to load user data:", error);
                    this.showError("Gagal memuat data profil");
                }
            }

            async loadProjects() {
                try {
                    const token = localStorage.getItem("token");
                    if (!token) return;

                    const res = await fetch("/api/projects", {
                        method: "GET",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        }
                    });

                    if (res.ok) {
                        const json = await res.json();
                        this.projects = json.data || json.projects || [];
                        this.calculateStats();
                    }
                } catch (error) {
                    console.error("Failed to load projects:", error);
                }
            }

            async loadChatHistory() {
                try {
                    const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
                    this.stats.totalChats = history.length;
                } catch (error) {
                    console.error("Failed to load chat history:", error);
                }
            }

            calculateStats() {
                if (!this.projects || !Array.isArray(this.projects)) {
                    return;
                }

                // Reset stats
                this.stats = {
                    totalProjects: 0,
                    activeProjects: 0,
                    totalTasks: 0,
                    completedTasks: 0,
                    pendingTasks: 0,
                    completionRate: 0,
                    totalChats: this.stats.totalChats || 0
                };

                this.projects.forEach(project => {
                    // Count projects
                    this.stats.totalProjects++;

                    // Count active projects
                    if (!project.status || project.status === 'active') {
                        this.stats.activeProjects++;
                    }

                    // Count tasks
                    if (project.tasks && Array.isArray(project.tasks)) {
                        this.stats.totalTasks += project.tasks.length;

                        // Count completed tasks
                        const completed = project.tasks.filter(task => {
                            if (typeof task === 'object') {
                                return task.done === true ||
                                    task.status === 'completed' ||
                                    task.is_completed === true;
                            }
                            return false;
                        }).length;

                        this.stats.completedTasks += completed;
                    }
                });

                // Calculate pending tasks
                this.stats.pendingTasks = this.stats.totalTasks - this.stats.completedTasks;

                // Calculate completion rate
                if (this.stats.totalTasks > 0) {
                    this.stats.completionRate = Math.round((this.stats.completedTasks / this.stats.totalTasks) * 100);
                }
            }

            updateUI() {
                if (!this.userData) return;

                // Update basic info
                document.getElementById('user-name').textContent =
                    this.userData.name || "-";
                document.getElementById('user-email').textContent =
                    this.userData.email || "-";

                // Update join date
                const joinDate = this.formatDate(this.userData.created_at || this.userData.createdAt);
                document.getElementById('join-date').textContent = joinDate;

                // Update stats
                document.getElementById('total-projects').textContent = this.stats.totalProjects;
                document.getElementById('total-chats').textContent = this.stats.totalChats;
                document.getElementById('active-projects').textContent = this.stats.activeProjects;
                document.getElementById('pending-tasks').textContent = this.stats.pendingTasks;
                document.getElementById('completion-rate').textContent = `${this.stats.completionRate}%`;
            }

            setupEventListeners() {
                // Edit profile button
                document.getElementById('edit-profile-btn').addEventListener('click', () => {
                    const modal = document.getElementById('edit-profile-modal');
                    const nameInput = document.getElementById('edit-name');
                    const emailInput = document.getElementById('edit-email');

                    nameInput.value = this.userData.name || '';
                    emailInput.value = this.userData.email || '';

                    modal.classList.add('active');
                    nameInput.focus();
                });

                // Change password button
                document.getElementById('change-password-btn').addEventListener('click', () => {
                    document.getElementById('change-password-modal').classList.add('active');
                });

                // Export data button (moved to settings list)
                document.getElementById('export-data-btn')?.addEventListener('click', () => {
                    document.getElementById('export-data-modal').classList.add('active');
                });

                // Logout button
                // document.getElementById('logout-btn').addEventListener('click', () => {
                //     this.logout();
                // });

                // Notification settings
                document.getElementById('notification-settings-btn').addEventListener('click', () => {
                    this.showToast("Fitur pengaturan notifikasi akan segera hadir", "info");
                });

                // Privacy settings
                document.getElementById('privacy-settings-btn').addEventListener('click', () => {
                    this.showToast("Fitur pengaturan privasi akan segera hadir", "info");
                });
            }

            setupModals() {
                // Close modals
                document.querySelectorAll('.close-modal, .modal-btn.cancel').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.modal').forEach(modal => {
                            modal.classList.remove('active');
                        });
                    });
                });

                // Close modal when clicking outside
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            modal.classList.remove('active');
                        }
                    });
                });

                // Edit profile save
                document.querySelector('#edit-profile-modal .modal-btn.save').addEventListener('click', async () => {
                    const newName = document.getElementById('edit-name').value.trim();
                    const newEmail = document.getElementById('edit-email').value.trim();

                    if (!newName || !newEmail) {
                        this.showToast("Nama dan email tidak boleh kosong", "error");
                        return;
                    }

                    try {
                        const token = localStorage.getItem("token");
                        const res = await fetch("/api/auth/update", {
                            method: "PUT",
                            headers: {
                                "Authorization": "Bearer " + token,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                name: newName,
                                email: newEmail
                            })
                        });

                        if (res.ok) {
                            this.userData.name = newName;
                            this.userData.email = newEmail;
                            this.updateUI();
                            document.getElementById('edit-profile-modal').classList.remove('active');
                            this.showToast("Profil berhasil diupdate", "success");
                        } else {
                            throw new Error("Failed to update profile");
                        }
                    } catch (error) {
                        console.error("Failed to update profile:", error);
                        this.showToast("Gagal mengupdate profil", "error");
                    }
                });

                // Change password save
                document.querySelector('#change-password-modal .modal-btn.save').addEventListener('click', async () => {
                    const currentPassword = document.getElementById('current-password').value;
                    const newPassword = document.getElementById('new-password').value;
                    const confirmPassword = document.getElementById('confirm-password').value;

                    if (!currentPassword || !newPassword || !confirmPassword) {
                        this.showToast("Semua field harus diisi", "error");
                        return;
                    }

                    if (newPassword !== confirmPassword) {
                        this.showToast("Password baru dan konfirmasi tidak cocok", "error");
                        return;
                    }

                    if (newPassword.length < 6) {
                        this.showToast("Password minimal 6 karakter", "error");
                        return;
                    }

                    try {
                        const token = localStorage.getItem("token");
                        const res = await fetch("/api/auth/change-password", {
                            method: "POST",
                            headers: {
                                "Authorization": "Bearer " + token,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                current_password: currentPassword,
                                new_password: newPassword,
                                confirm_password: confirmPassword
                            })
                        });

                        if (res.ok) {
                            document.getElementById('change-password-modal').classList.remove('active');
                            document.getElementById('current-password').value = '';
                            document.getElementById('new-password').value = '';
                            document.getElementById('confirm-password').value = '';
                            this.showToast("Password berhasil diubah", "success");
                        } else {
                            const errorData = await res.json();
                            throw new Error(errorData.message || "Failed to change password");
                        }
                    } catch (error) {
                        console.error("Failed to change password:", error);
                        this.showToast(error.message || "Gagal mengubah password", "error");
                    }
                });

                // Export data save
                document.querySelector('#export-data-modal .modal-btn.save')?.addEventListener('click', () => {
                    const exportProfile = document.getElementById('export-profile').checked;
                    const exportProjects = document.getElementById('export-projects').checked;
                    const exportChats = document.getElementById('export-chats').checked;
                    const format = document.querySelector('input[name="export-format"]:checked').value;

                    const exportData = {};

                    if (exportProfile) {
                        exportData.profile = this.userData;
                    }

                    if (exportProjects) {
                        exportData.projects = this.projects;
                    }

                    if (exportChats) {
                        try {
                            exportData.chat_history = JSON.parse(localStorage.getItem("chat_history") || "[]");
                        } catch (error) {
                            console.error("Failed to export chat history:", error);
                        }
                    }

                    exportData.export_date = new Date().toISOString();
                    exportData.stats = this.stats;

                    this.exportData(exportData, format);
                    document.getElementById('export-data-modal').classList.remove('active');
                });
            }

            exportData(data, format) {
                let dataStr, mimeType, fileName;

                switch (format) {
                    case 'json':
                        dataStr = JSON.stringify(data, null, 2);
                        mimeType = 'application/json';
                        fileName = `nexaconsult-export-${new Date().toISOString().split('T')[0]}.json`;
                        break;
                    case 'csv':
                        // Simple CSV conversion (you might want to implement proper CSV conversion)
                        const csvRows = [];
                        // Convert data to CSV rows
                        dataStr = this.convertToCSV(data);
                        mimeType = 'text/csv';
                        fileName = `nexaconsult-export-${new Date().toISOString().split('T')[0]}.csv`;
                        break;
                    case 'pdf':
                        this.showToast("Export PDF akan segera hadir", "info");
                        return;
                    default:
                        dataStr = JSON.stringify(data, null, 2);
                        mimeType = 'application/json';
                        fileName = `nexaconsult-export-${new Date().toISOString().split('T')[0]}.json`;
                }

                const dataBlob = new Blob([dataStr], {
                    type: mimeType
                });
                const url = URL.createObjectURL(dataBlob);
                const a = document.createElement('a');
                a.href = url;
                a.download = fileName;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

                this.showToast(`Data berhasil diexport (${format.toUpperCase()})`, "success");
            }

            convertToCSV(data) {
                // Simple implementation - you might want to improve this
                const items = data;
                const replacer = (key, value) => value === null ? '' : value;
                const header = Object.keys(items[0]);
                const csv = [
                    header.join(','),
                    ...items.map(row => header.map(fieldName =>
                        JSON.stringify(row[fieldName], replacer)).join(','))
                ].join('\r\n');
                return csv;
            }

            // logout() {
            //     if (confirm("Apakah Anda yakin ingin logout?")) {
            //         localStorage.removeItem("token");
            //         localStorage.removeItem("last_context");
            //         this.showToast("Berhasil logout", "success");
            //         setTimeout(() => {
            //             window.location.href = '/login';
            //         }, 1000);
            //     }
            // }

            showError(message) {
                document.getElementById('loading-state').innerHTML = `
                    <div class="error-state">
                        <svg viewBox="0 0 24 24" width="64" height="64" style="color: var(--danger-color); margin-bottom: 20px;">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <h3>Gagal Memuat Profil</h3>
                        <p>${message}</p>
                        <div class="error-actions" style="margin-top: 20px; display: flex; gap: 12px;">
                            <button onclick="location.reload()" style="padding: 12px 24px; background: var(--purple-dark); color: white; border: none; border-radius: 8px; cursor: pointer;">
                                Coba Lagi
                            </button>
                            <button onclick="window.location.href='/login'" style="padding: 12px 24px; background: var(--bg-secondary); color: var(--text-primary); border: 1px solid var(--border-color); border-radius: 8px; cursor: pointer;">
                                Login Ulang
                            </button>
                        </div>
                    </div>
                `;
            }

            showToast(message, type = "info") {
                // Remove existing toast
                const existingToast = document.querySelector('.toast');
                if (existingToast) existingToast.remove();

                // Create new toast
                const toast = document.createElement('div');
                toast.className = `toast ${type}`;
                toast.textContent = message;

                // Add styles
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    padding: 16px 24px;
                    border-radius: var(--border-radius);
                    color: white;
                    font-weight: 500;
                    z-index: 9999;
                    animation: slideInRight 0.3s ease-out;
                    box-shadow: var(--card-shadow-hover);
                `;

                document.body.appendChild(toast);

                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.style.animation = 'slideOutRight 0.3s ease-out forwards';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Utility methods
            formatDate(dateString) {
                if (!dateString) return '-';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            window.profileManager = new ProfileManager();
        });
    </script>
@endsection
