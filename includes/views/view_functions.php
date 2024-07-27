<?php
// File: includes/views/view_functions.php
/**
 * View Functions
 *
 * This file contains functions related to displaying content.
 */

function display_login_form()
{
    echo <<<HTML
    <form action="../actions/login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    HTML;
}

function display_signup_form()
{
    echo <<<HTML
    <form action="../actions/signup.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="confirm_password" placeholder="Confirm Password">
        <button type="submit">Sign Up</button>
    </form>
    HTML;
}

function display_error_messages($errors)
{
    if (!empty($errors)) {
        echo "<ul class='error-messages'>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}