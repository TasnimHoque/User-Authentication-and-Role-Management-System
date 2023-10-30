<?php
session_start();

// Initialize user data and roles (You should use a database in a real application)
$users = [];
$roles = ['user']; // Only allow users to register

// Load user data and roles from JSON files
if (file_exists('users.json')) {
    $users = json_decode(file_get_contents('users.json'), true);
}

if (file_exists('roles.json')) {
    $roles = json_decode(file_get_contents('roles.json'), true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_role = 'user';

    // Check if the email is already registered
    if (isset($users[$email])) {
        // Handle registration error, email already exists
    } else {
        // Add the user to the users array
        $users[$email] = ['password' => $password, 'role' => $user_role];

        // Save user data and roles to JSON files
        file_put_contents('users.json', json_encode($users));
        file_put_contents('roles.json', json_encode($roles));

        // Redirect to the login page after successful registration
        header('Location: login.php');
        exit();
    }
}
?>

<!-- Registration form (Removed the role selection) -->
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="POST" action="register.php">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
