document.addEventListener("DOMContentLoaded", () => {
    console.log("NexaConsult app.js loaded");

    // ============================================================
    // AUTH HEADERS
    // ============================================================
    function authHeaders() {
        const token = localStorage.getItem("token");
        if (!token) return {};

        return {
            "Authorization": "Bearer " + token,
            "Content-Type": "application/json",
            "Accept": "application/json",
        };
    }

    // ============================================================
    // CHATBOT
    // ============================================================
    const chatBox   = document.getElementById("chatHistory");
    const chatInput = document.getElementById("chatInput");
    const sendBtn   = document.getElementById("sendBtn");

    // Simpan context terakhir ke localStorage
    function saveContext(ctx) {
        localStorage.setItem("last_context", ctx);
    }

    function getContext() {
        return localStorage.getItem("last_context") || null;
    }

    // Render chat bubble
    function addMessage(text, sender = "bot", project_id = null) {
        const div = document.createElement("div");
        div.className = `chat-message ${sender}`;

        let content = `<div class="message-content">${text}</div>`;

        if (project_id) {
            content += `
                <a href="/project/${project_id}"
                   class="inline-block mt-2 px-3 py-1 bg-blue-600 text-white rounded text-sm">
                    ➜ Lihat Project Manager
                </a>
            `;
        }

        div.innerHTML = content;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Load history
    function loadChatHistory() {
        const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
        history.forEach(m => addMessage(m.text, m.sender, m.project_id));
    }

    function saveMessage(text, sender = "bot", project_id = null) {
        const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
        history.push({ text, sender, project_id });
        localStorage.setItem("chat_history", JSON.stringify(history));
    }

    // KIRIM KE AI
    async function sendToAI(msg) {
        addMessage(msg, "user");
        saveMessage(msg, "user");

        let context = null;

        // jika user jawab "ya" → kirim context terakhir
        if (msg.toLowerCase() === "ya") {
            context = getContext();
            if (!context) {
                addMessage("Konfirmasi diterima tapi context kosong.", "bot");
                return;
            }
        }

        // loading bubble
        const loading = document.createElement("div");
        loading.className = "chat-message bot";
        loading.innerHTML = `<div class="message-content">Sedang memproses...</div>`;
        chatBox.appendChild(loading);

        try {
            const res = await fetch("/api/ai/consult", {
                method: "POST",
                headers: authHeaders(),
                body: JSON.stringify({
                    prompt: msg,
                    context: context || null

                }),
            });

            const data = await res.json();
            loading.remove();

            // Jika AI mode konsultasi → simpan context
            if (data.status === "consult") {
                saveContext(data.context);
            }

            // final reply
            const reply = 
                data.project?.description ||
                data.message ||
                "Tidak ada respon AI.";

            const projectId =
                data.project?._id?.$oid ||
                data.project?._id ||
                null;

            addMessage(reply, "bot", projectId);
            saveMessage(reply, "bot", projectId);

        } catch (e) {
            loading.remove();
            addMessage("Gagal menghubungi server", "bot");
        }
    }

    if (sendBtn && chatInput) {
        sendBtn.addEventListener("click", () => {
            const msg = chatInput.value.trim();
            if (!msg) return;
            chatInput.value = "";
            sendToAI(msg);
        });

        chatInput.addEventListener("keypress", e => {
            if (e.key === "Enter") sendBtn.click();
        });

        // load chat history
        loadChatHistory();
    }

    // ============================================================
    // PROJECT LIST PAGE
    // ============================================================
    async function loadProjectData() {
        const list = document.getElementById("project-list");
        if (!list) return;

        try {
            const res = await fetch("/api/projects", {
                method: "GET",
                headers: authHeaders(),
            });

            const json = await res.json();
            list.innerHTML = "";

            const projects = json.data || json.projects || [];

            projects.forEach(p => {
                const id = p._id?.$oid || p._id || null;
                const li = document.createElement("li");
                li.innerHTML = `<a href="/project/${id}">${p.name}</a>`;
                list.appendChild(li);
            });
        } catch (e) {
            console.warn("Gagal load project:", e);
        }
    }

    loadProjectData();

    // ============================================================
    // PROFILE PAGE
    // ============================================================
    async function loadProfileData() {
        if (!document.getElementById("profile-page")) return;

        try {
            const res = await fetch("/api/auth/me", {
                method: "GET",
                headers: authHeaders(),
            });

            const json = await res.json();

            document.getElementById("user-name").textContent =
                json.user?.name ?? "-";

            document.getElementById("user-email").textContent =
                json.user?.email ?? "-";

        } catch (e) {
            console.log("Profile error:", e);
        }
    }

    loadProfileData();
});

