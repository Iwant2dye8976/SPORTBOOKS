<div id="chatbot-container">
    <div id="chatbot-button">
        💬
    </div>

    <div id="chatbot-box" class="hidden">
        <div class="chatbot-header">
            <span>
                <i class="fa-solid fa-robot me-2"></i>
                Chatbot hỗ trợ
            </span>
            <button id="chatbot-close">✖</button>
        </div>

        <div id="chatbot-messages">
            <div class="message bot">
                <div class="message-content">
                    <strong>Xin chào 👋</strong>
                    <p class="mb-0">Tôi có thể giúp bạn tìm kiếm và gợi ý sách. Hãy hỏi tôi bất kỳ điều gì!</p>
                </div>
            </div>
        </div>

        {{-- <div id="chatbot-instant-messages" class="slide-in">
            <h5 id="instant-message-title">Gợi ý thể loại:</h5>
            <div id="chatbot-instant-message-buttons">
            </div>
        </div> --}}

        <details id="chatbot-instant-messages" class="slide-in collapsible-details" open>
            <summary class="collapsible-summary">
                <h5 id="instant-message-title">Gợi ý thể loại:</h5>
                <svg class="toggle-icon" width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                </svg>
            </summary>
            <div id="chatbot-instant-message-buttons" class="details-content">
            </div>
        </details>

        <div class="chatbot-input">
            <input type="text" id="chatbot-input" placeholder="Nhập câu hỏi của bạn..." />
            <button id="chatbot-send" onclick="sendMessage();">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
