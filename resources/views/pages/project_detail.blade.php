@extends('layouts.app')

@section('title', 'Project Detail - NexaConsult')

@section('content')
    <script src="/js/protect.js"></script>
    <div class="project-detail-page">
        <!-- Loading State -->
        <div id="loading-state" class="loading-state">
            <div class="pulse-spinner">
                <div class="pulse-dot"></div>
                <div class="pulse-dot"></div>
                <div class="pulse-dot"></div>
            </div>
            <h3>Memuat Project...</h3>
            <p>Sedang mengambil data project Anda</p>
        </div>

        <!-- Content Area -->
        <div id="content-area" class="hidden">
            <!-- Header Section -->
            <div class="project-header">
                <div class="header-content">
                    <a href="/project" class="back-btn">
                        <svg viewBox="0 0 24 24">
                            <path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span>Kembali ke Daftar</span>
                    </a>

                    <div class="header-info">
                        <div class="header-icon">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"
                                    stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                        </div>
                        <div class="title-section">
                            <h1 id="project-title">Loading...</h1>
                            <div class="header-actions">
                                <span id="project-status" class="project-status status-draft">Draft</span>
                                <button class="header-action-btn" id="edit-title-btn">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2v-5"
                                            stroke="currentColor" stroke-width="2" fill="none" />
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                            stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                    <span>Edit</span>
                                </button>
                                <button class="header-action-btn delete" id="delete-project-btn">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"
                                            stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Stats -->
                <div class="project-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                    stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <h3 id="total-tasks">0</h3>
                            <p>Total Tasks</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon active">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <h3 id="completed-tasks">0</h3>
                            <p>Completed</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon pending">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2"
                                    fill="none" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <h3 id="pending-tasks">0</h3>
                            <p>Pending</p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon progress">
                            <svg viewBox="0 0 24 24">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2" stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                        </div>
                        <div class="stat-text">
                            <h3 id="progress-percentage">0%</h3>
                            <p>Progress</p>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="progress-label">
                        <span>Project Progress</span>
                        <span id="progress-text">0%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="project-content">
                <div class="content-grid">
                    <!-- Left Column: Details -->
                    <div class="detail-column">
                        <!-- User Request Card -->
                        <div class="detail-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <svg viewBox="0 0 24 24">
                                        <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                        <path d="M5 21v-2a7 7 0 0114 0v2" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                    </svg>
                                </div>
                                <h3>User Request</h3>
                            </div>
                            <div class="card-content">
                                <p id="project-user-prompt" class="prompt-text">Loading...</p>
                                <div class="meta-info">
                                    <span class="meta-item">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                                stroke-width="2" fill="none" />
                                        </svg>
                                        Dibuat: <span id="created-date">-</span>
                                    </span>
                                    <span class="meta-item">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2v-5"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        Diupdate: <span id="updated-date">-</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- AI Summary Card -->
                        <div class="detail-card">
                            <div class="card-header">
                                <div class="header-icon ai">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="M12 19V22M8 19V22M16 19V22M18 16H6C4.895 16 4 15.105 4 14V6C4 4.895 4.895 4 6 4H18C19.105 4 20 4.895 20 6V14C20 15.105 19.105 16 18 16Z"
                                            stroke="currentColor" stroke-width="2" fill="none" />
                                        <circle cx="9" cy="10" r="1" fill="currentColor" />
                                        <circle cx="15" cy="10" r="1" fill="currentColor" />
                                    </svg>
                                </div>
                                <h3>AI Summary</h3>
                            </div>
                            <div class="card-content">
                                <p id="project-desc" class="ai-text">Loading...</p>
                                <div class="ai-actions">
                                    <button class="action-btn secondary" id="regenerate-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        <span>Regenerate dengan AI</span>
                                    </button>
                                    <button class="action-btn" id="copy-desc-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        <span>Copy Summary</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="detail-card">
                            <div class="card-header">
                                <div class="header-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2"
                                            fill="none" />
                                    </svg>
                                </div>
                                <h3>Quick Actions</h3>
                            </div>
                            <div class="card-content">
                                <div class="quick-actions-grid">
                                    <button class="quick-action-btn" onclick="window.location.href='/chatbot'">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M12 19V22M8 19V22M16 19V22M18 16H6C4.895 16 4 15.105 4 14V6C4 4.895 4.895 4 6 4H18C19.105 4 20 4.895 20 6V14C20 15.105 19.105 16 18 16Z"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                            <circle cx="9" cy="10" r="1" fill="currentColor" />
                                            <circle cx="15" cy="10" r="1" fill="currentColor" />
                                        </svg>
                                        <span>Tanya AI Lainnya</span>
                                    </button>
                                    <button class="quick-action-btn" id="ai-swot-btn" style="background: rgba(99, 102, 241, 0.08); border-color: rgba(99, 102, 241, 0.3);">
                                        <svg viewBox="0 0 24 24" style="color: #4f46e5;">
                                            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" stroke="currentColor" stroke-width="2" fill="none"/>
                                        </svg>
                                        <span style="font-weight: 600; color: #4f46e5;">Analisis SWOT AI</span>
                                    </button>
                                    <button class="quick-action-btn" id="ai-pitch-btn" style="background: rgba(16, 185, 129, 0.08); border-color: rgba(16, 185, 129, 0.3);">
                                        <svg viewBox="0 0 24 24" style="color: #059669;">
                                            <path d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" stroke="currentColor" stroke-width="2" fill="none"/>
                                        </svg>
                                        <span style="font-weight: 600; color: #059669;">AI Marketing Pitch</span>
                                    </button>
                                    <button class="quick-action-btn" onclick="window.location.href='/landing-page?project_id={{ $id }}'" style="background: rgba(168, 85, 247, 0.08); border-color: rgba(168, 85, 247, 0.3);">
                                        <svg viewBox="0 0 24 24" style="color: #9333ea;">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                            <line x1="2" y1="12" x2="22" y2="12" stroke="currentColor" stroke-width="2"/>
                                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" stroke="currentColor" stroke-width="2" fill="none"/>
                                        </svg>
                                        <span style="font-weight: 600; color: #9333ea;">🌐 Buat Landing Page</span>
                                    </button>
                                    <button class="quick-action-btn" id="export-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        <span>Export Project</span>
                                    </button>
                                    <button class="quick-action-btn" id="share-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M18 8a3 3 0 100-6 3 3 0 000 6zM6 15a3 3 0 100-6 3 3 0 000 6zM18 22a3 3 0 100-6 3 3 0 000 6zM8.59 13.51l6.83 3.98M15.41 6.51l-6.82 3.98"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        <span>Share</span>
                                    </button>
                                    <button class="quick-action-btn" onclick="location.reload()">
                                        <svg viewBox="0 0 24 24">
                                            <path
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                                stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                        <span>Refresh Data</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Tasks -->
                    <div class="task-column">
                        <div class="task-header">
                            <div class="task-title-section">
                                <h2>Task Management</h2>
                                <p id="task-subtitle">Mengelola tugas-tugas project</p>
                            </div>
                            <div class="task-actions-group" style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <button class="add-task-btn" id="ai-expand-tasks-btn" style="background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none;">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                    <span>AI Perluas Task</span>
                                </button>
                                <button class="add-task-btn" id="add-task-btn">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                    <span>Tambah Task</span>
                                </button>
                            </div>
                        </div>

                        <!-- Task Stats -->
                        <div class="task-stats">
                            <div class="task-stat">
                                <span class="stat-label">Total</span>
                                <span class="stat-value" id="task-total">0</span>
                            </div>
                            <div class="task-stat">
                                <span class="stat-label">Selesai</span>
                                <span class="stat-value completed" id="task-done">0</span>
                            </div>
                            <div class="task-stat">
                                <span class="stat-label">Pending</span>
                                <span class="stat-value pending" id="task-pending">0</span>
                            </div>
                            <div class="task-stat">
                                <span class="stat-label">Progress</span>
                                <span class="stat-value progress" id="task-progress">0%</span>
                            </div>
                        </div>

                        <!-- Tasks List -->
                        <div class="tasks-container">
                            <div id="task-list" class="tasks-list">
                                <!-- Tasks will be loaded here -->
                            </div>

                            <!-- Empty Task State -->
                            <div id="empty-tasks" class="empty-tasks" style="display: none;">
                                <div class="empty-illustration">
                                    <svg viewBox="0 0 200 200">
                                        <circle cx="100" cy="100" r="80" fill="var(--bg-secondary)"
                                            stroke="var(--border-color)" stroke-width="2" />
                                        <path d="M70,100 L130,100 M100,70 L100,130" stroke="var(--accent-color)"
                                            stroke-width="4" stroke-linecap="round" />
                                    </svg>
                                </div>
                                <div class="empty-content">
                                    <h3>Belum Ada Task</h3>
                                    <p>Tambahkan task pertama untuk memulai project ini</p>
                                    <button class="create-task-btn" id="create-first-task-btn">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                        <span>Buat Task Pertama</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Task Actions -->
                        <div class="task-actions">
                            <button class="action-btn secondary" id="mark-all-done-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                        stroke-width="2" fill="none" />
                                </svg>
                                <span>Tandai Semua Selesai</span>
                            </button>
                            <button class="action-btn secondary" id="clear-done-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                                <span>Hapus Task Selesai</span>
                            </button>
                            <button class="action-btn" id="add-multiple-btn">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                                <span>Tambah Multiple Task</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Title Modal -->
        <div id="edit-title-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Judul Project</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" id="edit-title-input" class="modal-input"
                        placeholder="Masukkan judul baru...">
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn primary save">Simpan</button>
                </div>
            </div>
        </div>

        <!-- Add Task Modal -->
        <div id="add-task-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Tambah Task Baru</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <textarea id="new-task-input" class="modal-textarea" placeholder="Deskripsi task..." rows="4"></textarea>
                    <div class="modal-options">
                        <label class="checkbox-label">
                            <input type="checkbox" id="mark-done-checkbox">
                            <span>Tandai sebagai selesai</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn primary save">Tambah Task</button>
                </div>
            </div>
        </div>

        <!-- Add Multiple Tasks Modal -->
        <div id="add-multiple-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Tambah Multiple Task</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <textarea id="multiple-tasks-input" class="modal-textarea"
                        placeholder="Masukkan tugas-tugas, satu per baris...
