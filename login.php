<?php
session_start();

// Sample admin credentials (Replace with your admin credentials)
$admin_email = 'admin@example.com';
$admin_password = password_hash('admin123', PASSWORD_BCRYPT);

// Sample user data and roles (You should use a database in a real application)
$users = [];
$roles = ['user'];

// Load user data and roles from JSON files
if (file_exists('users.json')) {
    $users = json_decode(file_get_contents('users.json'), true);
}

if (file_exists('roles.json')) {
    $roles = json_decode(file_get_contents('roles.json'), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists and the password is correct
    if (isset($users[$email]) && password_verify($password, $users[$email]['password'])) {
        // Set the user's role in the session
        $_SESSION['user_role'] = $users[$email]['role'];

        // Redirect based on the user's role
        if ($email === $admin_email && password_verify($password, $admin_password)) {
            // Redirect admin to the role management page
            header('Location: admin_dashboard.php');
            exit();
        } else {
            // Redirect regular users to the user dashboard
            header('Location: user_dashboard.php');
            exit();
        }
    }
}
?>

<!-- Login form -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
