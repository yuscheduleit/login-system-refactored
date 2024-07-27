<?php
// File: includes/tokens/token_functions.php
/**
 * Token Functions
 *
 * This file contains functions related to handling remember-me tokens.
 */

function create_token($pdo, $userId)
{
    $selector = bin2hex(random_bytes(8));
    $validator = bin2hex(random_bytes(32));

    $token = $selector . ':' . $validator;

    $hashedValidator = password_hash($validator, PASSWORD_DEFAULT);
    $expiry = date('Y-m-d H:i:s', time() + 864000); // 10 days

    $query = "INSERT INTO auth_tokens (user_id, selector, hashed_validator, expiry) 
              VALUES (:user_id, :selector, :hashed_validator, :expiry)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'user_id' => $userId,
        'selector' => $selector,
        'hashed_validator' => $hashedValidator,
        'expiry' => $expiry
    ]);

    return $token;
}

function verify_token($pdo, $token)
{
    list($selector, $validator) = explode(':', $token);

    $query = "SELECT * FROM auth_tokens WHERE selector = :selector AND expiry >= NOW()";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['selector' => $selector]);
    $tokenData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tokenData && password_verify($validator, $tokenData['hashed_validator'])) {
        return $tokenData['user_id'];
    }

    return false;
}