Contoh:
- Riset pasar
- Buat rencana pemasaran
- Siapkan produk sampel"
                        rows="8"></textarea>
                    <div class="modal-hint">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2"
                                fill="none" />
                        </svg>
                        <span>Setiap baris akan menjadi task terpisah</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn primary save">Tambah Semua</button>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="delete-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Hapus Project</h3>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="warning-icon">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.694-.833-2.464 0L4.332 16.5c-.77.833.192 2.5 1.732 2.5z"
                                stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <p>Apakah Anda yakin ingin menghapus project ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Batal</button>
                    <button class="modal-btn danger delete">Ya, Hapus Project</button>
                </div>
            </div>
        </div>

        <!-- SWOT Analysis Modal -->
        <div id="swot-modal" class="modal">
            <div class="modal-content" style="max-width: 820px; width: 92%;">
                <div class="modal-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 24px;">📊</span>
                        <div>
                            <h3 style="margin: 0;">Analisis SWOT Bisnis (Powered by AI)</h3>
                            <p style="margin: 0; font-size: 13px; color: var(--text-secondary);">Pemetaan komprehensif Kekuatan, Kelemahan, Peluang, dan Ancaman</p>
                        </div>
                    </div>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body" id="swot-modal-content" style="max-height: 70vh; overflow-y: auto;">
                    <!-- SWOT content populated via JS -->
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Tutup</button>
                </div>
            </div>
        </div>

        <!-- Marketing Pitch & Copywriting Modal -->
        <div id="pitch-modal" class="modal">
            <div class="modal-content" style="max-width: 780px; width: 92%;">
                <div class="modal-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 24px;">📢</span>
                        <div>
                            <h3 style="margin: 0;">AI Marketing Pitch & Content Suite</h3>
                            <p style="margin: 0; font-size: 13px; color: var(--text-secondary);">Materi promosi siap salin untuk TikTok, Instagram, dan WhatsApp</p>
                        </div>
                    </div>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body" id="pitch-modal-content" style="max-height: 70vh; overflow-y: auto;">
                    <!-- Pitch content populated via JS -->
                </div>
                <div class="modal-footer">
                    <button class="modal-btn secondary cancel">Tutup</button>
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
            --danger-color: #EF4444;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --info-color: #3B82F6;
        }

        /* ===== BASE STYLES ===== */
        .project-detail-page {
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
            background: var(--accent-color);
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
        .project-header {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            border-radius: var(--border-radius);
            color: white;
            margin-bottom: 30px;
            overflow: hidden;
            position: relative;
        }

        .project-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .header-content {
            padding: 32px 40px;
            position: relative;
            z-index: 1;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 20px;
            transition: var(--transition);
            width: fit-content;
        }

        .back-btn:hover {
            color: white;
            gap: 12px;
        }

        .back-btn svg {
            width: 20px;
            height: 20px;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 20px;
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
            flex-shrink: 0;
        }

        .header-icon svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .title-section {
            flex: 1;
        }

        .title-section h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 16px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            line-height: 1.2;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .project-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            backdrop-filter: blur(10px);
        }

        .status-active {
            background: rgba(52, 199, 89, 0.3);
        }

        .status-completed {
            background: rgba(0, 122, 255, 0.3);
        }

        .status-draft {
            background: rgba(142, 142, 147, 0.3);
        }

        .header-action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: var(--border-radius);
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .header-action-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .header-action-btn.delete {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .header-action-btn.delete:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .header-action-btn svg {
            width: 18px;
            height: 18px;
        }

        /* ===== PROJECT STATS ===== */
        .project-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 0 40px 32px;
            position: relative;
            z-index: 1;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: var(--transition);
        }

        .stat-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .stat-icon.active {
            background: rgba(52, 199, 89, 0.3);
        }

        .stat-icon.pending {
            background: rgba(245, 158, 11, 0.3);
        }

        .stat-icon.progress {
            background: rgba(59, 130, 246, 0.3);
        }

        .stat-icon svg {
            width: 28px;
            height: 28px;
        }

        .stat-text h3 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin: 0;
            line-height: 1;
        }

        .stat-text p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 8px 0 0;
        }

        /* ===== PROGRESS BAR ===== */
        .progress-container {
            padding: 0 40px 32px;
            position: relative;
            z-index: 1;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .progress-bar {
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.8));
            border-radius: 5px;
            transition: width 1s ease;
        }

        /* ===== MAIN CONTENT ===== */
        .project-content {
            margin-bottom: 40px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* ===== DETAIL COLUMN ===== */
        .detail-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .detail-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: var(--transition);
        }

        .detail-card:hover {
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
            background: var(--bg-secondary);
            border-radius: 12px;
            color: var(--accent-color);
        }

        .card-header .header-icon.ai {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
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

        .prompt-text,
        .ai-text {
            color: var(--text-secondary);
            line-height: 1.7;
            font-size: 1rem;
            margin: 0 0 24px;
        }

        .ai-text {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 500;
        }

        .meta-info {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            padding-top: 16px;
            border-top: 1px solid var(--border-color);
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .meta-item svg {
            width: 16px;
            height: 16px;
        }

        .ai-actions,
        .quick-actions-grid {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--accent-color);
            border: none;
            border-radius: var(--border-radius);
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--text-primary);
            transform: translateY(-2px);
        }

        .action-btn.secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .action-btn.secondary:hover {
            background: var(--border-color);
        }

        .action-btn svg {
            width: 18px;
            height: 18px;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .quick-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }

        .quick-action-btn:hover {
            background: var(--accent-color);
            color: white;
            border-color: transparent;
            transform: translateY(-3px);
        }

        .quick-action-btn svg {
            width: 24px;
            height: 24px;
        }

        /* ===== TASK COLUMN ===== */
        .task-column {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .task-title-section h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 4px;
        }

        .task-title-section p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin: 0;
        }

        .add-task-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .add-task-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        .add-task-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Task Stats */
        .task-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 16px;
            padding: 20px;
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .task-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-value.completed {
            color: var(--success-color);
        }

        .stat-value.pending {
            color: var(--warning-color);
        }

        .stat-value.progress {
            color: var(--accent-color);
        }

        /* Tasks List */
        .tasks-container {
            flex: 1;
            min-height: 400px;
        }

        .tasks-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .task-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: var(--transition);
            animation: slideIn 0.3s ease-out;
        }

        .task-item:hover {
            box-shadow: var(--card-shadow);
            border-color: var(--accent-color);
        }

        .task-item.completed {
            background: rgba(16, 185, 129, 0.05);
            border-color: rgba(16, 185, 129, 0.2);
        }

        .task-checkbox {
            width: 24px;
            height: 24px;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .task-item.completed .task-checkbox {
            background: var(--success-color);
            border-color: var(--success-color);
        }

        .task-checkbox svg {
            width: 16px;
            height: 16px;
            color: white;
            opacity: 0;
            transition: var(--transition);
        }

        .task-item.completed .task-checkbox svg {
            opacity: 1;
        }

        .task-content {
            flex: 1;
            min-width: 0;
        }

        .task-text {
            color: var(--text-primary);
            font-size: 1rem;
            line-height: 1.5;
            margin: 0 0 4px;
            word-break: break-word;
        }

        .task-item.completed .task-text {
            text-decoration: line-through;
            color: var(--text-secondary);
        }

        .task-meta {
            display: flex;
            gap: 16px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .task-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .task-action-btn {
            padding: 8px;
            background: none;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .task-action-btn:hover {
            background: var(--bg-secondary);
            color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .task-action-btn svg {
            width: 16px;
            height: 16px;
        }

        /* Empty Tasks State */
        .empty-tasks {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            text-align: center;
            height: 100%;
        }

        .empty-illustration {
            width: 120px;
            height: 120px;
            margin-bottom: 24px;
        }

        .empty-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .empty-content p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 24px;
            max-width: 300px;
        }

        .create-task-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .create-task-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        /* Task Actions Bar */
        .task-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

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
            color: var(--accent-color);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-input,
        .modal-textarea {
            width: 100%;
            padding: 16px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            font-size: 1rem;
            font-family: inherit;
            transition: var(--transition);
        }

        .modal-input:focus,
        .modal-textarea:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(126, 60, 169, 0.1);
        }

        .modal-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .modal-options {
            margin-top: 16px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .checkbox-label input {
            width: 18px;
            height: 18px;
            accent-color: var(--accent-color);
        }

        .modal-hint {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            padding: 12px;
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .modal-hint svg {
            width: 18px;
            height: 18px;
            color: var(--warning-color);
        }

        .warning-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .warning-icon svg {
            width: 64px;
            height: 64px;
            color: var(--danger-color);
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
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
        }

        .modal-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .modal-btn.danger {
            background: var(--danger-color);
            color: white;
        }

        .modal-btn.danger:hover {
            background: #DC2626;
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .project-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .project-detail-page {
                padding: 16px;
            }

            .header-content,
            .project-stats,
            .progress-container {
                padding: 24px;
            }

            .title-section h1 {
                font-size: 2rem;
            }

            .header-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .project-stats {
                grid-template-columns: 1fr;
            }

            .stat-item {
                flex-direction: column;
                text-align: center;
                gap: 16px;
            }

            .task-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .add-task-btn {
                width: 100%;
                justify-content: center;
            }

            .task-actions {
                flex-direction: column;
            }

            .action-btn,
            .modal-btn {
                width: 100%;
                justify-content: center;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .ai-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {

            .header-content,
            .project-stats,
            .progress-container {
                padding: 20px;
            }

            .title-section h1 {
                font-size: 1.6rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .meta-info {
                flex-direction: column;
                gap: 12px;
            }

            .task-column {
                padding: 24px;
            }

            .modal-content {
                margin: 0;
                max-height: 100vh;
                border-radius: 0;
            }
        }
    </style>

    <script>
        class ProjectDetailManager {
            constructor(projectId) {
                this.projectId = projectId;
                this.project = null;
                this.tasks = [];
                this.initialize();
            }

            async initialize() {
                await this.loadProject();
                this.setupEventListeners();
                this.setupModals();
            }

            async loadProject() {
                try {
                    const token = localStorage.getItem("token");
                    if (!token) {
                        console.warn("No token found");
                        return;
                    }

                    const res = await fetch(`/api/projects/${this.projectId}`, {
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        }
                    });

                    if (!res.ok) {
                        throw new Error(`HTTP ${res.status}: ${res.statusText}`);
                    }

                    const json = await res.json();
                    this.project = json.data || json.project;

                    // Extract tasks from project
                    this.tasks = this.project.tasks || [];

                    // Hide loading, show content
                    document.getElementById('loading-state').style.display = 'none';
                    document.getElementById('content-area').classList.remove('hidden');

                    this.updateUI();
                    this.updateStats();
                    this.renderTasks();

                } catch (error) {
                    console.error("Failed to load project:", error);
                    this.showError();
                }
            }

            updateUI() {
                // Update title
                document.getElementById('project-title').textContent =
                    this.project.name || "(No Title)";

                // Update status
                const statusElement = document.getElementById('project-status');
                statusElement.textContent = this.project.status || 'draft';
                statusElement.className = `project-status status-${this.project.status || 'draft'}`;

                // Update descriptions
                document.getElementById('project-user-prompt').textContent =
                    this.project.user_prompt || "-";
                document.getElementById('project-desc').textContent =
                    this.project.description || "-";

                // Update dates
                const createdDate = this.formatDate(this.project.createdAt || this.project.created_at);
                const updatedDate = this.formatDate(this.project.updatedAt || this.project.updated_at);
                document.getElementById('created-date').textContent = createdDate;
                document.getElementById('updated-date').textContent = updatedDate;
            }

            updateStats() {
                const totalTasks = this.tasks.length;
                const completedTasks = this.tasks.filter(task => task.done).length;
                const pendingTasks = totalTasks - completedTasks;
                const progress = totalTasks > 0 ? Math.round((completedTasks / totalTasks) * 100) : 0;

                // Update header stats
                document.getElementById('total-tasks').textContent = totalTasks;
                document.getElementById('completed-tasks').textContent = completedTasks;
                document.getElementById('pending-tasks').textContent = pendingTasks;
                document.getElementById('progress-percentage').textContent = `${progress}%`;

                // Update progress bar
                document.getElementById('progress-fill').style.width = `${progress}%`;
                document.getElementById('progress-text').textContent = `${progress}%`;

                // Update task stats
                document.getElementById('task-total').textContent = totalTasks;
                document.getElementById('task-done').textContent = completedTasks;
                document.getElementById('task-pending').textContent = pendingTasks;
                document.getElementById('task-progress').textContent = `${progress}%`;
            }

            renderTasks() {
                const taskList = document.getElementById('task-list');
                const emptyTasks = document.getElementById('empty-tasks');

                if (this.tasks.length === 0) {
                    taskList.innerHTML = '';
                    emptyTasks.style.display = 'flex';
                    return;
                }

                emptyTasks.style.display = 'none';
                taskList.innerHTML = '';

                this.tasks.forEach((task, index) => {
                    const taskItem = this.createTaskElement(task, index);
                    taskList.appendChild(taskItem);
                });
            }

            createTaskElement(task, index) {
                const div = document.createElement('div');
                div.className = `task-item ${task.done ? 'completed' : ''}`;

                const isDone = task.done;
                const taskText = task.task || task.text || "(No Task Name)";
                const dateAdded = this.formatDate(task.created_at || task.date_added);

                div.innerHTML = `
                    <div class="task-checkbox" data-index="${index}">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="task-content">
                        <p class="task-text">${this.escapeHtml(taskText)}</p>
                        <div class="task-meta">
                            <span>Ditambahkan: ${dateAdded}</span>
                            ${task.updated_at ? `<span>Diupdate: ${this.formatDate(task.updated_at)}</span>` : ''}
                        </div>
                    </div>
                    <div class="task-actions">
                        <button class="task-action-btn edit-btn" data-index="${index}">
                            <svg viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2v-5" stroke="currentColor" stroke-width="2" fill="none"/>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </button>
                        <button class="task-action-btn delete-btn" data-index="${index}">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                        </button>
                    </div>
                `;

                // Add event listeners
                const checkbox = div.querySelector('.task-checkbox');
                checkbox.addEventListener('click', () => this.toggleTask(index));

                const editBtn = div.querySelector('.edit-btn');
                editBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.editTask(index);
                });

                const deleteBtn = div.querySelector('.delete-btn');
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.deleteTask(index);
                });

                return div;
            }

            async toggleTask(index) {
                try {
                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}/tasks/${index}/toggle`, {
                        method: "PUT",
                        headers: {
                            "Authorization": "Bearer " + token
                        }
                    });

                    if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);

                    // Update local state
                    this.tasks[index].done = !this.tasks[index].done;
                    this.tasks[index].updated_at = new Date().toISOString();

                    // Update UI
                    this.renderTasks();
                    this.updateStats();

                } catch (error) {
                    console.error("Failed to toggle task:", error);
                    alert("Gagal mengupdate task. Silakan coba lagi.");
                }
            }

            async addTask(taskText, markAsDone = false) {
                try {
                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}/tasks`, {
                        method: "POST",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            task: taskText,
                            done: markAsDone
                        })
                    });

                    if (!res.ok) throw new Error("Gagal menyimpan task ke server");
                    const data = await res.json();

                    if (data.project && Array.isArray(data.project.tasks)) {
                        this.tasks = data.project.tasks;
                    } else {
                        this.tasks.push({
                            task: taskText,
                            done: markAsDone,
                            created_at: new Date().toISOString()
                        });
                    }

                    this.renderTasks();
                    this.updateStats();
                    this.showToast("Task berhasil ditambahkan", "success");

                } catch (error) {
                    console.error("Failed to add task:", error);
                    this.showToast("Gagal menambahkan task", "error");
                }
            }

            async addMultipleTasks(taskTexts) {
                try {
                    const token = localStorage.getItem("token");
                    const tasksToAdd = taskTexts
                        .map(text => text.trim())
                        .filter(text => text.length > 0);

                    if (tasksToAdd.length === 0) {
                        this.showToast("Tidak ada task yang valid", "warning");
                        return;
                    }

                    this.showToast(`Menyimpan ${tasksToAdd.length} task ke server...`, "info");

                    for (const text of tasksToAdd) {
                        await fetch(`/api/projects/${this.projectId}/tasks`, {
                            method: "POST",
                            headers: {
                                "Authorization": "Bearer " + token,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ task: text, done: false })
                        });
                    }

                    await this.loadProjectData();
                    this.showToast(`${tasksToAdd.length} task berhasil ditambahkan`, "success");

                } catch (error) {
                    console.error("Failed to add multiple tasks:", error);
                    this.showToast("Gagal menambahkan task", "error");
                }
            }

            async editTask(index) {
                const currentText = this.tasks[index].task || this.tasks[index].text || "";
                const newText = prompt("Edit deskripsi task:", currentText);
                if (newText !== null && newText.trim() && newText.trim() !== currentText) {
                    try {
                        const token = localStorage.getItem("token");
                        const res = await fetch(`/api/projects/${this.projectId}/tasks/${index}`, {
                            method: "PUT",
                            headers: {
                                "Authorization": "Bearer " + token,
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ task: newText.trim() })
                        });

                        if (!res.ok) throw new Error("Gagal mengupdate task di server");
                        this.tasks[index].task = newText.trim();
                        this.tasks[index].updated_at = new Date().toISOString();

                        this.renderTasks();
                        this.showToast("Task berhasil diupdate", "success");
                    } catch (error) {
                        console.error("Failed to edit task:", error);
                        this.showToast("Gagal mengupdate task", "error");
                    }
                }
            }

            async deleteTask(index) {
                if (confirm("Apakah Anda yakin ingin menghapus task ini?")) {
                    try {
                        const token = localStorage.getItem("token");
                        const res = await fetch(`/api/projects/${this.projectId}/tasks/${index}`, {
                            method: "DELETE",
                            headers: {
                                "Authorization": "Bearer " + token
                            }
                        });

                        if (!res.ok) throw new Error("Gagal menghapus task");
                        this.tasks.splice(index, 1);

                        this.renderTasks();
                        this.updateStats();
                        this.showToast("Task berhasil dihapus", "success");
                    } catch (error) {
                        console.error("Failed to delete task:", error);
                        this.showToast("Gagal menghapus task", "error");
                    }
                }
            }

            async updateProjectTitle(newTitle) {
                try {
                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}`, {
                        method: "PUT",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ name: newTitle })
                    });

                    if (!res.ok) throw new Error("Gagal mengupdate judul project");
                    this.project.name = newTitle;
                    document.getElementById('project-title').textContent = newTitle;
                    this.showToast("Judul project berhasil diupdate", "success");

                } catch (error) {
                    console.error("Failed to update project title:", error);
                    this.showToast("Gagal mengupdate judul project", "error");
                }
            }

            // ===== AI FEATURES =====
            async aiExpandTasks() {
                const btn = document.getElementById('ai-expand-tasks-btn');
                const origHtml = btn ? btn.innerHTML : '';
                try {
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<span>⚡ Menganalisa...</span>';
                    }
                    this.showToast("AI sedang merumuskan 5 milestone tugas baru...", "info");

                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}/ai-expand`, {
                        method: "POST",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        }
                    });

                    if (!res.ok) throw new Error("Gagal memperluas milestone project");
                    const data = await res.json();

                    if (data.project && Array.isArray(data.project.tasks)) {
                        this.tasks = data.project.tasks;
                        this.renderTasks();
                        this.updateStats();
                    }

                    if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Milestone AI Ditambahkan!',
                            text: '5 milestone kerja strategis baru telah disematkan ke roadmap Anda.',
                            confirmButtonColor: '#4f46e5'
                        });
                    } else {
                        this.showToast("5 milestone baru berhasil ditambahkan!", "success");
                    }

                } catch (error) {
                    console.error("AI Expand error:", error);
                    this.showToast("Gagal memperluas task dengan AI", "error");
                } finally {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = origHtml;
                    }
                }
            }

            async aiRegenerateSummary() {
                const btn = document.getElementById('regenerate-btn');
                const origHtml = btn ? btn.innerHTML : '';
                try {
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<span>Meminta AI...</span>';
                    }
                    this.showToast("AI sedang meregenerasi ringkasan strategi...", "info");

                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}/ai-regenerate`, {
                        method: "POST",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        }
                    });

                    if (!res.ok) throw new Error("Gagal meregenerasi deskripsi");
                    const data = await res.json();

                    if (data.project && data.project.description) {
                        this.project.description = data.project.description;
                        document.getElementById('project-desc').textContent = data.project.description;
                    }

                    this.showToast("Ringkasan strategi berhasil diperbarui oleh AI!", "success");

                } catch (error) {
                    console.error("AI Regenerate error:", error);
                    this.showToast("Gagal meregenerasi summary", "error");
                } finally {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = origHtml;
                    }
                }
            }

            async openSwotModal() {
                const modal = document.getElementById('swot-modal');
                const content = document.getElementById('swot-modal-content');
                modal.classList.add('active');
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <div class="pulse-spinner" style="margin: 0 auto 16px;">
                            <div class="pulse-dot"></div>
                            <div class="pulse-dot"></div>
                            <div class="pulse-dot"></div>
                        </div>
                        <h4 style="font-size: 16px; font-weight: 600;">Menganalisis Kekuatan, Kelemahan, Peluang & Ancaman...</h4>
                        <p style="font-size: 13px; opacity: 0.7;">AI sedang membaca profil bisnis UMKM Anda.</p>
                    </div>`;

                try {
                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}/ai-swot`, {
                        method: "POST",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        }
                    });

                    if (!res.ok) throw new Error("Gagal melakukan analisis SWOT");
                    const data = await res.json();
                    const swot = data.swot || data.data || {};
                    const recs = swot.action_recommendations || swot.recommendations || [];

                    const renderList = (items) => {
                        if (!items || !items.length) return '<em>Tidak ada data</em>';
                        return '<ul style="padding-left: 20px; margin: 8px 0;">' + 
                            items.map(it => `<li style="margin: 4px 0; font-size: 13.5px;">${this.escapeHtml(it)}</li>`).join('') + 
                            '</ul>';
                    };

                    content.innerHTML = `
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px;">
                            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 16px;">
                                <h4 style="color: #059669; font-weight: 700; margin-bottom: 8px;">💪 Kekuatan (Strengths)</h4>
                                ${renderList(swot.strengths)}
                            </div>
                            <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 16px;">
                                <h4 style="color: #dc2626; font-weight: 700; margin-bottom: 8px;">⚠️ Kelemahan (Weaknesses)</h4>
                                ${renderList(swot.weaknesses)}
                            </div>
                            <div style="background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 12px; padding: 16px;">
                                <h4 style="color: #2563eb; font-weight: 700; margin-bottom: 8px;">🚀 Peluang (Opportunities)</h4>
                                ${renderList(swot.opportunities)}
                            </div>
                            <div style="background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 12px; padding: 16px;">
                                <h4 style="color: #d97706; font-weight: 700; margin-bottom: 8px;">🛡️ Ancaman (Threats)</h4>
                                ${renderList(swot.threats)}
                            </div>
                        </div>
                        <div style="background: rgba(99, 102, 241, 0.08); border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 12px; padding: 16px;">
                            <h4 style="color: #4f46e5; font-weight: 700; margin-bottom: 8px;">🎯 Rekomendasi Aksi Nyata:</h4>
                            ${renderList(recs)}
                        </div>
                    `;

                } catch (error) {
                    console.error("SWOT error:", error);
                    content.innerHTML = `<div style="text-align: center; color: #ef4444; padding: 20px;">Gagal menghasilkan analisis SWOT. Silakan periksa koneksi atau coba lagi.</div>`;
                }
            }

            async openPitchModal() {
                const modal = document.getElementById('pitch-modal');
                const content = document.getElementById('pitch-modal-content');
                modal.classList.add('active');
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <div class="pulse-spinner" style="margin: 0 auto 16px;">
                            <div class="pulse-dot"></div>
                            <div class="pulse-dot"></div>
                            <div class="pulse-dot"></div>
                        </div>
                        <h4 style="font-size: 16px; font-weight: 600;">Menyusun Materi Marketing & Copywriting UMKM...</h4>
                        <p style="font-size: 13px; opacity: 0.7;">AI sedang meracik hook TikTok, elevator pitch, dan pesan WhatsApp.</p>
                    </div>`;

                try {
                    const token = localStorage.getItem("token");
                    const res = await fetch(`/api/projects/${this.projectId}/ai-pitch`, {
                        method: "POST",
                        headers: {
                            "Authorization": "Bearer " + token,
                            "Content-Type": "application/json"
                        }
                    });

                    if (!res.ok) throw new Error("Gagal membuat materi marketing");
                    const data = await res.json();
                    const pitch = data.pitch || data.data || {};

                    const tiktokText = typeof pitch.tiktok_hook === 'object' && pitch.tiktok_hook !== null
                        ? `Hook: "${pitch.tiktok_hook.hook_text || ''}"\n\nIde Video:\n${pitch.tiktok_hook.video_idea || ''}`
                        : (pitch.tiktok_hook || '');

                    content.innerHTML = `
                        <div style="display: flex; flex-direction: column; gap: 18px;">
                            <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <strong style="color: #4f46e5; font-size: 14px;">⚡ Elevator Pitch (30 Detik)</strong>
                                    <button class="modal-btn secondary" style="padding: 4px 10px; font-size: 12px;" onclick="navigator.clipboard.writeText(document.getElementById('pitch-text-1').innerText); alert('Elevator Pitch disalin!');">Salin</button>
                                </div>
                                <p id="pitch-text-1" style="font-size: 13.5px; line-height: 1.5; color: var(--text-primary); white-space: pre-wrap;">${this.escapeHtml(pitch.elevator_pitch || '')}</p>
                            </div>

                            <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <strong style="color: #059669; font-size: 14px;">🎬 Script Hook TikTok & Reels</strong>
                                    <button class="modal-btn secondary" style="padding: 4px 10px; font-size: 12px;" onclick="navigator.clipboard.writeText(document.getElementById('pitch-text-2').innerText); alert('Script TikTok disalin!');">Salin</button>
                                </div>
                                <p id="pitch-text-2" style="font-size: 13.5px; line-height: 1.5; color: var(--text-primary); white-space: pre-wrap;">${this.escapeHtml(tiktokText)}</p>
                            </div>

                            <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <strong style="color: #e11d48; font-size: 14px;">📸 Instagram Caption + Hashtags</strong>
                                    <button class="modal-btn secondary" style="padding: 4px 10px; font-size: 12px;" onclick="navigator.clipboard.writeText(document.getElementById('pitch-text-3').innerText); alert('Caption Instagram disalin!');">Salin</button>
                                </div>
                                <p id="pitch-text-3" style="font-size: 13.5px; line-height: 1.5; color: var(--text-primary); white-space: pre-wrap;">${this.escapeHtml(pitch.instagram_caption || '')}</p>
                            </div>

                            <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <strong style="color: #16a34a; font-size: 14px;">💬 WhatsApp Broadcast Promo</strong>
                                    <button class="modal-btn secondary" style="padding: 4px 10px; font-size: 12px;" onclick="navigator.clipboard.writeText(document.getElementById('pitch-text-4').innerText); alert('Format WhatsApp disalin!');">Salin</button>
                                </div>
                                <p id="pitch-text-4" style="font-size: 13.5px; line-height: 1.5; color: var(--text-primary); white-space: pre-wrap;">${this.escapeHtml(pitch.whatsapp_broadcast || '')}</p>
                            </div>
                        </div>
                    `;

                } catch (error) {
                    console.error("Pitch error:", error);
                    content.innerHTML = `<div style="text-align: center; color: #ef4444; padding: 20px;">Gagal menghasilkan materi promosi. Silakan periksa koneksi atau coba lagi.</div>`;
                }
            }

            setupEventListeners() {
                // AI Expand Tasks button
                const aiExpandBtn = document.getElementById('ai-expand-tasks-btn');
                if (aiExpandBtn) {
                    aiExpandBtn.addEventListener('click', () => this.aiExpandTasks());
                }

                // AI SWOT button
                const swotBtn = document.getElementById('ai-swot-btn');
                if (swotBtn) {
                    swotBtn.addEventListener('click', () => this.openSwotModal());
                }

                // AI Pitch button
                const pitchBtn = document.getElementById('ai-pitch-btn');
                if (pitchBtn) {
                    pitchBtn.addEventListener('click', () => this.openPitchModal());
                }

                // Edit title button
                document.getElementById('edit-title-btn').addEventListener('click', () => {
                    const modal = document.getElementById('edit-title-modal');
                    const input = document.getElementById('edit-title-input');
                    input.value = this.project.name || '';
                    modal.classList.add('active');
                    input.focus();
                });

                // Delete project button
                document.getElementById('delete-project-btn').addEventListener('click', () => {
                    document.getElementById('delete-modal').classList.add('active');
                });

                // Add task button
                document.getElementById('add-task-btn').addEventListener('click', () => {
                    const modal = document.getElementById('add-task-modal');
                    document.getElementById('new-task-input').value = '';
                    modal.classList.add('active');
                });

                // Create first task button
                document.getElementById('create-first-task-btn').addEventListener('click', () => {
                    const modal = document.getElementById('add-task-modal');
                    if (modal) modal.classList.add('active');
                });

                // Add multiple tasks button
                const addMultiBtn = document.getElementById('add-multiple-btn');
                if (addMultiBtn) {
                    addMultiBtn.addEventListener('click', () => {
                        document.getElementById('add-multiple-modal').classList.add('active');
                    });
                }

                // Mark all done button
                const markAllBtn = document.getElementById('mark-all-done-btn');
                if (markAllBtn) {
                    markAllBtn.addEventListener('click', async () => {
                        if (confirm("Tandai semua task sebagai selesai?")) {
                            for (let i = 0; i < this.tasks.length; i++) {
                                if (!this.tasks[i].done) {
                                    await this.toggleTask(i);
                                }
                            }
                            this.showToast("Semua task ditandai selesai", "success");
                        }
                    });
                }

                // Clear done tasks button
                const clearDoneBtn = document.getElementById('clear-done-btn');
                if (clearDoneBtn) {
                    clearDoneBtn.addEventListener('click', async () => {
                        if (confirm("Hapus semua task yang sudah selesai?")) {
                            // Delete from back to front to keep indexes valid
                            for (let i = this.tasks.length - 1; i >= 0; i--) {
                                if (this.tasks[i].done) {
                                    await this.deleteTask(i);
                                }
                            }
                            this.showToast("Task selesai berhasil dihapus", "success");
                        }
                    });
                }

                // Copy description button
                document.getElementById('copy-desc-btn').addEventListener('click', () => {
                    const desc = this.project.description || '';
                    navigator.clipboard.writeText(desc).then(() => {
                        this.showToast("Summary berhasil dicopy", "success");
                    }).catch(() => {
                        this.showToast("Gagal menyalin summary", "error");
                    });
                });

                // Regenerate with AI button
                document.getElementById('regenerate-btn').addEventListener('click', () => {
                    if (confirm("Regenerate summary dengan AI? Summary yang ada akan diperbarui.")) {
                        this.aiRegenerateSummary();
                    }
                });

                // Export button
                document.getElementById('export-btn').addEventListener('click', () => {
                    this.exportProject();
                });

                // Share button
                document.getElementById('share-btn').addEventListener('click', () => {
                    this.shareProject();
                });
            }

            setupModals() {
                // Close modals when clicking X or cancel
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

                // Edit title modal save
                document.querySelector('#edit-title-modal .modal-btn.save').addEventListener('click', () => {
                    const newTitle = document.getElementById('edit-title-input').value.trim();
                    if (newTitle) {
                        this.updateProjectTitle(newTitle);
                        document.getElementById('edit-title-modal').classList.remove('active');
                    } else {
                        alert("Judul tidak boleh kosong");
                    }
                });

                // Add task modal save
                document.querySelector('#add-task-modal .modal-btn.save').addEventListener('click', () => {
                    const taskText = document.getElementById('new-task-input').value.trim();
                    const markAsDone = document.getElementById('mark-done-checkbox').checked;

                    if (taskText) {
                        this.addTask(taskText, markAsDone);
                        document.getElementById('add-task-modal').classList.remove('active');
                    } else {
                        alert("Task tidak boleh kosong");
                    }
                });

                // Add multiple tasks modal save
                document.querySelector('#add-multiple-modal .modal-btn.save').addEventListener('click', () => {
                    const tasksText = document.getElementById('multiple-tasks-input').value;
                    const taskLines = tasksText.split('\n').map(line => {
                        // Remove bullet points and dashes if present
                        return line.replace(/^[•\-\*]\s*/, '').trim();
                    }).filter(line => line.length > 0);

                    if (taskLines.length > 0) {
                        this.addMultipleTasks(taskLines);
                        document.getElementById('add-multiple-modal').classList.remove('active');
                    } else {
                        alert("Tidak ada task yang valid");
                    }
                });

                // Delete project modal confirmation
                document.querySelector('#delete-modal .modal-btn.delete').addEventListener('click', () => {
                    this.deleteProject();
                    document.getElementById('delete-modal').classList.remove('active');
                });

                // Enter key support in modals
                document.querySelectorAll('.modal-input, .modal-textarea').forEach(input => {
                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            const modal = input.closest('.modal');
                            const saveBtn = modal.querySelector('.modal-btn.save');
                            if (saveBtn) saveBtn.click();
                        }
                    });
                });
            }

            exportProject() {
                const exportData = {
                    project: this.project,
                    tasks: this.tasks,
                    stats: {
                        totalTasks: this.tasks.length,
                        completedTasks: this.tasks.filter(t => t.done).length,
                        progress: this.tasks.length > 0 ?
                            Math.round((this.tasks.filter(t => t.done).length / this.tasks.length) * 100) : 0,
                        exportDate: new Date().toISOString()
                    }
                };

                const dataStr = JSON.stringify(exportData, null, 2);
                const dataBlob = new Blob([dataStr], {
                    type: 'application/json'
                });
                const url = URL.createObjectURL(dataBlob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `project-${this.project.name || 'unnamed'}-${new Date().toISOString().split('T')[0]}.json`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

                this.showToast("Project berhasil diexport", "success");
            }

            shareProject() {
                if (navigator.share) {
                    navigator.share({
                        title: this.project.name || "NexaConsult Project",
                        text: `Check out my project: ${this.project.name}`,
                        url: window.location.href
                    }).then(() => {
                        this.showToast("Project berhasil dibagikan", "success");
                    }).catch(() => {
                        this.showToast("Berbagi dibatalkan", "info");
                    });
                } else {
                    // Fallback: copy URL to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        this.showToast("Link project berhasil dicopy", "success");
                    }).catch(() => {
                        this.showToast("Gagal menyalin link", "error");
                    });
                }
            }

            showError() {
                document.getElementById('loading-state').innerHTML = `
                    <div class="error-state">
                        <svg viewBox="0 0 24 24" width="64" height="64" style="color: var(--danger-color); margin-bottom: 20px;">
                            <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <h3>Gagal Memuat Project</h3>
                        <p>Tidak dapat memuat data project. Silakan coba lagi.</p>
                        <button onclick="location.reload()" style="margin-top: 20px; padding: 12px 24px; background: var(--accent-color); color: white; border: none; border-radius: 8px; cursor: pointer;">
                            Coba Lagi
                        </button>
                    </div>
                `;
            }

            showToast(message, type = "info") {
                // Remove existing toast
                const existingToast = document.querySelector('.toast');
                if (existingToast) existingToast.remove();

                // Create new toast
                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;
                toast.textContent = message;

                // Add styles
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    padding: 12px 24px;
                    border-radius: 8px;
                    color: white;
                    font-weight: 500;
                    z-index: 9999;
                    animation: slideInRight 0.3s ease-out;
                    background: ${type === 'success' ? 'var(--success-color)' : 
                               type === 'error' ? 'var(--danger-color)' : 
                               type === 'warning' ? 'var(--warning-color)' : 
                               'var(--info-color)'};
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
                const now = new Date();
                const diffTime = Math.abs(now - date);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays === 1) return 'Kemarin';
                if (diffDays < 7) return `${diffDays} hari lalu`;
                if (diffDays < 30) return `${Math.floor(diffDays / 7)} minggu lalu`;

                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            const projectId = "{{ $id }}";
            if (projectId) {
                window.projectDetail = new ProjectDetailManager(projectId);
            }
        });

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
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
        `;
        document.head.appendChild(style);
    </script>
@endsection
