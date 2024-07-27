<?php
// File: actions/logout.php
/**
 * Logout Action
 *
 * This file handles the logout process.
 */

require_once '../config/session.php';
require_once '../includes/auth/logout_functions.php';

logout_user();

header("Location: ../public/login.php");
exit();