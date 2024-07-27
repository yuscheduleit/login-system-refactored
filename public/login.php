<?php
// File: public/login.php
/**
 * Login Page
 *
 * This file displays the login form and handles login errors.
 */

require_once '../config/session.php';
require_once '../includes/views/view_functions.php';

// Redirect if user is already logged in
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>
<?php
display_error_messages($_SESSION['errors'] ?? []);
unset($_SESSION['errors']);
display_login_form();
?>
<p>Don't have an account? <a href="signup.php">Sign up here</a></p>
</body>
</html>