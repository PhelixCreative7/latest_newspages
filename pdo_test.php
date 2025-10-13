<?php
// pdo_test.php - updated
$host = '127.0.0.1';        // use 127.0.0.1 to force TCP
$db   = 'college_news';
$user = 'root';
$pass = 'Sciencestudent185221';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4;port=3306"; // change port to 3307 if you use 3307

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "✅ Connected successfully!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
