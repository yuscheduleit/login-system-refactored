<?php
// File: includes/user/user_functions.php
/**
 * User Functions
 *
 * This file contains functions related to user management.
 */

function get_user_by_id($pdo, $userId)
{
    $query = "SELECT * FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function update_user_profile($pdo, $userId, $newData)
{
    $query = "UPDATE users SET username = :username WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $newData['username']);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}