<?php
// File: includes/auth/login_functions.php
/**
 * Login Functions
 *
 * This file contains functions related to user login.
 */

function is_input_empty($username, $password)
{
    return empty($username) || empty($password);
}

function is_username_wrong($result)
{
    return !$result;
}

function is_password_wrong($password, $hashedPassword)
{
    return !password_verify($password, $hashedPassword);
}

function get_user($pdo, $username)
{
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
