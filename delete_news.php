<?php
require_once 'includes/auth_check.php';
require_once 'db.php';
require_once 'includes/helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit();
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    header('Location: dashboard.php');
    exit();
}

$news_id = $_POST['id'] ?? null;

if (!$news_id) {
    header('Location: dashboard.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM latestnews WHERE id = ? AND created_by = ?");
$stmt->execute([$news_id, $_SESSION['user_id']]);
$news = $stmt->fetch();

if (!$news) {
    header('Location: dashboard.php');
    exit();
}

safe_delete_file($news['image']);

$stmt = $pdo->prepare("DELETE FROM latestnews WHERE id = ? AND created_by = ?");
$stmt->execute([$news_id, $_SESSION['user_id']]);

header('Location: dashboard.php');
exit();
?>
