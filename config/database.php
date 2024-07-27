<?php
// File: config/database.php
/**
 * Database Configuration
 *
 * This file contains the database connection settings.
 * It defines the database host, name, username, and password.
 * It also establishes a PDO connection to the database.
 */

$host = "localhost";
$dbName = "vtt";
$dbUsername = "root";
$dbPassword = "";
$db_charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$dbName;charset=$db_charset";

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}