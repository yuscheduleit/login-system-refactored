<?php
// File: actions/login.php
/**
 * Login Action
 *
 * This file handles the login form submission.
 */

require_once '../config/session.php';
require_once '../config/database.php';
require_once '../includes/auth/login_functions.php';
require_once '../includes/utils/validation.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = $_POST["password"];

    $errors = [];

    if (is_input_empty($username, $password)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $user = get_user($pdo, $username);

        if ($user === false) {
            $errors[] = "Invalid username or password.";
        } elseif (!password_verify($password, $user["password"])) {
            $errors[] = "Invalid username or password.";
        }
    }

    if (empty($errors)) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: ../public/dashboard.php");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../public/login.php");
        exit();
    }
} else {
    header("Location: ../public/login.php");
    exit();
}