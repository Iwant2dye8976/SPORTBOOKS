// Toggle
document.getElementById('chatbot-button').addEventListener('click', function () {
    const chatbox = document.getElementById('chatbot-box');
    chatbox.classList.toggle('hidden');
});

document.getElementById('chatbot-close').addEventListener('click', function () {
    document.getElementById('chatbot-box').classList.add('hidden');
});

document.getElementById('chatbot-input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        sendMessage();
        // simulateBotResponse(this.value);
    }
});

async function sendMessage() {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();

    if (!message) return;

    addMessage(message, 'user');
    input.value = '';

    // Disable send button
    const sendBtn = document.getElementById('chatbot-send');
    sendBtn.disabled = true;
    showTypingIndicator();

    try {
        const response = await fetch('/gemini/index/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                message: message
            })
        });

        const data = await response.json();
        removeTypingIndicator();
        if (data.success) {
            addMessage(data.response, 'bot', data.books);
        } else {
            addMessage('Xin lỗi, đã có lỗi xảy ra. Vui lòng thử lại sau.', 'bot');
        }

    } catch (error) {
        console.error('Error:', error);
        removeTypingIndicator();
        addMessage('Xin lỗi, không thể kết nối đến máy chủ. Vui lòng thử lại sau.', 'bot');
    } finally {
        sendBtn.disabled = false;
    }
}

function sendMessage2() {
    const input = document.getElementById('chatbot-input');
    const message = input.value.trim();

    if (!message) return;

    addMessage(message, 'user');
    input.value = '';

    const sendBtn = document.getElementById('chatbot-send');
    sendBtn.disabled = true;
    showTypingIndicator();


    fetch('/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({ message: text })
    })
        .then(res => res.json())
        .then(data => handleResponse(data))
        .catch(err => appendMessage(err, 'bot'));
}

function addMessage(text, type, books = null) {
    const messagesContainer = document.getElementById('chatbot-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;

    let content = `<div class="message-content">${text}</div>`;

    if (books && books.length > 0) {
        content = `<div class="message-content">
                ${text}
                ${books.map(book => `
                    <div class="book-suggestion">
                        <a href="${book.url}" target="_blank">
                            📚 ${book.title}
                        </a>
                        ${book.author ? `<br><small class="text-muted">Tác giả: ${book.author}</small>` : ''}
                    </div>
                `).join('')}
            </div>`;
    }

    messageDiv.innerHTML = content;
    messagesContainer.appendChild(messageDiv);

    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function showTypingIndicator() {
    const messagesContainer = document.getElementById('chatbot-messages');
    const typingDiv = document.createElement('div');
    typingDiv.className = 'message typing';
    typingDiv.id = 'typing-indicator';
    typingDiv.innerHTML = `
            <div class="message-content">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        `;
    messagesContainer.appendChild(typingDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function removeTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

// demo
function simulateBotResponse(userMessage) {
    setTimeout(() => {
        removeTypingIndicator();

        const responses = {
            'sách gì hay': 'Tôi gợi ý một số đầu sách hay: "Đắc Nhân Tâm", "Nhà Giả Kim", "Sapiens: Lược sử loài người". Bạn muốn biết thêm về cuốn nào?',
            'giá': 'Giá sách của chúng tôi rất cạnh tranh, từ 50.000đ - 500.000đ tùy loại sách. Bạn đang tìm sách nào?',
            'giao hàng': 'Chúng tôi có 4 hình thức giao hàng: Tiết kiệm (15k), Tiêu chuẩn (30k), Nhanh (50k), và Hỏa tốc (100k). Miễn phí ship cho đơn trên 500k!',
        };

        let botResponse =
            'Cảm ơn bạn đã hỏi! Tôi có thể giúp bạn tìm sách, tư vấn về giá, và thông tin giao hàng. Bạn cần hỗ trợ gì?';

        for (let key in responses) {
            if (userMessage.toLowerCase().includes(key)) {
                botResponse = responses[key];
                break;
            }
        }

        addMessage(botResponse, 'bot');
    }, 1500);
}
