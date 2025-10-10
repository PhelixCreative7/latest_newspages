<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['csrf_token_current']) || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION['csrf_token_current'] = bin2hex(random_bytes(32));
}
?>
