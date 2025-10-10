<?php
require_once 'includes/auth_check.php';
require_once 'db.php';

$news_id = $_GET['id'] ?? null;

if (!$news_id) {
    header('Location: dashboard.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? AND created_by = ?");
$stmt->execute([$news_id, $_SESSION['user_id']]);
$news = $stmt->fetch();

if (!$news) {
    header('Location: dashboard.php');
    exit();
}

if ($news['image'] && file_exists(ltrim($news['image'], '/'))) {
    unlink(ltrim($news['image'], '/'));
}

$stmt = $pdo->prepare("DELETE FROM news WHERE id = ? AND created_by = ?");
$stmt->execute([$news_id, $_SESSION['user_id']]);

header('Location: dashboard.php');
exit();
?>
