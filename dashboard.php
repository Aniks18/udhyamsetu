<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include the navbar
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Udhayam Setu</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Chat Popup Styles */
        .chat-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            overflow: hidden;
        }
        .chat-container {
            position: relative;
            width: 100%;
            height: 100%;
            padding: 20px;
            box-sizing: border-box;
            background-color: #fff;
        }
        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
        }
        .close-chat {
            cursor: pointer;
            font-size: 20px;
        }
        .chat-messages {
            height: calc(100% - 100px);
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #ccc;
            margin-top: 10px;
        }
        .chat-input {
            display: flex;
            margin-top: 10px;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .chat-input button {
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main content -->
        <div class="main-content">
            <!-- Dynamic content section -->
            <div id="content">
                <?php
                // Simple PHP routing
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];

                    switch ($page) {
                        case 'dashboard':
                            echo "<h1>Welcome to the Dashboard</h1>
                                  <p>Dashboard overview and information here.</p>";
                            break;
                        case 'profile':
                            // Profile code...
                            break;
                        case 'settings':
                            // Settings code...
                            break;
                        case 'Connect':
                            // Settings code...
                            break;
                        case 'reports':
                            // Reports code...
                            break;
                        case 'logout':
                            session_destroy(); // End the session
                            header("Location: login.php"); // Redirect to login
                            exit();
                            break;
                        default:
                            echo "<h1>Welcome to the Dashboard</h1>
                                  <p>Dashboard overview and information here.</p>";
                    }
                } else {
                    echo "<h1>Welcome to the Dashboard</h1>
                          <p>Dashboard overview and information here.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Connect Button -->
    <div>
        <button id="connectButton">Connect</button>
    </div>

    <!-- Chat Popup -->
    <div id="chatPopup" class="chat-popup">
        <div class="chat-container">
            <div class="chat-header">
                <h2>Chat</h2>
                <span class="close-chat" onclick="closeChat()">&times;</span>
            </div>
            <div class="chat-messages" id="chatMessages">
                <!-- Chat messages will be displayed here -->
            </div>
            <div class="chat-input">
                <input type="text" id="messageInput" placeholder="Type your message...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

    <script src="dashboard.js"></script>
    <script>
        // Function to open the chat popup
        document.getElementById('connectButton').onclick = function() {
            document.getElementById('chatPopup').style.display = 'block';
        };

        // Function to close the chat popup
        function closeChat() {
            document.getElementById('chatPopup').style.display = 'none';
        }

        // Function to send a message
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value;

            if (message) {
                const messageContainer = document.createElement('div');
                messageContainer.textContent = "You: " + message;
                document.getElementById('chatMessages').appendChild(messageContainer);
                input.value = ''; // Clear the input
            }
        }
    </script>
</body>
</html>
