<?php
// File: includes/utils/validation.php
/**
 * Validation Functions
 *
 * This file contains utility functions for input validation.
 */

function validate_username($username)
{
    return strlen($username) >= 3 && strlen($username) <= 20 && ctype_alnum($username);
}

function validate_password($password)
{
    return strlen($password) >= 8;
}

function sanitize_input($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}