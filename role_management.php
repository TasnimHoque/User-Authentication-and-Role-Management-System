<?php
session_start();

// Sample admin credentials (Replace with your admin credentials)
$admin_email = 'admin@example.com';
$admin_password = password_hash('admin123', PASSWORD_BCRYPT);

// Check if the user is logged in
if (!isset($_SESSION['user_role'])) {
    header('Location: login.php');
    exit();
}

// Check if the logged-in user is an admin
if ($_SESSION['user_role'] !== 'admin') {
    header('HTTP/1.0 403 Forbidden');
    echo "You do not have permission to access this page.";
    exit();
}

// Load user data and roles from JSON files
if (file_exists('users.json')) {
    $users = json_decode(file_get_contents('users.json'), true);
} else {
    $users = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle role management actions
    if (isset($_POST['create_role'])) {
        $newRole = $_POST['new_role'];
        // Check if the role doesn't already exist
        if (!in_array($newRole, $users)) {
            $users[$newRole] = ['role' => $newRole];
            file_put_contents('users.json', json_encode($users));
        }
    } elseif (isset($_POST['edit_role'])) {
        $oldRole = $_POST['old_role'];
        $newRole = $_POST['new_role'];
        if (isset($users[$oldRole])) {
            $users[$newRole] = $users[$oldRole];
            unset($users[$oldRole]);
            file_put_contents('users.json', json_encode($users));
        }
    } elseif (isset($_POST['delete_role'])) {
        $roleToDelete = $_POST['role_to_delete'];
        if (isset($users[$roleToDelete])) {
            unset($users[$roleToDelete]);
            file_put_contents('users.json', json_encode($users));
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Role Management</title>
</head>
<body>
    <h2>Role Management Page</h2>

    <!-- Display role management form for the admin -->
    <?php if ($_SESSION['user_role'] === 'admin'): ?>
        <h3>Create/Edit/Delete Roles</h3>
        <form method="POST" action="role_management.php">
            <input type="text" name="new_role" placeholder="New Role" required>
            <button type="submit" name="create_role">Create Role</button>
        </form>

        <form method="POST" action="role_management.php">
            <input type="text" name="old_role" placeholder="Existing Role" required>
            <input type="text" name="new_role" placeholder="New Role" required>
            <button type="submit" name="edit_role">Edit Role</button>
        </form>

        <form method="POST" action="role_management.php">
            <input type="text" name="role_to_delete" placeholder="Role to Delete" required>
            <button type="submit" name="delete_role">Delete Role</button>
        </form>
    <?php endif; ?>

    <!-- Display the current list of roles -->
    <h3>Current Roles</h3>
    <ul>
        <?php
        foreach ($users as $role => $data) {
            echo "<li>$role</li>";
        }
        ?>
    </ul>

</body>
</html>
