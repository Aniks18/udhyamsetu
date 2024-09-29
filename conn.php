<?php
// Database connection variables
$servername = "localhost";  // Assuming you're using localhost
$username = "root";         // Default MySQL username
$password = "";             // Default MySQL password is usually empty
$dbname = "manipal";        // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>
