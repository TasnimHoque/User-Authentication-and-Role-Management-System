<?php
session_start();

// Check if the user is not logged in; if not, redirect to the login page
if (!isset($_SESSION['user_role'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>User Dashboard</h2>
    <p>Welcome, User!</p>
    <!-- Add user-specific content and functionality here -->
</body>
</html>
