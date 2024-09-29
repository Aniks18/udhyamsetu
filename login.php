<?php
// Include the connection file
include 'conn.php';

// Initialize message variables
$message = "";
$messageType = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $userType = $_POST['user_type'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Set table name based on user type
    $table = '';
    if ($userType == 'msme') {
        $table = 'users_msme';
    } elseif ($userType == 'entrepreneur') {
        $table = 'users_entrepreneur';
    } elseif ($userType == 'investor') {
        $table = 'user_investor';
    } else {
        $message = "Invalid user type.";
        $messageType = "danger";
    }

    // Proceed if a valid table is set
    if ($table) {
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if username exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Start session and set user details
                session_start();
                $_SESSION['user_id'] = $row['msme_id'] ?? $row['entrepreneur_id'] ?? $row['investor_id'];
                $_SESSION['username'] = $username;
                $_SESSION['user_type'] = $userType; // Add this line to store user_type in session

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Incorrect password.";
                $messageType = "danger";
            }
        } else {
            $message = "Username does not exist.";
            $messageType = "danger";
        }

        // Close the connection
        $stmt->close();
    }
    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType; ?> alert-dismissible fade show" role="alert">
                <?= $message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="user_type">Select User Type:</label>
                <select class="form-control" id="user_type" name="user_type" required>
                    <option value="">Select User Type</option>
                    <option value="msme">MSME</option>
                    <option value="entrepreneur">Entrepreneur</option>
                    <option value="investor">Investor</option>
                </select>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
