<?php
// File: includes/auth/signup_functions.php
/**
 * Signup Functions
 *
 * This file contains functions related to user registration.
 */



function is_username_taken($pdo, $username)
{
    return get_user($pdo, $username) ? true : false;
}

function create_user($pdo, $username, $password)
{
    $query = "INSERT INTO users (username, password) VALUES (:username, :password);";
    $stmt = $pdo->prepare($query);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);

    $stmt->execute();
}