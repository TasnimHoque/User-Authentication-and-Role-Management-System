<?php
session_start();

// Check if the user is an admin; if not, redirect to the user dashboard
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: user_dashboard.php');
    exit();
}

// Admin-specific content and functionality
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <p>Welcome, Admin!</p>
    <!-- Add admin-specific content and functionality here -->
    <p><a href="role_management.php">Role Management</a></p>
</body>
</html>
