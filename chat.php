<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            max-height: 400px;
            background-color: #3d274b;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .chat-header {
            background-color: #4CAF50;
            padding: 10px;
            color: white;
            text-align: center;
            font-size: 18px;
            border-bottom: 1px solid #ddd;
        }
        .chat-body {
            padding: 10px;
            overflow-y: auto;
            flex-grow: 1;
        }
        .chat-input-container {
            display: flex;
            border-top: 1px solid #ddd;
        }
        .chat-input {
            flex-grow: 1;
            padding: 10px;
            border: none;
            outline: none;
        }
        .chat-submit {
            background-color: #4CAF50;
            border: none;
            padding: 10px;
            color: white;
            cursor: pointer;
            outline: none;
        }
        .chat-submit:hover {
            background-color: #45a049;
        }
        .message {
            margin: 5px 0;
            padding: 10px;
            border-radius: 10px;
        }
        .message.user {
            background-color: a1c79e;
            align-self: flex-end;
        }
        .message.bot {
            background-color: #000000;
            align-self: flex-start;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header">Chat with Us</div>
    <div class="chat-body" id="chat-body">
        <!-- this is where my messages are -->
    </div>
    <div class="chat-input-container">
        <input type="text" id="chat-input" class="chat-input" placeholder="Type your message...">
        <button id="chat-submit" class="chat-submit">Send</button>
    </div>
</div>

<script>
    const chatInput = document.getElementById('chat-input');
    const chatBody = document.getElementById('chat-body');
    const chatSubmit = document.getElementById('chat-submit');

    chatSubmit.addEventListener('click', async () => {
        const userMessage = chatInput.value.trim();
        if (userMessage === '') return;

        // Shows the message from the user
        displayMessage(userMessage, 'user');

        // after you type it clears it
        chatInput.value = '';

        // Sends the message to the backend
        const botResponse = await getBotResponse(userMessage);

        // Displays chats response
        displayMessage(botResponse, 'bot');
    });

    function displayMessage(message, sender) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', sender);
        messageElement.textContent = message;
        chatBody.appendChild(messageElement);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    async function getBotResponse(message) {
        try {
            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                const data = await response.json();
                return data.response || data.error || 'Sorry, something went wrong.';
            } else {
                const errorText = await response.text();  //debugg stuff
                console.error('Unexpected response:', errorText);
                return 'Server returned an unexpected response. Please try again later.';
            }
        } catch (error) {
            console.error('Error:', error);
            return 'Sorry, there was an error. Please try again.';
        }
    }
</script>

</body>
</html>
