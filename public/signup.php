<?php
// File: public/signup.php
/**
 * Signup Page
 *
 * This file displays the signup form and handles signup errors.
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
    <title>Sign Up</title>
</head>
<body>
<h1>Sign Up</h1>
<?php
display_error_messages($_SESSION['errors'] ?? []);
unset($_SESSION['errors']);
display_signup_form();
?>
<p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>