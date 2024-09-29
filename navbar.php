<?php
// Include the connection file
include 'conn.php';

// Get user details from the session
$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// Fetch user details based on user type
$userDetails = null;
if ($userType === 'msme') {
    $stmt = $conn->prepare("SELECT * FROM users_msme WHERE msme_id = ?");
} elseif ($userType === 'entrepreneur') {
    $stmt = $conn->prepare("SELECT * FROM users_entrepreneur WHERE entrepreneur_id = ?");
} elseif ($userType === 'investor') {
    $stmt = $conn->prepare("SELECT * FROM user_investor WHERE investor_id = ?");
}

if (isset($stmt)) {
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<nav class="navbar">
    <div class="logo">Udhayam Setu</div>
    <div class="profile" onclick="openModal()">
        <i class="fas fa-user-circle"></i>
    </div>
    <div class="hamburger-menu" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h2>Navigation</h2>
    <ul>
    <li><a href="?page=dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
    <li><a href="?page=profile"><i class="fas fa-user"></i> Profile</a></li>
    <li><a href="?page=settings"><i class="fas fa-cog"></i> Settings</a></li>
    <li><a href="?page=connect"><i class="fas fa-comments"></i> Connect</a></li>
    <li><a href="?page=reports"><i class="fas fa-chart-bar"></i> Reports</a></li>
    <li><a href="?page=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>

</div>

<!-- Modal for profile info -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="profile-info">
            <img src="https://via.placeholder.com/100" alt="User Profile" class="profile-image">
            <h2><?php echo htmlspecialchars($userDetails['username']); ?></h2>
        </div>
        <div class="profile-details">
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($userId); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userDetails['email']); ?></p>
            <p><strong>Type:</strong> <?php echo htmlspecialchars(ucfirst($userType)); ?></p>
            <p><strong>Member Since:</strong> January 2024</p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($userDetails['location']); ?></p>

            <?php if ($userType === 'msme') : ?>
                <p><strong>Industry Type:</strong> <?php echo htmlspecialchars($userDetails['industry_type']); ?></p>
            <?php elseif ($userType === 'entrepreneur') : ?>
                <p><strong>Expertise:</strong> <?php echo htmlspecialchars($userDetails['expertise']); ?></p>
                <p><strong>Bio:</strong> <?php echo htmlspecialchars($userDetails['bio']); ?></p>
            <?php elseif ($userType === 'investor') : ?>
                <p><strong>Investment Range:</strong> <?php echo htmlspecialchars($userDetails['investment_range']); ?></p>
                <p><strong>Preferred Industry:</strong> <?php echo htmlspecialchars($userDetails['preferred_industry']); ?></p>
            <?php endif; ?>
        </div>
        <button class="logout-btn" onclick="location.href='?page=logout'">Logout</button>
    </div>
</div>
