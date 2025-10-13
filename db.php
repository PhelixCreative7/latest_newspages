<?php
// db.php - MySQL version for HiveFlowTeam
$host = '127.0.0.1';
$port = 3306;                     // your MySQL port
$dbname = 'college_news';
$username = 'root';               // your MySQL root
$password = 'Sciencestudent185221'; // your MySQL root password

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
