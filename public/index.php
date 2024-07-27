<?php
// File: public/index.php
/**
 * Main Entry Point
 *
 * This file serves as the main entry point for the application.
 * It handles routing to different pages based on the URL.
 */

require_once '../config/session.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
    case '':
    case '/index.php':
        require __DIR__ . '/login.php';
        break;
    case '/dashboard':
        require __DIR__ . '/dashboard.php';
        break;
    case '/login':
        require __DIR__ . '/login.php';
        break;
    case '/signup':
        require __DIR__ . '/signup.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
        break;
}