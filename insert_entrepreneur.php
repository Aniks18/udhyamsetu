<?php
// Include the connection file
include 'conn.php';

// Function to check if a username exists
function usernameExists($conn, $username) {
    $stmt = $conn->prepare("SELECT * FROM users_entrepreneur WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0; // Return true if username exists
}

// Initialize message variables
$message = "";
$messageType = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $username = $_POST['username'];
    
    // Check if username already exists
    if (usernameExists($conn, $username)) {
        $message = "User already exists. Please choose a different username.";
        $messageType = "warning"; // Bootstrap warning message
    } else {
        // Continue with data insertion if username doesn't exist
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $msme_belong_to = $_POST['msme_belong_to'];
        $expertise = $_POST['expertise'];
        $bio = $_POST['bio'];
        $social_link = $_POST['social_link'];
        $experience = $_POST['experience'];
        $location = $_POST['location'];

        // Insert query
        $sql = "INSERT INTO users_entrepreneur (username, password, email, contact, msme_belong_to, expertise, bio, social_link, experience, location) 
                VALUES ('$username', '$password', '$email', '$contact', '$msme_belong_to', '$expertise', '$bio', '$social_link', '$experience', '$location')";

        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully!";
            $messageType = "success"; // Bootstrap success message
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $messageType = "danger"; // Bootstrap danger message
        }
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
    <title>Insert Entrepreneur Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Insert Entrepreneur Data</h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType; ?> alert-dismissible fade show" role="alert">
                <?= $message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="insert_entrepreneur.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>

            <div class="form-group">
                <label for="msme_belong_to">MSME Belong To:</label>
                <input type="text" class="form-control" id="msme_belong_to" name="msme_belong_to" placeholder="Optional">
            </div>

            <div class="form-group">
                <label for="expertise">Expertise:</label>
                <input type="text" class="form-control" id="expertise" name="expertise" required>
            </div>

            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Optional"></textarea>
            </div>

            <div class="form-group">
                <label for="social_link">Social Link:</label>
                <input type="text" class="form-control" id="social_link" name="social_link" placeholder="Optional">
            </div>

            <div class="form-group">
                <label for="experience">Experience:</label>
                <input type="text" class="form-control" id="experience" name="experience" placeholder="Optional">
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
