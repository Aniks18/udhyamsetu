<?php
// Include the connection file
include 'conn.php';

// Function to check if a username exists
function usernameExists($conn, $username) {
    $stmt = $conn->prepare("SELECT * FROM users_msme WHERE username = ?");
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
        $emailid = $_POST['emailid'];
        $industry_type = $_POST['industry_type'];
        $location = $_POST['location'];
        $revenue_per_year = $_POST['revenue_per_year'];
        $employee = $_POST['employee'];
        $investment_require = $_POST['investment_require'];
        $investment_type = $_POST['investment_type'];
        $description = $_POST['description'];
        $logo = $_POST['logo'];
        $contact = $_POST['contact'];

        // Insert query
        $sql = "INSERT INTO users_msme (username, password, emailid, industry_type, location, revenue_per_year, employee, investment_require, investment_type, description, logo, contact) 
                VALUES ('$username', '$password', '$emailid', '$industry_type', '$location', '$revenue_per_year', '$employee', '$investment_require', '$investment_type', '$description', '$logo', '$contact')";

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
    <title>Insert MSME Data</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Insert MSME Data</h2>
        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType; ?> alert-dismissible fade show" role="alert">
                <?= $message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="insert_msme.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="emailid">Email ID:</label>
                <input type="email" class="form-control" id="emailid" name="emailid" required>
            </div>

            <div class="form-group">
                <label for="industry_type">Industry Type:</label>
                <input type="text" class="form-control" id="industry_type" name="industry_type" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <div class="form-group">
                <label for="revenue_per_year">Revenue Per Year:</label>
                <input type="number" class="form-control" id="revenue_per_year" name="revenue_per_year" required>
            </div>

            <div class="form-group">
                <label for="employee">Employee Count:</label>
                <input type="number" class="form-control" id="employee" name="employee" required>
            </div>

            <div class="form-group">
                <label for="investment_require">Investment Requirement:</label>
                <input type="text" class="form-control" id="investment_require" name="investment_require" required>
            </div>

            <div class="form-group">
                <label for="investment_type">Investment Type:</label>
                <input type="text" class="form-control" id="investment_type" name="investment_type" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="logo">Logo URL:</label>
                <input type="text" class="form-control" id="logo" name="logo">
            </div>

            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
