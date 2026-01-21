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

        <div class="chatbot-input">
            <input type="text" id="chatbot-input" placeholder="Nhập câu hỏi của bạn..." />
            <button id="chatbot-send" onclick="sendMessage();">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>
