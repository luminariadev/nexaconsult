@extends('layouts.app')

@section('title', 'Admin Dashboard - NexaConsult')

@section('content')
<script src="/js/protect.js"></script>

<div class="admin-dashboard-container" style="max-width: 1200px; margin: 0 auto; padding-bottom: 60px;">
    <!-- Admin Hero Banner & Stats Overview -->
    <div id="overview">
        <div style="background: linear-gradient(135deg, #1e1b4b, #312e81, #4c1d95); border-radius: 20px; padding: 32px 36px; color: white; margin-bottom: 32px; box-shadow: 0 10px 30px rgba(49, 46, 129, 0.25); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
            <div style="space-y: 8px;">
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(254, 243, 199, 0.15); border: 1px solid rgba(254, 243, 199, 0.3); padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; color: #fde68a;">
                    <span>👑 Super Administrator Access</span>
                </div>
                <h1 style="font-size: 28px; font-weight: 800; margin-top: 8px; letter-spacing: -0.5px;">Panel Kontrol & Manajemen Sistem</h1>
                <p style="font-size: 14px; opacity: 0.85; max-width: 600px; line-height: 1.5;">Kelola seluruh pengguna, pantau aktivitas proyek UMKM, dan monitor kesehatan database MongoDB serta engine AI 9router.</p>
            </div>
            <div style="display: flex; gap: 12px;">
                <button onclick="window.adminManager.loadAllData()" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.15); hover:bg-white/25; border: 1px solid rgba(255, 255, 255, 0.25); color: white; font-weight: 600; font-size: 13px; padding: 10px 18px; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>Refresh Data</span>
                </button>
            </div>
        </div>

        <!-- System Stats Cards Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 32px;">
            <!-- Card 1: Users -->
            <div class="stat-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary);">Total Pengguna</span>
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(99, 102, 241, 0.12); color: #4f46e5; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0114 0v2"/></svg>
                    </div>
                </div>
                <div id="statTotalUsers" style="font-size: 30px; font-weight: 800; color: var(--text-primary);">-</div>
                <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                    <span id="statAdminCount" style="color: #d97706; font-weight: 700;">- Admin</span> &bull; 
                    <span id="statUserCount" style="color: #059669; font-weight: 700;">- UMKM</span>
                </div>
            </div>

            <!-- Card 2: Projects -->
            <div class="stat-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary);">Total Proyek UMKM</span>
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(16, 185, 129, 0.12); color: #059669; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"/></svg>
                    </div>
                </div>
                <div id="statTotalProjects" style="font-size: 30px; font-weight: 800; color: var(--text-primary);">-</div>
                <div style="font-size: 12px; color: #059669; font-weight: 600; margin-top: 4px;">Roadmap & Milestone Terdata</div>
            </div>

            <!-- Card 3: Landing Pages -->
            <div class="stat-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary);">Landing Pages Live</span>
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(168, 85, 247, 0.12); color: #9333ea; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                </div>
                <div id="statTotalLandingPages" style="font-size: 30px; font-weight: 800; color: var(--text-primary);">-</div>
                <div style="font-size: 12px; color: #9333ea; font-weight: 600; margin-top: 4px;">Auto-Hosted (/site/slug)</div>
            </div>

            <!-- Card 4: Database Driver -->
            <div class="stat-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px 24px; box-shadow: var(--shadow);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary);">Koneksi Database</span>
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(59, 130, 246, 0.12); color: #2563eb; display: flex; align-items: center; justify-content: center;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                    </div>
                </div>
                <div id="statDbDriver" style="font-size: 18px; font-weight: 800; color: #059669;">MongoDB (Utama)</div>
                <div id="statMongoStatus" style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Port 27017 Active</div>
            </div>
        </div>
    </div>

    <!-- Admin Tab Navigation: Memudahkan navigasi per modul tanpa scrolling panjang -->
    <div style="display: flex; gap: 8px; margin-bottom: 24px; overflow-x: auto; padding-bottom: 6px; border-bottom: 1px solid var(--border-color);">
        <button class="admin-tab-btn active" onclick="window.adminManager.switchTab('all')" data-tab="all" style="padding: 10px 18px; border-radius: 12px; font-weight: 700; font-size: 13px; cursor: pointer; border: none; background: #4f46e5; color: white; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <span>📁 Semua Modul</span>
        </button>
        <button class="admin-tab-btn" onclick="window.adminManager.switchTab('users')" data-tab="users" style="padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <span>👥 Kelola Pengguna</span>
            <span id="tabUsersBadge" style="background: rgba(99, 102, 241, 0.1); color: #4f46e5; padding: 1px 7px; border-radius: 999px; font-size: 11px;">-</span>
        </button>
        <button class="admin-tab-btn" onclick="window.adminManager.switchTab('projects')" data-tab="projects" style="padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <span>📋 Proyek UMKM</span>
            <span id="tabProjectsBadge" style="background: rgba(16, 185, 129, 0.1); color: #059669; padding: 1px 7px; border-radius: 999px; font-size: 11px;">-</span>
        </button>
        <button class="admin-tab-btn" onclick="window.adminManager.switchTab('landing-pages')" data-tab="landing-pages" style="padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <span>🌐 Landing Pages</span>
            <span id="tabLandingBadge" style="background: rgba(168, 85, 247, 0.1); color: #9333ea; padding: 1px 7px; border-radius: 999px; font-size: 11px;">-</span>
        </button>
        <button class="admin-tab-btn" onclick="window.adminManager.switchTab('system')" data-tab="system" style="padding: 10px 18px; border-radius: 12px; font-weight: 600; font-size: 13px; cursor: pointer; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-secondary); display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;">
            <span>⚙️ Status Sistem</span>
        </button>
    </div>

    <!-- Section: User Management -->
    <div id="users" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px 28px; box-shadow: var(--shadow); margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin: 0;">👥 Manajemen Pengguna</h3>
                <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0;">Daftar seluruh akun terdaftar beserta hak akses peran (Admin / User).</p>
            </div>
            <div>
                <input type="text" id="userSearchInput" placeholder="Cari nama atau email..." oninput="window.adminManager.filterUsers()" style="padding: 8px 16px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 13px; min-width: 240px; outline: none;">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-secondary); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 12px 16px;">Nama Pengguna</th>
                        <th style="padding: 12px 16px;">Email</th>
                        <th style="padding: 12px 16px;">Role</th>
                        <th style="padding: 12px 16px;">Total Proyek</th>
                        <th style="padding: 12px 16px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 32px; color: var(--text-secondary);">Memuat data pengguna...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section: All UMKM Projects Monitor -->
    <div id="projects" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px 28px; box-shadow: var(--shadow); margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin: 0;">📊 Monitoring Seluruh Proyek UMKM</h3>
                <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0;">Pantau seluruh roadmap bisnis yang dibuat pengguna melalui konsultasi AI.</p>
            </div>
        </div>

        <div id="projectsGrid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 18px;">
            <!-- Rendered via JS -->
        </div>
    </div>

    <!-- Section: All Landing Pages Monitor -->
    <div id="landing-pages" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px 28px; box-shadow: var(--shadow); margin-bottom: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin: 0;">🌐 Monitoring Seluruh Landing Page UMKM</h3>
                <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0;">Daftar seluruh website landing page yang di-generate oleh AI dan di-hosting secara publik (/site/slug).</p>
            </div>
            <div>
                <span id="landingPagesCountBadge" style="background: rgba(168, 85, 247, 0.12); color: #9333ea; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 700;">- Halaman Terdata</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13.5px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); color: var(--text-secondary); font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 12px 16px;">Nama Usaha / Judul</th>
                        <th style="padding: 12px 16px;">Slug Publik</th>
                        <th style="padding: 12px 16px;">WhatsApp</th>
                        <th style="padding: 12px 16px;">Tema</th>
                        <th style="padding: 12px 16px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="landingPagesTableBody">
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 32px; color: var(--text-secondary);">Memuat data landing page...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section: System Health & AI Engine Details -->
    <div id="system" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px 28px; box-shadow: var(--shadow);">
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin: 0;">⚙️ Status Mesin Backend, Database & AI</h3>
            <p style="font-size: 13px; color: var(--text-secondary); margin: 4px 0 0;">Diagnosa arsitektur server, basis data persisten, dan AI Gateway lokal.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 14px; padding: 18px;">
                <div style="font-size: 12px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 6px;">Database Primer</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                    <strong style="color: var(--text-primary); font-size: 15px;">MongoDB Server 9.0</strong>
                </div>
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">Host: 127.0.0.1:27017 | Database: nexaconsult | Driver: mongodb/mongodb ^2.1</p>
            </div>

            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 14px; padding: 18px;">
                <div style="font-size: 12px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 6px;">AI Gateway Engine</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                    <strong style="color: var(--text-primary); font-size: 15px;">9Router Local Gateway</strong>
                </div>
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">Port: 20128 | Model: mr-loverman (Gemini 2.5 Flash) | Auth: Bearer Token Active</p>
            </div>

            <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 14px; padding: 18px;">
                <div style="font-size: 12px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 6px;">Autentikasi & Keamanan</div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #3b82f6;"></div>
                    <strong style="color: var(--text-primary); font-size: 15px;">JSON Web Token (JWT)</strong>
                </div>
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">Algoritma: HS256 | Expire: 30 Hari | Role Protection: Active</p>
            </div>
        </div>
    </div>
