@extends('layouts.app')

@section('title', 'AI Landing Page Studio - NexaConsult')

@section('content')
<script src="/js/protect.js"></script>

<style>
    @media (max-width: 992px) {
        .studio-wrapper {
            height: auto !important;
            padding-bottom: 40px;
        }
        .studio-split-grid {
            grid-template-columns: 1fr !important;
            height: auto !important;
        }
        .preview-pane-wrapper {
            min-height: 600px !important;
        }
    }
</style>

<div class="studio-wrapper" style="max-width: 1360px; margin: 0 auto; height: calc(100vh - 120px); display: flex; flex-direction: column; gap: 16px;">
    <!-- Studio Header Bar -->
    <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 16px; padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; box-shadow: var(--shadow);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, #10B981, #059669); color: white; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                🌐
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <h2 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin: 0;">AI Landing Page Studio</h2>
                    <span style="font-size: 11px; font-weight: 700; color: #059669; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 2px 8px; border-radius: 999px;">Lovable-Style Engine</span>
                </div>
                <p style="font-size: 12.5px; color: var(--text-secondary); margin: 2px 0 0;">Generate website usaha mandiri secara instan dan langsung ter-hosting otomatis untuk publik.</p>
            </div>
        </div>

        <!-- Top Right Actions -->
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div id="liveBadge" style="display: none; align-items: center; gap: 6px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #059669; font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 999px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; animation: pulse 2s infinite;"></span>
                <span>Auto-Hosted Live</span>
            </div>

            <button id="btnCopyUrl" onclick="window.studio.copyPublicUrl()" style="display: none; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 12.5px; font-weight: 600; cursor: pointer;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span>Salin Link Publik</span>
            </button>

            <a id="btnOpenPublic" href="#" target="_blank" style="display: none; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 10px; background: #4f46e5; color: white; font-size: 12.5px; font-weight: 600; text-decoration: none; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);">
                <span>Buka Web ↗️</span>
            </a>

            <button id="btnDownloadHtml" onclick="window.studio.downloadHtml()" style="display: none; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--card-bg); color: var(--text-primary); font-size: 12.5px; font-weight: 600; cursor: pointer;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                <span>Unduh HTML</span>
            </button>
        </div>
    </div>

    <!-- Main Studio Split Grid -->
    <div class="studio-split-grid" style="flex: 1; display: grid; grid-template-columns: 380px 1fr; gap: 18px; min-height: 0;">
        <!-- Left Panel: Generator & Editor Controls -->
        <div style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 18px; padding: 22px; display: flex; flex-direction: column; justify-content: space-between; overflow-y: auto; box-shadow: var(--shadow);">
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Pre-fill from project select -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Pilih Proyek UMKM (Opsional)</label>
                    <select id="projectSelect" onchange="window.studio.onProjectSelected()" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 13px; outline: none;">
                        <option value="">-- Buat Dari Nol / Ketik Manual --</option>
                    </select>
                </div>

                <!-- Business Name -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Nama Usaha / Brand</label>
                    <input type="text" id="inputTitle" placeholder="Contoh: Keripik Singkong Renyah Bu Mawar" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 13px; outline: none;">
                </div>

                <!-- Slug -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Custom URL Slug</label>
                    <div style="display: flex; align-items: center; background: var(--bg-primary); border: 1px solid var(--border-color); border-radius: 10px; padding: 0 10px; font-size: 12px; color: var(--text-secondary);">
                        <span>/site/</span>
                        <input type="text" id="inputSlug" placeholder="keripik-bu-mawar" style="flex: 1; padding: 9px 4px; background: transparent; border: none; color: var(--text-primary); font-size: 13px; outline: none;">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Deskripsi Usaha & Keunggulan</label>
                    <textarea id="inputDesc" rows="3" placeholder="Jelaskan produk, varian rasa, sertifikasi halal, dan target pasar Anda..." style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 12.5px; outline: none; line-height: 1.4;"></textarea>
                </div>

                <!-- WhatsApp -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Nomor WhatsApp Penjual (Order)</label>
                    <input type="text" id="inputWa" value="081234567890" placeholder="08xxxxxxxxxx" style="width: 100%; padding: 9px 12px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 13px; outline: none;">
                </div>

                <!-- Theme Color -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Aksen Warna Tema</label>
                    <div style="display: flex; gap: 8px;">
                        <button type="button" class="theme-color-btn active" data-color="indigo" onclick="window.studio.setTheme('indigo', this)" style="flex: 1; padding: 8px 0; border-radius: 8px; border: 2px solid #4f46e5; background: #e0e7ff; color: #4338ca; font-size: 11px; font-weight: 700; cursor: pointer;">Indigo</button>
                        <button type="button" class="theme-color-btn" data-color="emerald" onclick="window.studio.setTheme('emerald', this)" style="flex: 1; padding: 8px 0; border-radius: 8px; border: 1px solid var(--border-color); background: #ecfdf5; color: #047857; font-size: 11px; font-weight: 700; cursor: pointer;">Emerald</button>
                        <button type="button" class="theme-color-btn" data-color="rose" onclick="window.studio.setTheme('rose', this)" style="flex: 1; padding: 8px 0; border-radius: 8px; border: 1px solid var(--border-color); background: #ffe4e6; color: #be123c; font-size: 11px; font-weight: 700; cursor: pointer;">Rose</button>
                        <button type="button" class="theme-color-btn" data-color="amber" onclick="window.studio.setTheme('amber', this)" style="flex: 1; padding: 8px 0; border-radius: 8px; border: 1px solid var(--border-color); background: #fef3c7; color: #b45309; font-size: 11px; font-weight: 700; cursor: pointer;">Amber</button>
                    </div>
                </div>

                <!-- Custom Prompt Refinement -->
                <div>
                    <label style="font-size: 12.5px; font-weight: 700; color: var(--text-primary); display: block; margin-bottom: 6px;">Instruksi Khusus ke AI (Opsional)</label>
                    <input type="text" id="inputCustomPrompt" placeholder="Contoh: Tambahkan diskon bundling 20% & promo ongkir" style="width: 100%; padding: 8px 12px; border-radius: 10px; border: 1px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary); font-size: 12px; outline: none;">
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
                <button type="button" id="btnGenerate" onclick="window.studio.generateLandingPage()" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; border-radius: 12px; background: linear-gradient(135deg, #4f46e5, #7c3aed); color: white; font-weight: 700; font-size: 14px; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(79, 70, 229, 0.35); transition: all 0.2s;">
                    <span>✨ Generate dengan AI</span>
                </button>

                <button type="button" id="btnPublish" onclick="window.studio.publishLandingPage()" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; border-radius: 12px; background: linear-gradient(135deg, #059669, #10b981); color: white; font-weight: 700; font-size: 13.5px; border: none; cursor: pointer; box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3); transition: all 0.2s;">
                    <span>🚀 Publikasikan (Auto-Hosting)</span>
                </button>
            </div>
        </div>

        <!-- Right Panel: Device Preview Screen -->
        <div class="preview-pane-wrapper" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 18px; display: flex; flex-direction: column; overflow: hidden; box-shadow: var(--shadow);">
            <!-- Device View Switcher Toolbar -->
            <div style="padding: 10px 20px; border-bottom: 1px solid var(--border-color); background: var(--bg-primary); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 6px; background: var(--card-bg); padding: 4px; border-radius: 10px; border: 1px solid var(--border-color);">
                    <button type="button" class="device-btn active" onclick="window.studio.setDevice('desktop', this)" title="Desktop View" style="padding: 5px 12px; border-radius: 7px; border: none; background: #e0e7ff; color: #4338ca; font-size: 12px; font-weight: 600; cursor: pointer;">
                        💻 Desktop
                    </button>
                    <button type="button" class="device-btn" onclick="window.studio.setDevice('tablet', this)" title="Tablet View" style="padding: 5px 12px; border-radius: 7px; border: none; background: transparent; color: var(--text-secondary); font-size: 12px; font-weight: 600; cursor: pointer;">
                        📱 Tablet (768px)
                    </button>
                    <button type="button" class="device-btn" onclick="window.studio.setDevice('mobile', this)" title="Mobile View" style="padding: 5px 12px; border-radius: 7px; border: none; background: transparent; color: var(--text-secondary); font-size: 12px; font-weight: 600; cursor: pointer;">
                        📱 Mobile (375px)
                    </button>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                    <span id="previewStatusText" style="font-size: 12px; color: var(--text-secondary); font-weight: 500;">Pratinjau Langsung</span>
                    <button onclick="window.studio.reloadPreview()" title="Muat Ulang Iframe" style="background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 4px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </button>
                </div>
            </div>

            <!-- Iframe Sandbox Container -->
            <div id="previewFrameContainer" style="flex: 1; background: #cbd5e1; display: flex; justify-content: center; align-items: center; overflow: auto; padding: 12px;">
                <iframe id="previewFrame" style="width: 100%; height: 100%; border: none; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); transition: width 0.3s ease;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    class LandingPageStudioManager {
        constructor() {
            this.token = localStorage.getItem('token');
            this.themeColor = 'indigo';
            this.currentHtml = '';
            this.publishedSlug = '';
            this.projects = [];
        }

        async init() {
            if (!this.token) {
                window.location.href = '/login';
                return;
            }

            await this.loadProjects();

            // Check if projectId is in query param
            const urlParams = new URLSearchParams(window.location.search);
            const projectId = urlParams.get('project_id');
            if (projectId) {
                const proj = this.projects.find(p => (p._id || p.id) === projectId);
                if (proj) {
                    document.getElementById('projectSelect').value = projectId;
                    this.fillFromProject(proj);
                }
            } else if (this.projects.length > 0) {
                // Auto-fill first project as demonstration
                this.fillFromProject(this.projects[0]);
            } else {
                document.getElementById('inputTitle').value = 'Keripik Singkong Renyah Bu Mawar';
                document.getElementById('inputDesc').value = 'Pengembangan usaha olahan keripik singkong aneka rasa dengan kemasan standing pouch premium, sertifikasi Halal & PIRT, serta penjualan multichannel via TikTok Shop.';
                document.getElementById('inputSlug').value = 'keripik-bu-mawar';
            }

            // Generate initial preview
            this.generateLandingPage();
        }

        async loadProjects() {
            try {
                const res = await fetch('/api/projects', {
                    headers: { 'Authorization': 'Bearer ' + this.token, 'Accept': 'application/json' }
                });
                if (!res.ok) return;
                const json = await res.json();
                this.projects = json.data || [];
                const select = document.getElementById('projectSelect');
                this.projects.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p._id || p.id;
                    opt.textContent = p.name;
                    select.appendChild(opt);
                });
            } catch (e) {
                console.error(e);
            }
        }

        fillFromProject(proj) {
            document.getElementById('inputTitle').value = proj.name || '';
            document.getElementById('inputDesc').value = proj.description || '';
            const slug = (proj.name || 'usaha')
                .toLowerCase()
                .replace(/[^a-z0-9]/g, '-')
                .replace(/-+/g, '-')
                .slice(0, 30);
            document.getElementById('inputSlug').value = slug;
        }

        onProjectSelected() {
            const val = document.getElementById('projectSelect').value;
            const proj = this.projects.find(p => (p._id || p.id) === val);
            if (proj) {
                this.fillFromProject(proj);
            }
        }

        setTheme(color, btn) {
            this.themeColor = color;
            document.querySelectorAll('.theme-color-btn').forEach(b => {
                b.classList.remove('active');
                b.style.border = '1px solid var(--border-color)';
            });
            btn.classList.add('active');
            btn.style.border = '2px solid #4f46e5';
        }

        setDevice(device, btn) {
            document.querySelectorAll('.device-btn').forEach(b => {
                b.style.background = 'transparent';
                b.style.color = 'var(--text-secondary)';
            });
            btn.style.background = '#e0e7ff';
            btn.style.color = '#4338ca';

            const frame = document.getElementById('previewFrame');
            if (device === 'mobile') {
                frame.style.width = '375px';
            } else if (device === 'tablet') {
                frame.style.width = '768px';
            } else {
                frame.style.width = '100%';
            }
        }

        async generateLandingPage() {
            const title = document.getElementById('inputTitle').value.trim();
            const desc = document.getElementById('inputDesc').value.trim();
            const wa = document.getElementById('inputWa').value.trim();
            const customPrompt = document.getElementById('inputCustomPrompt').value.trim();

            if (!title || !desc) {
                alert('Nama usaha dan deskripsi wajib diisi.');
                return;
            }

            const btn = document.getElementById('btnGenerate');
            const origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span>⚡ Meracik Desain AI...</span>';
            document.getElementById('previewStatusText').textContent = 'AI sedang merancang landing page...';

            try {
                const res = await fetch('/api/landing-page/generate', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + this.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        description: desc,
                        theme_color: this.themeColor,
                        whatsapp_number: wa,
                        custom_prompt: customPrompt
                    })
                });

                if (!res.ok) throw new Error('Gagal meng-generate landing page.');
                const json = await res.json();
                this.currentHtml = json.data?.html_content || '';

                this.renderIframe(this.currentHtml);
                document.getElementById('previewStatusText').textContent = 'Pratinjau Siap!';

                // Enable download
                document.getElementById('btnDownloadHtml').style.display = 'inline-flex';

            } catch (e) {
                alert(e.message);
                document.getElementById('previewStatusText').textContent = 'Gagal memuat pratinjau.';
            } finally {
                btn.disabled = false;
                btn.innerHTML = origHtml;
            }
        }

        renderIframe(html) {
            const frame = document.getElementById('previewFrame');
            frame.srcdoc = html;
        }

        reloadPreview() {
            if (this.currentHtml) {
                this.renderIframe(this.currentHtml);
            }
        }

        async publishLandingPage() {
            const title = document.getElementById('inputTitle').value.trim();
            const slug = document.getElementById('inputSlug').value.trim();
            const wa = document.getElementById('inputWa').value.trim();
            const projId = document.getElementById('projectSelect').value;

            if (!this.currentHtml) {
                alert('Silakan generate landing page terlebih dahulu.');
                return;
            }

            const btn = document.getElementById('btnPublish');
            const origHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span>🚀 Mempublikasikan...</span>';

            try {
                const res = await fetch('/api/landing-page/save', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + this.token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        slug: slug,
                        project_id: projId || null,
                        html_content: this.currentHtml,
                        theme_color: this.themeColor,
                        whatsapp_number: wa
                    })
                });

                if (!res.ok) throw new Error('Gagal mempublikasikan landing page.');
                const json = await res.json();
                
                this.publishedSlug = json.data.slug;
                const publicUrl = json.public_url;

                // Show top-right badges
                document.getElementById('liveBadge').style.display = 'inline-flex';
                const copyBtn = document.getElementById('btnCopyUrl');
                copyBtn.style.display = 'inline-flex';
                copyBtn.setAttribute('data-url', publicUrl);

                const openBtn = document.getElementById('btnOpenPublic');
                openBtn.style.display = 'inline-flex';
                openBtn.href = publicUrl;

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: '🎉 Landing Page Sukses Ter-Hosting!',
                        html: `<p>Website Anda telah aktif dan dapat diakses oleh siapa saja secara publik:</p><p style="margin-top: 10px; font-weight: bold; color: #4f46e5;"><a href="${publicUrl}" target="_blank">${publicUrl}</a></p>`,
                        confirmButtonText: 'Buka Website Publik',
                        confirmButtonColor: '#10B981',
                        showCancelButton: true,
                        cancelButtonText: 'Tutup'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(publicUrl, '_blank');
                        }
                    });
                } else {
                    alert(`Website aktif di: ${publicUrl}`);
                }

            } catch (e) {
                alert(e.message);
            } finally {
                btn.disabled = false;
                btn.innerHTML = origHtml;
            }
        }

        copyPublicUrl() {
            const copyBtn = document.getElementById('btnCopyUrl');
            const url = copyBtn.getAttribute('data-url') || (window.location.origin + '/site/' + this.publishedSlug);
            navigator.clipboard.writeText(url).then(() => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Link publik landing page berhasil disalin ke clipboard.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Link publik berhasil disalin!');
                }
            });
        }

        downloadHtml() {
            if (!this.currentHtml) return;
            const blob = new Blob([this.currentHtml], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${document.getElementById('inputSlug').value || 'landing-page'}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        window.studio = new LandingPageStudioManager();
        window.studio.init();
    });
</script>
@endsection
