<?php

// Retrieve environment variables
$host = getenv('DB_HOST') ?: 'localhost';  // Fallback to localhost if not set
$port = getenv('DB_PORT') ?: '5432';       // Default PostgreSQL port
$dbname = getenv('DB_NAME') ?: 'campusbites'; 
$dbuser = getenv('DB_USER') ?: 'postgres';
$dbpass = getenv('DB_PASS') ?: '1038';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
