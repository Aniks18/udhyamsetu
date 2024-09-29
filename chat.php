<?php
session_start();
include 'conn.php'; // Your database connection

// Fetch messages for the current user
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type']; // Store user type in session when they log in

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle sending messages
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insert message into the database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, message_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $receiver_id, $message, $user_type);
    $stmt->execute();
    $stmt->close();
}

// Fetch messages
$query = "SELECT * FROM messages WHERE (sender_id = ? OR receiver_id = ?) ORDER BY timestamp";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Chat</h2>
        <div id="chatBox" style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
            <?php foreach ($messages as $msg): ?>
                <div class="<?= ($msg['sender_id'] == $user_id) ? 'text-right' : 'text-left' ?>">
                    <strong><?= ($msg['sender_id'] == $user_id) ? 'You' : $msg['sender_id'] ?>:</strong>
                    <p><?= htmlspecialchars($msg['message']) ?></p>
                    <small><?= $msg['timestamp'] ?></small>
                </div>
            <?php endforeach; ?>
        </div>

        <form action="chat.php" method="POST" class="mt-3">
            <input type="hidden" name="receiver_id" value="RECEIVER_ID"> <!-- Change this to the actual receiver's ID -->
            <div class="input-group">
                <input type="text" class="form-control" name="message" placeholder="Type your message..." required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
