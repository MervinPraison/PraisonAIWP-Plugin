jQuery(document).ready(function($) {
    const chatHistory = $('.praisonai-chat-history');
    const chatForm = $('.praisonai-chat-form');
    const chatInput = $('#praisonai-chat-input');
    const chatSubmit = $('#praisonai-chat-submit');

    chatForm.on('submit', function(e) {
        e.preventDefault();

        const message = chatInput.val().trim();
        if (message === '') {
            return;
        }

        // Display user message
        appendMessage(message, 'user');
        chatInput.val('');
        
        // Show a temporary 'thinking' message
        appendMessage('...', 'assistant', true);

        // Send message to the backend
        $.ajax({
            url: praisonai_chat_params.ajax_url,
            type: 'POST',
            data: {
                action: 'praisonai_chat',
                message: message,
                nonce: praisonai_chat_params.nonce
            },
            success: function(response) {
                removeTypingIndicator();
                if (response.success) {
                    appendMessage(response.data, 'assistant');
                } else {
                    appendMessage('Error: ' + response.data, 'assistant');
                }
            },
            error: function() {
                removeTypingIndicator();
                appendMessage('An error occurred. Please try again.', 'assistant');
            }
        });
    });

    function appendMessage(content, sender, isTyping = false) {
        const messageClass = isTyping ? 'assistant typing-indicator' : sender;
        const messageHtml = `
            <div class="praisonai-chat-message ${messageClass}">
                <div class="message-bubble">${escapeHtml(content)}</div>
            </div>
        `;
        chatHistory.append(messageHtml);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        chatHistory.find('.typing-indicator').remove();
    }

    function scrollToBottom() {
        chatHistory.scrollTop(chatHistory[0].scrollHeight);
    }

    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
});
