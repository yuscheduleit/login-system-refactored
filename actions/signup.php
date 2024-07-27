<?php
// File: actions/signup.php
/**
 * Signup Action
 *
 * This file handles the signup form submission.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config/session.php';
require_once '../config/database.php';
require_once '../includes/auth/login_functions.php';
require_once '../includes/auth/signup_functions.php';
require_once '../includes/utils/validation.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $errors = [];

    if (is_input_empty($username, $password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if (!validate_username($username)) {
        $errors[] = "Username must be 3-20 characters long and contain only letters and numbers.";
    }

    if (!validate_password($password)) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (is_username_taken($pdo, $username)) {
        $errors[] = "Username is already taken.";
    }

    if (empty($errors)) {
        create_user($pdo, $username, $password);
        $_SESSION['success'] = "Account created successfully. You can now log in.";
        header("Location: ../public/login.php");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ../public/signup.php");
        exit();
    }
} else {
    header("Location: ../public/signup.php");
    exit();
}