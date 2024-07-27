<?php
// File: includes/auth/logout_functions.php
/**
 * Logout Functions
 *
 * This file contains functions related to user logout.
 */

function logout_user()
{
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();
}