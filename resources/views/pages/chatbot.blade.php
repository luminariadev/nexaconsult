@extends('layouts.app')

@section('title', 'Chatbot - NexaConsult')

@section('content')
    <script src="/js/protect.js"></script>
    <div class="chatbot-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="header-content">
                <svg class="header-icon" viewBox="0 0 32 32">
                    <path
                        d="M13 8H19C20.6569 8 22 9.34315 22 11V14H26C27.6569 14 29 15.3431 29 17V23C29 24.6569 27.6569 26 26 26H6C4.34315 26 3 24.6569 3 23V17C3 15.3431 4.34315 14 6 14H10V11C10 9.34315 11.3431 8 13 8Z"
                        stroke="currentColor" stroke-width="2" fill="none" />
                    <circle cx="16" cy="20" r="2" fill="currentColor" />
                </svg>
                <div class="header-info">
                    <h2>NexaConsult AI</h2>
                    <p>Siap membantu pengembangan UMKM Anda</p>
                </div>
            </div>
            <button class="new-chat-btn" id="newChatBtn">
                <svg class="new-chat-icon" viewBox="0 0 24 24">
                    <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>Chat Baru</span>
            </button>
        </div>

        <!-- Chat Messages Area -->
        <div class="chat-messages" id="chatMessages">
            <!-- Chat history akan dimuat otomatis -->
        </div>

        <!-- Chat Input Area -->
        <div class="chat-input-area">
            <div class="input-wrapper">
                <input type="text" id="chatInput" class="chat-input" placeholder="Ketik pesan Anda..."
                    autocomplete="off">
                <button id="sendBtn" class="send-btn">
                    <svg class="send-icon" viewBox="0 0 24 24">
                        <path d="M22 2L11 13M22 2L15 22L11 13M11 13L2 9L22 2" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Quick Suggestions -->
            <div class="quick-suggestions">
                <div class="suggestion-buttons">
                    <button class="suggestion-btn" data-prompt="Saya ingin membuka usaha makanan ringan">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2C8.134 2 5 5.134 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.866-3.134-7-7-7z"
                                stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        <span>Usaha Makanan</span>
                    </button>
                    <button class="suggestion-btn" data-prompt="Bagaimana cara memulai bisnis online dengan modal kecil?">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"
                                stroke="currentColor" stroke-width="2" fill="none" />
                            <path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12" stroke="currentColor" stroke-width="2"
                                fill="none" />
                        </svg>
                        <span>Bisnis Online</span>
                    </button>
                    <button class="suggestion-btn" data-prompt="Strategi pemasaran untuk toko kelontong UMKM">
                        <svg viewBox="0 0 24 24">
                            <path
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        <span>Toko Kelontong</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ===== CHAT CONTAINER ===== */
        .chatbot-container {
            max-width: 800px;
            margin: 20px auto;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 20px var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 120px);
        }

        /* ===== CHAT HEADER ===== */
        .chat-header {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 36px;
            height: 36px;
            color: white;
        }

        .header-info h2 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }

        .header-info p {
            font-size: 14px;
            opacity: 0.9;
            margin: 4px 0 0;
        }

        .new-chat-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .new-chat-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .new-chat-icon {
            width: 18px;
            height: 18px;
        }

        /* ===== CHAT MESSAGES ===== */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
            background: var(--bg-secondary);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Message Container */
        .message-container {
            display: flex;
            gap: 12px;
            max-width: 85%;
            animation: messageSlideIn 0.3s ease-out;
        }

        /* User Message - RIGHT SIDE */
        .message-container.user {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        /* AI Message - LEFT SIDE */
        .message-container.ai {
            align-self: flex-start;
        }

        /* Avatar */
        .message-avatar {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .message-container.user .message-avatar {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            border: none;
        }

        .message-avatar svg {
            width: 20px;
            height: 20px;
        }

        .message-container.user .message-avatar svg {
            color: white;
        }

        /* Message Content */
        .message-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .message-container.user .message-content {
            align-items: flex-end;
        }

        .message-container.ai .message-content {
            align-items: flex-start;
        }

        /* Message Bubble */
        .message-bubble {
            padding: 16px;
            border-radius: 18px;
            line-height: 1.5;
            font-size: 15px;
            word-wrap: break-word;
            max-width: 100%;
            position: relative;
            animation: bubbleAppear 0.3s ease-out;
        }

        /* User Message Bubble (RIGHT SIDE - Blue/Accent) */
        .message-container.user .message-bubble {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            border-bottom-right-radius: 4px;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            border-bottom-left-radius: 18px;
        }

        /* AI Message Bubble (LEFT SIDE - White/Card) */
        .message-container.ai .message-bubble {
            background: var(--card-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-bottom-left-radius: 4px;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }

        .message-bubble h2,
        .message-bubble h3,
        .message-bubble h4 {
            margin: 14px 0 6px;
            font-weight: 700;
            line-height: 1.35;
        }

        .message-bubble h2 {
            font-size: 1.2rem;
            color: #4338ca;
        }

        .message-bubble h3 {
            font-size: 1.05rem;
            color: #4f46e5;
        }

        .message-bubble h4 {
            font-size: 0.95rem;
            color: #6366f1;
        }

        .message-bubble ul,
        .message-bubble ol {
            margin: 8px 0;
            padding-left: 22px;
        }

        .message-bubble li {
            margin: 4px 0;
            line-height: 1.5;
        }

        .message-bubble p {
            margin: 8px 0;
            line-height: 1.6;
        }

        .action-confirm-box {
            margin-top: 14px;
            padding: 12px 16px;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-confirm-roadmap {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.25s ease;
        }

        .btn-confirm-roadmap:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }

        /* Timestamp */
        .message-time {
            font-size: 12px;
            color: var(--text-secondary);
            padding: 0 4px;
        }

        /* Project Link Styling */
        .project-link {
            display: inline-block;
            margin-top: 12px;
            padding: 8px 16px;
            background: var(--accent-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .project-link:hover {
            background: var(--text-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(126, 60, 169, 0.2);
        }

        /* ===== TYPING INDICATOR ===== */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 16px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            max-width: 120px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--text-secondary);
            animation: typingBounce 1.4s infinite;
        }

        .typing-dot:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        /* ===== LOADING SPINNER ===== */
        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        /* ===== CHAT INPUT AREA ===== */
        .chat-input-area {
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            padding: 20px 24px;
        }

        .input-wrapper {
            display: flex;
            gap: 12px;
            align-items: center;
            background: var(--bg-secondary);
            border-radius: 25px;
            padding: 4px 4px 4px 20px;
            border: 1px solid var(--border-color);
            margin-bottom: 16px;
            transition: border-color 0.3s ease;
        }

        .input-wrapper:focus-within {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px var(--shadow);
        }

        .chat-input {
            flex: 1;
            background: none;
            border: none;
            padding: 14px 0;
            color: var(--text-primary);
            font-size: 15px;
            outline: none;
            font-family: inherit;
        }

        .chat-input::placeholder {
            color: var(--text-secondary);
        }

        .send-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            flex-shrink: 0;
        }

        .send-btn:hover:not(:disabled) {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(126, 60, 169, 0.3);
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .send-icon {
            width: 20px;
            height: 20px;
        }

        /* ===== QUICK SUGGESTIONS ===== */
        .quick-suggestions {
            margin-top: 16px;
        }

        .suggestion-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .suggestion-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            border: none;
        }

        .suggestion-btn:hover {
            background: linear-gradient(135deg, var(--accent-color), var(--text-primary));
            color: white;
            transform: translateY(-2px);
        }

        .suggestion-btn svg {
            width: 16px;
            height: 16px;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes messageSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bubbleAppear {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes typingBounce {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-6px);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 768px) {
            .chatbot-container {
                margin: 0;
                border-radius: 0;
                height: calc(100vh - 60px);
            }

            .chat-header {
                padding: 16px;
            }

            .header-info h2 {
                font-size: 18px;
            }

            .header-info p {
                font-size: 13px;
            }

            .new-chat-btn span {
                display: none;
            }

            .new-chat-btn {
                padding: 10px;
            }

            .chat-messages {
                padding: 16px;
                gap: 16px;
            }

            .message-container {
                max-width: 95%;
            }

            .message-bubble {
                padding: 12px 16px;
                font-size: 14px;
            }

            .chat-input-area {
                padding: 16px;
            }

            .input-wrapper {
                margin-bottom: 12px;
            }

            .suggestion-buttons {
                gap: 8px;
            }

            .suggestion-btn {
                padding: 8px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .header-info h2 {
                font-size: 16px;
            }

            .message-bubble {
                padding: 10px 14px;
            }

            .suggestion-buttons {
                justify-content: center;
            }

            .suggestion-btn {
                flex: 1;
                min-width: 120px;
                justify-content: center;
            }
        }

        /* ===== SCROLLBAR STYLING ===== */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: var(--accent-color);
        }
    </style>

    <script>
        // SINGLE VERSION - Tidak ada konflik dengan app.js
        (function() {
            'use strict';

            // Cegah double initialization
            if (window.chatbotInitialized) {
                console.log('Chatbot already initialized');
                return;
            }
            window.chatbotInitialized = true;

            console.log('Initializing NexaConsult Chatbot');

            // ===== ELEMENT REFERENCES =====
            const chatMessages = document.getElementById('chatMessages');
            const chatInput = document.getElementById('chatInput');
            const sendBtn = document.getElementById('sendBtn');
            const newChatBtn = document.getElementById('newChatBtn');

            // ===== STATE =====
            let isProcessing = false;
            let typingIndicator = null;

            // ===== UTILITY FUNCTIONS =====
            function getCurrentTime() {
                const now = new Date();
                return now.getHours().toString().padStart(2, '0') + ':' +
                    now.getMinutes().toString().padStart(2, '0');
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function scrollToBottom() {
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }

            // ===== MESSAGE RENDERING =====
            function addUserMessage(text) {
                if (!chatMessages) return;

                const userMessageHTML = `
                <div class="message-container user">
                    <div class="message-content">
                        <div class="message-bubble">${escapeHtml(text)}</div>
                        <div class="message-time">${getCurrentTime()}</div>
                    </div>
                    <div class="message-avatar">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4" stroke="white" stroke-width="2" fill="none"/>
                            <path d="M5 21v-2a7 7 0 0114 0v2" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                </div>`;
                chatMessages.insertAdjacentHTML('beforeend', userMessageHTML);
                scrollToBottom();
            }

            function formatMarkdown(rawText) {
                if (!rawText) return "";
                let text = rawText
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;");

                // Headings
                text = text.replace(/^### (.*$)/gim, '<h4>$1</h4>');
                text = text.replace(/^## (.*$)/gim, '<h3>$1</h3>');
                text = text.replace(/^# (.*$)/gim, '<h2>$1</h2>');

                // Bold & Italic
                text = text.replace(/\*\*\*(.*?)\*\*\*/gim, '<strong><em>$1</em></strong>');
                text = text.replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>');
                text = text.replace(/\*(.*?)\*/gim, '<em>$1</em>');

                // Lists
                text = text.replace(/^\s*[\-\*]\s+(.*)$/gim, '<li>$1</li>');
                text = text.replace(/(<li>.*<\/li>)/gim, '<ul>$1</ul>');
                text = text.replace(/<\/ul>\s*<ul>/gim, '');

                // Line breaks
                text = text.replace(/\n\n+/g, '<br><br>');
                text = text.replace(/\n/g, '<br>');

                return text;
            }

            function addAiMessage(text, projectId = null, needsConfirmation = false) {
                if (!chatMessages) return;

                const formattedText = formatMarkdown(text);
                
                const isWaitingConfirm = needsConfirmation || 
                    text.toLowerCase().includes('balas dengan: **ya**') || 
                    text.toLowerCase().includes('balas dengan: ya');

                let actionHtml = '';
                if (isWaitingConfirm && !projectId) {
                    actionHtml = `
                    <div class="action-confirm-box">
                        <div>
                            <strong>💡 Tertarik dengan rencana ini?</strong>
                            <div style="font-size: 13px; opacity: 0.85;">Buat project roadmap otomatis ke dashboard Anda dengan 1-klik:</div>
                        </div>
                        <button type="button" class="btn-confirm-roadmap" onclick="window.NexaChatbot.confirmCreateRoadmap()">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>🚀 Buat Roadmap Project Sekarang</span>
                        </button>
                    </div>`;
                }

                if (projectId) {
                    actionHtml += `
                    <div class="action-confirm-box" style="background: rgba(99, 102, 241, 0.1); border-color: rgba(99, 102, 241, 0.3);">
                        <div>
                            <strong style="color: #4f46e5;">🎉 Roadmap Berhasil Dibuat!</strong>
                            <div style="font-size: 13px;">Kelola milestone dan eksekusi tugas UMKM Anda di Project Manager.</div>
                        </div>
                        <a href="/project/${projectId}" class="btn-confirm-roadmap" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                            <span>Buka Roadmap Proyek &rarr;</span>
                        </a>
                    </div>`;
                }

                const aiMessageHTML = `
                <div class="message-container ai">
                    <div class="message-avatar">
                        <svg viewBox="0 0 32 32">
                            <path d="M13 8H19C20.6569 8 22 9.34315 22 11V14H26C27.6569 14 29 15.3431 29 17V23C29 24.6569 27.6569 26 26 26H6C4.34315 26 3 24.6569 3 23V17C3 15.3431 4.34315 14 6 14H10V11C10 9.34315 11.3431 8 13 8Z" 
                                  stroke="var(--accent-color)" stroke-width="2" fill="none"/>
                            <circle cx="16" cy="20" r="2" fill="var(--accent-color)"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <div>${formattedText}</div>
                            ${actionHtml}
                        </div>
                        <div class="message-time">${getCurrentTime()}</div>
                    </div>
                </div>`;
                chatMessages.insertAdjacentHTML('beforeend', aiMessageHTML);
                scrollToBottom();
            }

            function showTypingIndicator() {
                if (!chatMessages || typingIndicator) return;

                const typingHTML = `
                <div class="message-container ai" id="typingIndicator">
                    <div class="message-avatar">
                        <svg viewBox="0 0 32 32">
                            <path d="M13 8H19C20.6569 8 22 9.34315 22 11V14H26C27.6569 14 29 15.3431 29 17V23C29 24.6569 27.6569 26 26 26H6C4.34315 26 3 24.6569 3 23V17C3 15.3431 4.34315 14 6 14H10V11C10 9.34315 11.3431 8 13 8Z" 
                                  stroke="var(--accent-color)" stroke-width="2" fill="none"/>
                            <circle cx="16" cy="20" r="2" fill="var(--accent-color)"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        <div class="typing-indicator">
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                        </div>
                    </div>
                </div>`;
                chatMessages.insertAdjacentHTML('beforeend', typingHTML);
                typingIndicator = document.getElementById('typingIndicator');
                scrollToBottom();
            }

            function hideTypingIndicator() {
                if (typingIndicator && typingIndicator.parentNode) {
                    typingIndicator.remove();
                }
                typingIndicator = null;
            }

            // ===== LOCALSTORAGE MANAGEMENT =====
            function getAuthHeaders() {
                const token = localStorage.getItem("token");
                if (!token) return {};

                return {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                };
            }

            function loadChatHistory() {
                try {
                    const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
                    if (history.length === 0) {
                        showWelcomeMessage();
                    } else {
                        history.forEach(msg => {
                            if (msg.sender === "user") {
                                addUserMessage(msg.text);
                            } else if (msg.sender === "bot") {
                                addAiMessage(msg.text, msg.project_id);
                            }
                        });
                    }
                } catch (e) {
                    console.error("Error loading chat history:", e);
                    showWelcomeMessage();
                }
            }

            function saveMessage(text, sender = "bot", project_id = null) {
                try {
                    const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
                    history.push({
                        text,
                        sender,
                        project_id
                    });
                    localStorage.setItem("chat_history", JSON.stringify(history));
                } catch (e) {
                    console.error("Error saving message:", e);
                }
            }

            function clearChatHistory() {
                localStorage.removeItem("chat_history");
                localStorage.removeItem("last_context");
                if (chatMessages) {
                    chatMessages.innerHTML = '';
                }
                showWelcomeMessage();
            }

            // ===== API COMMUNICATION =====
            async function sendToAI(message) {
                if (isProcessing) return;

                isProcessing = true;
                showTypingIndicator();

                try {
                    // Save user message to history
                    saveMessage(message, "user");

                    // Get context from localStorage
                    const context = localStorage.getItem("last_context") || null;

                    // Prepare request
                    const response = await fetch("/api/ai/consult", {
                        method: "POST",
                        headers: getAuthHeaders(),
                        body: JSON.stringify({
                            prompt: message,
                            context: context
                        }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    const data = await response.json();

                    // Save context if provided
                    if (data.status === "consult" && data.context) {
                        localStorage.setItem("last_context", data.context);
                    }

                    // Get response text and project ID
                    const reply = (data.status === 'created' ? (data.message + "\n\n" + (data.project?.description || '')) : (data.message || data.project?.description || "Tidak ada respon AI."));
                    const projectId = data.project?._id?.$oid || data.project?._id || data.project?.id || null;
                    const needsConfirm = data.needs_confirmation || false;

                    // Hide typing indicator
                    hideTypingIndicator();

                    // Show AI response
                    addAiMessage(reply, projectId, needsConfirm);

                    // Save AI response to history
                    saveMessage(reply, "bot", projectId);

                } catch (error) {
                    console.error("Error sending to AI:", error);
                    hideTypingIndicator();
                    addAiMessage("Maaf, terjadi kesalahan. Silakan coba lagi.");
                } finally {
                    isProcessing = false;
                }
            }

            // ===== UI EVENT HANDLERS =====
            function handleSendMessage() {
                if (!chatInput || !sendBtn || isProcessing) return;

                const message = chatInput.value.trim();
                if (!message) return;

                // Clear input
                chatInput.value = "";

                // Show user message
                addUserMessage(message);

                // Disable input and button during processing
                chatInput.disabled = true;
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<div class="loading-spinner"></div>';

                // Send to AI
                sendToAI(message).finally(() => {
                    // Re-enable input and button
                    chatInput.disabled = false;
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = `<svg class="send-icon" viewBox="0 0 24 24">
                    <path d="M22 2L11 13M22 2L15 22L11 13M11 13L2 9L22 2" 
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>`;

                    // Focus back to input
                    chatInput.focus();
                });
            }

            function handleSuggestionClick(event) {
                if (!chatInput) return;

                const prompt = event.currentTarget.getAttribute('data-prompt');
                chatInput.value = prompt;
                chatInput.focus();
            }

            // ===== INITIALIZATION =====
            function showWelcomeMessage() {
                if (!chatMessages) return;

                const welcomeHTML = `
                <div class="message-container ai">
                    <div class="message-avatar">
                        <svg viewBox="0 0 32 32">
                            <path d="M13 8H19C20.6569 8 22 9.34315 22 11V14H26C27.6569 14 29 15.3431 29 17V23C29 24.6569 27.6569 26 26 26H6C4.34315 26 3 24.6569 3 23V17C3 15.3431 4.34315 14 6 14H10V11C10 9.34315 11.3431 8 13 8Z" 
                                  stroke="var(--accent-color)" stroke-width="2" fill="none"/>
                            <circle cx="16" cy="20" r="2" fill="var(--accent-color)"/>
                        </svg>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <strong>Halo! Saya AI NexaConsult</strong>
                            <p>Saya dapat membantu Anda mengembangkan ide bisnis UMKM. Tanyakan tentang:</p>
                            <ul style="margin: 8px 0; padding-left: 20px;">
                                <li>Ide usaha baru</li>
                                <li>Strategi pemasaran</li>
                                <li>Analisis pasar</li>
                                <li>Rencana pengembangan</li>
                            </ul>
                            <small>Contoh: "Saya ingin membuka usaha makanan ringan"</small>
                        </div>
                        <div class="message-time">${getCurrentTime()}</div>
                    </div>
                </div>`;
                chatMessages.innerHTML = welcomeHTML;

                // Save welcome message to history if empty
                try {
                    const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
                    if (history.length === 0) {
                        saveMessage(
                            "Halo! Saya AI NexaConsult. Saya dapat membantu Anda mengembangkan ide bisnis UMKM...",
                            "bot");
                    }
                } catch (e) {
                    console.error("Error saving welcome message:", e);
                }
            }

            function setupEventListeners() {
                // Send button
                if (sendBtn) {
                    sendBtn.addEventListener('click', handleSendMessage);
                }

                // Enter key in input
                if (chatInput) {
                    chatInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' && !e.shiftKey && !isProcessing) {
                            e.preventDefault();
                            handleSendMessage();
                        }
                    });
                }

                // New chat button
                if (newChatBtn) {
                    newChatBtn.addEventListener('click', () => {
                        if (confirm('Mulai chat baru? Riwayat chat akan dihapus.')) {
                            clearChatHistory();
                        }
                    });
                }

                // Quick suggestion buttons
                const suggestionBtns = document.querySelectorAll('.suggestion-btn');
                suggestionBtns.forEach(btn => {
                    btn.addEventListener('click', handleSuggestionClick);
                });

                // Auto-scroll when new messages are added
                if (chatMessages) {
                    const observer = new MutationObserver(scrollToBottom);
                    observer.observe(chatMessages, {
                        childList: true,
                        subtree: true
                    });
                }
            }

            // ===== MAIN INITIALIZATION =====
            function initialize() {
                console.log('Setting up chatbot...');

                // Load existing chat history
                loadChatHistory();

                // Setup event listeners
                setupEventListeners();

                // Focus on input
                if (chatInput) {
                    setTimeout(() => chatInput.focus(), 100);
                }

                console.log('Chatbot setup complete');
            }

            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initialize);
            } else {
                initialize();
            }

            // Export functions if needed
            window.NexaChatbot = {
                sendMessage: handleSendMessage,
                clearHistory: clearChatHistory,
                addUserMessage: addUserMessage,
                addAiMessage: addAiMessage,
                confirmCreateRoadmap: function() {
                    if (isProcessing) return;
                    addUserMessage("Ya, buatkan roadmap proyek bisnis ini.");
                    sendToAI("ya");
                }
            };

        })();
    </script>
@endsection
