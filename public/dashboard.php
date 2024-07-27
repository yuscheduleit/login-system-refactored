<?php
// File: public/dashboard.php
/**
 * Dashboard Page
 *
 * This file displays the user dashboard after successful login.
 */

require_once '../config/session.php';
require_once '../config/database.php';
require_once '../includes/user/user_functions.php';

// Redirect if user is not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user = get_user_by_id($pdo, $_SESSION["user_id"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
<p>This is your dashboard.</p>
<a href="../actions/logout.php">Logout</a>
</body>
</html>