</div>

<script>
    class AdminDashboardManager {
        constructor() {
            this.token = localStorage.getItem('token');
            this.users = [];
            this.projects = [];
            this.landingPages = [];
            this.stats = {};
        }

        async init() {
            if (!this.token) {
                window.location.href = '/login';
                return;
            }

            await this.loadAllData();
        }

        async loadAllData() {
            await Promise.all([
                this.loadStats(),
                this.loadUsers(),
                this.loadProjects(),
                this.loadLandingPages()
            ]);
        }

        async loadStats() {
            try {
                const res = await fetch('/api/admin/stats', {
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Gagal mengambil stats');
                const json = await res.json();
                this.stats = json.data;

                document.getElementById('statTotalUsers').textContent = this.stats.total_users || 0;
                document.getElementById('statAdminCount').textContent = `${this.stats.admin_count || 0} Admin`;
                document.getElementById('statUserCount').textContent = `${this.stats.user_count || 0} UMKM`;
                document.getElementById('statTotalProjects').textContent = this.stats.total_projects || 0;
                document.getElementById('statTotalLandingPages').textContent = this.stats.total_landing_pages || 0;
                document.getElementById('statDbDriver').textContent = this.stats.database_driver || 'MongoDB';
                document.getElementById('statMongoStatus').textContent = this.stats.mongo_status || 'Active';

                const tabU = document.getElementById('tabUsersBadge');
                const tabP = document.getElementById('tabProjectsBadge');
                const tabL = document.getElementById('tabLandingBadge');
                if (tabU) tabU.textContent = this.stats.total_users || 0;
                if (tabP) tabP.textContent = this.stats.total_projects || 0;
                if (tabL) tabL.textContent = this.stats.total_landing_pages || 0;

            } catch (e) {
                console.error(e);
            }
        }

        switchTab(tab) {
            document.querySelectorAll('.admin-tab-btn').forEach(btn => {
                if (btn.dataset.tab === tab) {
                    btn.style.background = '#4f46e5';
                    btn.style.color = '#ffffff';
                    btn.style.border = 'none';
                    btn.classList.add('active');
                } else {
                    btn.style.background = 'var(--bg-primary)';
                    btn.style.color = 'var(--text-secondary)';
                    btn.style.border = '1px solid var(--border-color)';
                    btn.classList.remove('active');
                }
            });

            const secUsers = document.getElementById('users');
            const secProjects = document.getElementById('projects');
            const secLanding = document.getElementById('landing-pages');
            const secSystem = document.getElementById('system');

            if (tab === 'all') {
                if (secUsers) secUsers.style.display = 'block';
                if (secProjects) secProjects.style.display = 'block';
                if (secLanding) secLanding.style.display = 'block';
                if (secSystem) secSystem.style.display = 'block';
            } else if (tab === 'users') {
                if (secUsers) secUsers.style.display = 'block';
                if (secProjects) secProjects.style.display = 'none';
                if (secLanding) secLanding.style.display = 'none';
                if (secSystem) secSystem.style.display = 'none';
            } else if (tab === 'projects') {
                if (secUsers) secUsers.style.display = 'none';
                if (secProjects) secProjects.style.display = 'block';
                if (secLanding) secLanding.style.display = 'none';
                if (secSystem) secSystem.style.display = 'none';
            } else if (tab === 'landing-pages') {
                if (secUsers) secUsers.style.display = 'none';
                if (secProjects) secProjects.style.display = 'none';
                if (secLanding) secLanding.style.display = 'block';
                if (secSystem) secSystem.style.display = 'none';
            } else if (tab === 'system') {
                if (secUsers) secUsers.style.display = 'none';
                if (secProjects) secProjects.style.display = 'none';
                if (secLanding) secLanding.style.display = 'none';
                if (secSystem) secSystem.style.display = 'block';
            }
        }

        async loadUsers() {
            const tbody = document.getElementById('usersTableBody');
            try {
                const res = await fetch('/api/admin/users', {
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Gagal mengambil daftar pengguna');
                const json = await res.json();
                this.users = json.data || [];
                this.renderUsers(this.users);
            } catch (e) {
                console.error(e);
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: #ef4444; padding: 24px;">Gagal memuat daftar pengguna. Pastikan Anda masuk sebagai Admin.</td></tr>`;
            }
        }

        renderUsers(userList) {
            const tbody = document.getElementById('usersTableBody');
            if (!userList.length) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 24px; color: var(--text-secondary);">Tidak ada pengguna ditemukan.</td></tr>`;
                return;
            }

            tbody.innerHTML = userList.map(u => {
                const isAdmin = u.role === 'admin';
                const roleBadge = isAdmin 
                    ? `<span style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 3px 10px; border-radius: 999px; font-weight: 700; font-size: 11px;">👑 Admin</span>`
                    : `<span style="background: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; padding: 3px 10px; border-radius: 999px; font-weight: 600; font-size: 11px;">UMKM User</span>`;

                return `
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 14px 16px; font-weight: 600; color: var(--text-primary);">${this.escapeHtml(u.name)}</td>
                        <td style="padding: 14px 16px; color: var(--text-secondary);">${this.escapeHtml(u.email)}</td>
                        <td style="padding: 14px 16px;">${roleBadge}</td>
                        <td style="padding: 14px 16px; font-weight: 700; color: var(--text-primary);">${u.projects || 0}</td>
                        <td style="padding: 14px 16px; text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <button onclick="window.adminManager.toggleRole('${u.id}', '${isAdmin ? 'user' : 'admin'}')" style="padding: 5px 12px; font-size: 12px; font-weight: 600; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); cursor: pointer;">
                                    Jadikan ${isAdmin ? 'User' : 'Admin'}
                                </button>
                                <button onclick="window.adminManager.deleteUser('${u.id}', '${this.escapeHtml(u.name)}')" style="padding: 5px 12px; font-size: 12px; font-weight: 600; border-radius: 8px; border: none; background: #fee2e2; color: #b91c1c; cursor: pointer;">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        filterUsers() {
            const query = (document.getElementById('userSearchInput')?.value || '').toLowerCase();
            const filtered = this.users.filter(u => 
                (u.name || '').toLowerCase().includes(query) || 
                (u.email || '').toLowerCase().includes(query)
            );
            this.renderUsers(filtered);
        }

        async toggleRole(userId, newRole) {
            try {
                const res = await fetch(`/api/admin/users/${userId}/role`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + this.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ role: newRole })
                });

                if (!res.ok) throw new Error('Gagal mengubah role');
                const json = await res.json();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: json.message, confirmButtonColor: '#4f46e5' });
                } else {
                    alert(json.message);
                }

                await this.loadUsers();
                await this.loadStats();
            } catch (e) {
                alert(e.message);
            }
        }

        async deleteUser(userId, userName) {
            if (!confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"? Seluruh proyek miliknya akan terhapus.`)) return;

            try {
                const res = await fetch(`/api/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });

                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Gagal menghapus user');

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Terhapus', text: json.message, confirmButtonColor: '#4f46e5' });
                } else {
                    alert(json.message);
                }

                await this.loadAllData();
            } catch (e) {
                alert(e.message);
            }
        }

        async loadProjects() {
            const grid = document.getElementById('projectsGrid');
            try {
                const res = await fetch('/api/admin/projects', {
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Gagal memuat proyek');
                const json = await res.json();
                this.projects = json.data || [];
                this.renderProjects(this.projects);
            } catch (e) {
                console.error(e);
                grid.innerHTML = `<div style="color: #ef4444; padding: 20px;">Gagal memuat daftar proyek.</div>`;
            }
        }

        renderProjects(projects) {
            const grid = document.getElementById('projectsGrid');
            if (!projects.length) {
                grid.innerHTML = `<div style="color: var(--text-secondary); padding: 20px;">Belum ada proyek UMKM terdaftar.</div>`;
                return;
            }

            grid.innerHTML = projects.map(p => {
                const tasks = Array.isArray(p.tasks) ? p.tasks : [];
                const doneCount = tasks.filter(t => t.done).length;
                const progress = tasks.length > 0 ? Math.round((doneCount / tasks.length) * 100) : 0;
                const id = p._id || p.id;

                return `
                    <div style="background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 16px; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="space-y: 8px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                                <h4 style="font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0;">${this.escapeHtml(p.name || 'Untitled')}</h4>
                                <span style="font-size: 11px; font-weight: 600; text-transform: uppercase; padding: 2px 8px; border-radius: 6px; background: rgba(99, 102, 241, 0.1); color: #4f46e5;">${p.status || 'active'}</span>
                            </div>
                            <p style="font-size: 12.5px; color: var(--text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">${this.escapeHtml(p.description || '-')}</p>
                        </div>
                        
                        <div style="margin-top: 16px; pt-3; border-top: 1px solid var(--border-color);">
                            <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px; color: var(--text-secondary);">
                                <span>Progress Milestone</span>
                                <strong>${doneCount}/${tasks.length} (${progress}%)</strong>
                            </div>
                            <div style="height: 6px; background: var(--border-color); border-radius: 999px; overflow: hidden;">
                                <div style="height: 100%; width: ${progress}%; background: linear-gradient(90deg, #4f46e5, #06b6d4); border-radius: 999px;"></div>
                            </div>
                            <div style="margin-top: 12px; display: flex; justify-content: flex-end;">
                                <a href="/project/${id}" target="_blank" style="font-size: 12px; font-weight: 600; color: #4f46e5; text-decoration: none;">Lihat Roadmap &rarr;</a>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        async loadLandingPages() {
            const tbody = document.getElementById('landingPagesTableBody');
            const badge = document.getElementById('landingPagesCountBadge');
            try {
                const res = await fetch('/api/admin/landing-pages', {
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Gagal memuat landing pages');
                const json = await res.json();
                this.landingPages = json.data || [];
                if (badge) badge.textContent = `${this.landingPages.length} Halaman Terdata`;
                this.renderLandingPages(this.landingPages);
            } catch (e) {
                console.error(e);
                if (tbody) tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: #ef4444; padding: 24px;">Gagal memuat data landing pages.</td></tr>`;
            }
        }

        renderLandingPages(pages) {
            const tbody = document.getElementById('landingPagesTableBody');
            if (!tbody) return;

            if (!pages.length) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 28px; color: var(--text-secondary);">Belum ada landing page yang di-generate oleh pengguna.</td></tr>`;
                return;
            }

            tbody.innerHTML = pages.map(p => {
                const slug = p.slug || '';
                const url = p.public_url || `/site/${slug}`;
                const id = p._id || p.id;
                const theme = p.theme_color || 'indigo';

                return `
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 14px 16px; font-weight: 700; color: var(--text-primary);">
                            ${this.escapeHtml(p.title || 'Untitled')}
                        </td>
                        <td style="padding: 14px 16px;">
                            <a href="${url}" target="_blank" style="color: #4f46e5; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                <code>/site/${this.escapeHtml(slug)}</code>
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                            </a>
                        </td>
                        <td style="padding: 14px 16px; color: var(--text-secondary); font-family: monospace;">
                            ${this.escapeHtml(p.whatsapp_number || '-')}
                        </td>
                        <td style="padding: 14px 16px;">
                            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 2px 8px; border-radius: 6px; background: rgba(99, 102, 241, 0.1); color: #4f46e5;">
                                ${this.escapeHtml(theme)}
                            </span>
                        </td>
                        <td style="padding: 14px 16px; text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <a href="${url}" target="_blank" style="padding: 5px 12px; font-size: 12px; font-weight: 600; border-radius: 8px; border: 1px solid #c7d2fe; background: #e0e7ff; color: #3730a3; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    Buka Web ↗
                                </a>
                                <button onclick="window.adminManager.deleteLandingPage('${id}', '${this.escapeHtml(p.title)}')" style="padding: 5px 12px; font-size: 12px; font-weight: 600; border-radius: 8px; border: none; background: #fee2e2; color: #b91c1c; cursor: pointer;">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        async deleteLandingPage(id, title) {
            if (!confirm(`Hapus landing page "${title}"? Halaman ini tidak akan bisa diakses lagi di internet.`)) return;

            try {
                const res = await fetch(`/api/admin/landing-pages/${id}`, {
                    method: 'DELETE',
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Gagal menghapus landing page');

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Terhapus', text: json.message, confirmButtonColor: '#4f46e5' });
                } else {
                    alert(json.message);
                }

                await this.loadLandingPages();
                await this.loadStats();
            } catch (e) {
                alert(e.message);
            }
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text || '';
            return div.innerHTML;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.adminManager = new AdminDashboardManager();
        window.adminManager.init();
    });
</script>
@endsection
