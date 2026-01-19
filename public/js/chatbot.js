document.getElementById('chatbot-button').onclick = () => {
    document.getElementById('chatbot-box').toggleAttribute('hidden');
};

document.getElementById('chatbot-close').onclick = () => {
    document.getElementById('chatbot-box').setAttribute('hidden', '');
};

const input = document.getElementById('chatbot-input');
const messages = document.getElementById('chatbot-messages');

document.getElementById('chatbot-send').onclick = sendMessage;
input.addEventListener('keypress', e => {
    if (e.key === 'Enter') sendMessage();
});

function sendMessage() {
    const text = input.value.trim();
    if (!text) return;

    appendMessage(text, 'user');
    input.value = '';

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

function appendMessage(content, type) {
    let el;

    // TEXT MESSAGE
    if (typeof content === 'string') {
        el = document.createElement('div');
        el.className = `message ${type}`;
        el.innerText = content;
    }

    // BOOK CARD
    else if (typeof content === 'object' && content.title) {
        el = document.createElement('a');
        el.className = 'chat-book-card';
        el.href = `/books/detail/${content.id}`;
        el.target = '_blank';

        el.innerHTML = `
            <div class="chat-book-image">📘</div>
            <div class="chat-book-info">
                <div class="chat-book-title">${content.title}</div>
                <div class="chat-book-link">Xem chi tiết</div>
            </div>
        `;
    }

    messages.appendChild(el);
    messages.scrollTop = messages.scrollHeight;
}


function handleResponse(data) {
    if (data.type == 'text') {
        appendMessage(data.content, 'bot');
    }

    if (data.type == 'books') {
        data.content.forEach(book => {
            appendMessage(book, 'bot');
        });
    }
}
