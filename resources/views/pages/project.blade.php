@extends('layouts.app')

@section('title', 'Project - NexaConsult')

@section('content')
    <script src="/js/protect.js"></script>
    <div class="project-page">
        <!-- Header Section -->
        <div class="project-header">
            <div class="header-content">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"
                            stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                </div>
                <div class="header-info">
                    <h1>Manajemen Project</h1>
                    <p>Kelola dan pantau perkembangan bisnis Anda dengan mudah</p>
                </div>
                <button class="header-action-btn" onclick="window.location.href='/chatbot'">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span>Buat Project Baru</span>
                </button>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="filter-section">
            <div class="search-box">
                <svg class="search-icon" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2"
                        fill="none" />
                </svg>
                <input type="text" id="project-search" placeholder="Cari project..." class="search-input">
                <button class="clear-search" id="clear-search" style="display: none;">
                    <svg viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">
                    <svg viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span>Semua</span>
                </button>
                <button class="filter-btn" data-filter="active">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <span>Aktif</span>
                </button>
                <button class="filter-btn" data-filter="completed">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2"
                            fill="none" />
                    </svg>
                    <span>Selesai</span>
                </button>
                <button class="filter-btn" data-filter="draft">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="currentColor"
                            stroke-width="2" fill="none" />
                    </svg>
                    <span>Draft</span>
                </button>
            </div>
        </div>

        <!-- Projects Grid Section -->
        <div class="projects-grid-section">
            <!-- Stats Summary -->
            <div class="stats-summary">
                <div class="stat-item">
                    <div class="stat-icon summary">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M9 17v-7m3 7v-3m3 3v-5m4-4H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2z"
                                stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="stat-text">
                        <h3 id="total-projects">0</h3>
                        <p>Total Project</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon summary active">
                        <svg viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="stat-text">
                        <h3 id="active-count">0</h3>
                        <p>Sedang Berjalan</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon summary completed">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2"
                                fill="none" />
                        </svg>
                    </div>
                    <div class="stat-text">
                        <h3 id="completed-count">0</h3>
                        <p>Telah Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Projects Grid -->
            <div class="section-header">
                <h2>Daftar Project</h2>
                <div class="view-toggle">
                    <button class="view-btn active" id="grid-view">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M4 4h4v4H4zm0 6h4v4H4zm0 6h4v4H4zm6-12h4v4h-4zm0 6h4v4h-4zm0 6h4v4h-4zm6-12h4v4h-4zm0 6h4v4h-4zm0 6h4v4h-4z"
                                stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                    </button>
                    <button class="view-btn" id="list-view">
                        <svg viewBox="0 0 24 24">
                            <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loading-state" class="loading-state">
                <div class="loading-content">
                    <div class="pulse-spinner">
                        <div class="pulse-dot"></div>
                        <div class="pulse-dot"></div>
                        <div class="pulse-dot"></div>
                    </div>
                    <h3>Memuat Project...</h3>
                    <p>Sedang mengambil data project Anda</p>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="empty-state" style="display: none;">
                <div class="empty-illustration">
                    <svg viewBox="0 0 200 200">
                        <circle cx="100" cy="100" r="80" fill="var(--bg-secondary)"
                            stroke="var(--border-color)" stroke-width="2" />
                        <path d="M70,70 L130,130 M130,70 L70,130" stroke="var(--text-secondary)" stroke-width="4"
                            stroke-linecap="round" />
                        <path d="M100,60 L100,140 M60,100 L140,100" stroke="var(--accent-color)" stroke-width="3"
                            stroke-linecap="round" />
                    </svg>
                </div>
                <div class="empty-content">
                    <h3>Belum Ada Project</h3>
                    <p>Mulai buat project pertama Anda melalui konsultasi AI</p>
                    <button class="create-project-btn" onclick="window.location.href='/chatbot'">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                        <span>Buat Project dari AI</span>
                    </button>
                </div>
            </div>

            <!-- Projects Grid -->
            <div id="projects-container" class="projects-container grid-view">
                <!-- Projects akan dimuat di sini -->
            </div>

            <!-- Pagination -->
            <div id="pagination" class="pagination" style="display: none;">
                <button class="pagination-btn prev" disabled>
                    <svg viewBox="0 0 24 24">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    <span>Sebelumnya</span>
                </button>
                <div class="page-numbers">
                    <!-- Page numbers will be generated here -->
                </div>
                <button class="pagination-btn next">
                    <span>Selanjutnya</span>
                    <svg viewBox="0 0 24 24">
                        <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                </button>
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
        }

        /* ===== BASE STYLES ===== */
        .project-page {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        /* ===== HEADER SECTION ===== */
        .project-header {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            border-radius: var(--border-radius);
            padding: 32px 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .project-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .project-header::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
        }

        .header-icon {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .header-icon svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .header-info {
            flex: 1;
            margin: 0 40px;
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

        .header-action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 28px;
            background: white;
            color: var(--accent-color);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--card-shadow);
        }

        .header-action-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }

        .header-action-btn svg {
            width: 20px;
            height: 20px;
        }

        /* ===== FILTER SECTION ===== */
        .filter-section {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 24px;
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .search-box {
            flex: 1;
            min-width: 300px;
            position: relative;
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            padding: 4px;
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .search-box:focus-within {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(126, 60, 169, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: var(--text-secondary);
        }

        .search-input {
            width: 100%;
            padding: 16px 20px 16px 48px;
            background: transparent;
            border: none;
            color: var(--text-primary);
            font-size: 1rem;
            outline: none;
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .clear-search {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
            transition: var(--transition);
        }

        .clear-search:hover {
            color: var(--accent-color);
        }

        .filter-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-secondary);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border-color: transparent;
        }

        .filter-btn:hover:not(.active) {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .filter-btn svg {
            width: 18px;
            height: 18px;
        }

        /* ===== PROJECTS GRID SECTION ===== */
        .projects-grid-section {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 32px;
            border: 1px solid var(--border-color);
        }

        /* Stats Summary */
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 24px;
            background: var(--bg-secondary);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .stat-item:hover {
            transform: translateY(-5px);
            border-color: var(--accent-color);
            box-shadow: var(--card-shadow);
        }

        .stat-icon.summary {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.summary.active {
            background: rgba(52, 199, 89, 0.1);
            color: #34C759;
        }

        .stat-icon.summary.completed {
            background: rgba(0, 122, 255, 0.1);
            color: #007AFF;
        }

        .stat-icon.summary svg {
            width: 32px;
            height: 32px;
        }

        .stat-text h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .stat-text p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin: 4px 0 0;
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .section-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .view-toggle {
            display: flex;
            gap: 8px;
            background: var(--bg-secondary);
            padding: 4px;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
        }

        .view-btn {
            padding: 10px;
            background: none;
            border: none;
            border-radius: 8px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
        }

        .view-btn.active {
            background: white;
            color: var(--accent-color);
            box-shadow: var(--card-shadow);
        }

        .view-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Loading State */
        .loading-state {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            text-align: center;
        }

        .loading-content {
            max-width: 400px;
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

        .loading-content h3 {
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .loading-content p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* Empty State */
        .empty-state {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            text-align: center;
        }

        .empty-illustration {
            width: 200px;
            height: 200px;
            margin-bottom: 32px;
        }

        .empty-content h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .empty-content p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 32px;
            max-width: 500px;
        }

        .create-project-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--card-shadow);
        }

        .create-project-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }

        .create-project-btn svg {
            width: 20px;
            height: 20px;
        }

        /* Projects Container */
        .projects-container {
            display: grid;
            gap: 24px;
        }

        .projects-container.grid-view {
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        }

        .projects-container.list-view {
            grid-template-columns: 1fr;
        }

        /* Project Card */
        .project-card {
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
        }

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-shadow-hover);
            border-color: var(--accent-color);
        }

        .project-card-header {
            padding: 24px 24px 16px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .project-title-section {
            flex: 1;
        }

        .project-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 8px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .project-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(52, 199, 89, 0.1);
            color: #34C759;
        }

        .status-completed {
            background: rgba(0, 122, 255, 0.1);
            color: #007AFF;
        }

        .status-draft {
            background: rgba(142, 142, 147, 0.1);
            color: #8E8E93;
        }

        .project-menu {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: var(--transition);
        }

        .project-menu:hover {
            background: var(--bg-secondary);
            color: var(--accent-color);
        }

        .project-card-content {
            padding: 0 24px 20px;
        }

        .project-description {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0 0 24px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .project-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .meta-item svg {
            width: 16px;
            height: 16px;
            color: var(--accent-color);
        }

        .progress-section {
            padding: 20px 24px;
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .progress-bar {
            height: 6px;
            background: var(--border-color);
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-color), var(--text-primary));
            border-radius: 3px;
            transition: width 1s ease;
        }

        /* List View Specific */
        .projects-container.list-view .project-card {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 20px 24px;
        }

        .projects-container.list-view .project-card-header {
            padding: 0;
            flex: 1;
            min-width: 0;
        }

        .projects-container.list-view .project-card-content {
            padding: 0;
            flex: 2;
            min-width: 0;
        }

        .projects-container.list-view .progress-section {
            flex: 1;
            padding: 0 0 0 24px;
            background: none;
            border: none;
            min-width: 200px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .pagination-btn:hover:not(:disabled) {
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn svg {
            width: 18px;
            height: 18px;
        }

        .page-numbers {
            display: flex;
            gap: 8px;
        }

        .page-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .page-btn.active {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border-color: transparent;
        }

        .page-btn:hover:not(.active) {
            border-color: var(--accent-color);
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

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1024px) {
            .project-header {
                padding: 28px 32px;
            }

            .header-info h1 {
                font-size: 2rem;
            }

            .projects-container.grid-view {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .project-page {
                padding: 16px;
            }

            .project-header {
                padding: 24px;
                margin-bottom: 20px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .header-info {
                margin: 0;
            }

            .header-action-btn {
                width: 100%;
                justify-content: center;
            }

            .filter-section {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: auto;
            }

            .filter-buttons {
                justify-content: center;
            }

            .projects-grid-section {
                padding: 24px;
            }

            .projects-container.grid-view {
                grid-template-columns: 1fr;
            }

            .projects-container.list-view .project-card {
                flex-direction: column;
                align-items: stretch;
            }

            .projects-container.list-view .progress-section {
                padding: 20px 0 0;
                min-width: auto;
                border-top: 1px solid var(--border-color);
                margin-top: 20px;
            }

            .section-header {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .view-toggle {
                align-self: flex-start;
            }

            .pagination {
                flex-direction: column;
                gap: 12px;
            }

            .page-numbers {
                order: 2;
            }

            .pagination-btn.prev {
                order: 1;
            }

            .pagination-btn.next {
                order: 3;
            }
        }

        @media (max-width: 480px) {
            .project-header {
                padding: 20px;
            }

            .header-info h1 {
                font-size: 1.6rem;
            }

            .header-info p {
                font-size: 1rem;
            }

            .stat-item {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }

            .stats-summary {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                flex-direction: column;
            }

            .filter-btn {
                justify-content: center;
            }

            .project-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .project-meta {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>

    <script>
        // Project Management System
        class ProjectManager {
            constructor() {
                this.projects = [];
                this.filteredProjects = [];
                this.currentFilter = 'all';
                this.searchQuery = '';
                this.currentView = 'grid';
                this.currentPage = 1;
                this.projectsPerPage = 6;

                this.initialize();
            }

            initialize() {
                this.loadProjects();
                this.setupEventListeners();
                this.setupViewToggle();
            }

            async loadProjects() {
                try {
                    const token = localStorage.getItem("token");
                    const headers = token ? {
                        "Authorization": "Bearer " + token,
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    } : {};

                    const res = await fetch("/api/projects", {
                        method: "GET",
                        headers: headers,
                    });

                    if (!res.ok) throw new Error(`HTTP ${res.status}: ${res.statusText}`);

                    const json = await res.json();
                    this.projects = json.data || json.projects || [];

                    // Untuk debugging, log data yang diterima
                    console.log("Projects loaded:", this.projects);
                    if (this.projects.length > 0) {
                        console.log("Sample project tasks:", this.projects[0].tasks);
                        console.log("Sample project tasks structure:",
                            JSON.stringify(this.projects[0].tasks, null, 2));
                    }

                    this.updateStats();
                    this.filterProjects();
                    this.renderProjects();

                } catch (error) {
                    console.error("Failed to load projects:", error);
                    this.showErrorState();
                }
            }

            updateStats() {
                const total = this.projects.length;
                const active = this.projects.filter(p => p.status === 'active' || !p.status).length;
                const completed = this.projects.filter(p => p.status === 'completed').length;

                document.getElementById('total-projects').textContent = total;
                document.getElementById('active-count').textContent = active;
                document.getElementById('completed-count').textContent = completed;
            }

            filterProjects() {
                this.filteredProjects = this.projects.filter(project => {
                    // Apply search filter
                    const matchesSearch = !this.searchQuery ||
                        project.name?.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        project.description?.toLowerCase().includes(this.searchQuery.toLowerCase());

                    // Apply status filter
                    const matchesFilter = this.currentFilter === 'all' ||
                        project.status === this.currentFilter ||
                        (!project.status && this.currentFilter === 'active');

                    return matchesSearch && matchesFilter;
                });
            }

            renderProjects() {
                const container = document.getElementById('projects-container');
                const loadingState = document.getElementById('loading-state');
                const emptyState = document.getElementById('empty-state');
                const pagination = document.getElementById('pagination');

                // Hide loading state
                if (loadingState) loadingState.style.display = 'none';

                if (this.filteredProjects.length === 0) {
                    container.innerHTML = '';
                    if (emptyState) emptyState.style.display = 'flex';
                    if (pagination) pagination.style.display = 'none';
                    return;
                }

                // Hide empty state
                if (emptyState) emptyState.style.display = 'none';

                // Calculate pagination
                const totalPages = Math.ceil(this.filteredProjects.length / this.projectsPerPage);
                const startIndex = (this.currentPage - 1) * this.projectsPerPage;
                const endIndex = startIndex + this.projectsPerPage;
                const currentProjects = this.filteredProjects.slice(startIndex, endIndex);

                // Clear container
                container.innerHTML = '';

                // Render projects
                currentProjects.forEach(project => {
                    const projectCard = this.createProjectCard(project);
                    container.appendChild(projectCard);
                });

                // Update pagination
                this.updatePagination(totalPages);
            }

            calculateProjectProgress(project) {
                try {
                    // Cek apakah tasks ada dan merupakan array
                    if (!project.tasks || !Array.isArray(project.tasks)) {
                        console.log("No tasks or tasks is not array for project:", project.name);
                        return 0;
                    }

                    const totalTasks = project.tasks.length;

                    if (totalTasks === 0) {
                        return 0;
                    }

                    // Perbaiki: cari task.done (boolean) atau task.status === 'completed'
                    const completedTasks = project.tasks.filter(task => {
                        // Cek berbagai kemungkinan format task
                        if (typeof task === 'object' && task !== null) {
                            // Jika task memiliki property 'done' (boolean)
                            if (task.done === true) return true;

                            // Jika task memiliki property 'status'
                            if (task.status === 'completed') return true;

                            // Jika task memiliki property 'is_completed'
                            if (task.is_completed === true) return true;

                            // Jika task string dan mengandung indikator selesai
                            if (typeof task.text === 'string' && task.text.toLowerCase().includes('[done]'))
                                return true;
                        }
                        return false;
                    }).length;

                    console.log(`Project ${project.name}: ${completedTasks}/${totalTasks} tasks completed`);

                    const progress = Math.round((completedTasks / totalTasks) * 100);
                    return progress;

                } catch (error) {
                    console.error("Error calculating progress for project:", project.name, error);
                    return 0;
                }
            }

            createProjectCard(project) {
                const id = project._id?.$oid || project._id || project.id;
                const card = document.createElement('a');
                card.href = `/project/${id}`;
                card.className = 'project-card';

                // Calculate progress berdasarkan tasks yang ada
                const progress = this.calculateProjectProgress(project);

                // Hitung total tasks
                const totalTasks = Array.isArray(project.tasks) ? project.tasks.length : 0;

                // Format dates
                const createdDate = this.formatDate(project.createdAt || project.created_at);
                const updatedDate = this.formatDate(project.updatedAt || project.updated_at);

                // Get status class
                const statusClass = this.getStatusClass(project.status);

                card.innerHTML = `
                    <div class="project-card-header">
                        <div class="project-title-section">
                            <h3 class="project-title">${this.escapeHtml(project.name || 'Untitled Project')}</h3>
                            <span class="project-status ${statusClass}">
                                ${this.getStatusIcon(project.status)}
                                ${project.status || 'draft'}
                            </span>
                        </div>
                        <button class="project-menu" onclick="event.preventDefault(); event.stopPropagation();">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                    <div class="project-card-content">
                        <p class="project-description">
                            ${this.escapeHtml(project.description || 'No description available')}
                        </p>
                        <div class="project-meta">
                            <span class="meta-item">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" fill="none"/>
                                </svg>
                                Dibuat: ${createdDate}
                            </span>
                            <span class="meta-item">
                                <svg viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2v-5" stroke="currentColor" stroke-width="2" fill="none"/>
                                </svg>
                                Diupdate: ${updatedDate}
                            </span>
                            <span class="meta-item">
                                <svg viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="2" fill="none"/>
                                </svg>
                                ${totalTasks} Tasks
                            </span>
                        </div>
                    </div>
                    <div class="progress-section">
                        <div class="progress-label">
                            <span>Progress</span>
                            <span>${progress}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${progress}%"></div>
                        </div>
                    </div>
                `;

                return card;
            }

            updatePagination(totalPages) {
                const pagination = document.getElementById('pagination');
                const pageNumbers = document.querySelector('.page-numbers');
                const prevBtn = document.querySelector('.pagination-btn.prev');
                const nextBtn = document.querySelector('.pagination-btn.next');

                if (totalPages <= 1) {
                    pagination.style.display = 'none';
                    return;
                }

                pagination.style.display = 'flex';

                // Update previous button
                prevBtn.disabled = this.currentPage === 1;
                prevBtn.onclick = () => {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.renderProjects();
                    }
                };

                // Update next button
                nextBtn.disabled = this.currentPage === totalPages;
                nextBtn.onclick = () => {
                    if (this.currentPage < totalPages) {
                        this.currentPage++;
                        this.renderProjects();
                    }
                };

                // Update page numbers
                pageNumbers.innerHTML = '';
                const maxVisiblePages = 5;
                let startPage = Math.max(1, this.currentPage - Math.floor(maxVisiblePages / 2));
                let endPage = startPage + maxVisiblePages - 1;

                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = Math.max(1, endPage - maxVisiblePages + 1);
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `page-btn ${i === this.currentPage ? 'active' : ''}`;
                    pageBtn.textContent = i;
                    pageBtn.onclick = () => {
                        this.currentPage = i;
                        this.renderProjects();
                    };
                    pageNumbers.appendChild(pageBtn);
                }
            }

            setupEventListeners() {
                // Search input
                const searchInput = document.getElementById('project-search');
                const clearSearch = document.getElementById('clear-search');

                if (searchInput) {
                    searchInput.addEventListener('input', (e) => {
                        this.searchQuery = e.target.value;
                        clearSearch.style.display = this.searchQuery ? 'block' : 'none';
                        this.currentPage = 1;
                        this.filterProjects();
                        this.renderProjects();
                    });
                }

                if (clearSearch) {
                    clearSearch.addEventListener('click', () => {
                        searchInput.value = '';
                        this.searchQuery = '';
                        clearSearch.style.display = 'none';
                        this.currentPage = 1;
                        this.filterProjects();
                        this.renderProjects();
                    });
                }

                // Filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove(
                            'active'));
                        e.currentTarget.classList.add('active');

                        this.currentFilter = e.currentTarget.dataset.filter;
                        this.currentPage = 1;
                        this.filterProjects();
                        this.renderProjects();
                    });
                });
            }

            setupViewToggle() {
                const gridViewBtn = document.getElementById('grid-view');
                const listViewBtn = document.getElementById('list-view');
                const container = document.getElementById('projects-container');

                if (gridViewBtn && listViewBtn && container) {
                    gridViewBtn.addEventListener('click', () => {
                        gridViewBtn.classList.add('active');
                        listViewBtn.classList.remove('active');
                        container.classList.remove('list-view');
                        container.classList.add('grid-view');
                        this.currentView = 'grid';
                    });

                    listViewBtn.addEventListener('click', () => {
                        listViewBtn.classList.add('active');
                        gridViewBtn.classList.remove('active');
                        container.classList.remove('grid-view');
                        container.classList.add('list-view');
                        this.currentView = 'list';
                    });
                }
            }

            showErrorState() {
                const loadingState = document.getElementById('loading-state');
                const emptyState = document.getElementById('empty-state');

                if (loadingState) loadingState.style.display = 'none';

                if (emptyState) {
                    emptyState.querySelector('h3').textContent = 'Terjadi Kesalahan';
                    emptyState.querySelector('p').textContent = 'Gagal memuat daftar project. Silakan coba lagi.';
                    emptyState.style.display = 'flex';
                }
            }

            // Utility methods
            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

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

            getStatusClass(status) {
                const statusMap = {
                    'active': 'status-active',
                    'completed': 'status-completed',
                    'draft': 'status-draft'
                };
                return statusMap[status] || 'status-draft';
            }

            getStatusIcon(status) {
                const iconMap = {
                    'active': `<svg viewBox="0 0 24 24" width="12" height="12">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>`,
                    'completed': `<svg viewBox="0 0 24 24" width="12" height="12">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>`,
                    'draft': `<svg viewBox="0 0 24 24" width="12" height="12">
                        <path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>`
                };
                return iconMap[status] || '';
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            window.projectManager = new ProjectManager();
        });
    </script>
@endsection
