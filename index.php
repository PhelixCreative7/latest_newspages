<?php
session_start();
require_once 'db.php';

$stmt = $pdo->query("
    SELECT n.*, u.full_name as author_name 
    FROM latestnews n 
    LEFT JOIN latestnewsusers u ON n.created_by = u.id 
    ORDER BY n.created_at DESC
");
$news = $stmt->fetchAll();

$pageTitle = 'College News Portal';
include 'includes/header.php';
?>

<div class="container">
    <div class="hero">
        <h1>Welcome to College News Portal</h1>
        <p>Stay updated with the latest news, events, and announcements</p>
    </div>

    <div class="news-grid">
        <?php if (empty($news)): ?>
            <div class="no-news">
                <p>No news posted yet. Check back later!</p>
            </div>
        <?php else: ?>
            <?php foreach ($news as $item): ?>
                <div class="news-card">
                    <?php if (!empty($item['image']) && file_exists('uploads/' . $item['image'])): ?>
                        <div class="news-image">
                            <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>">
                        </div>
                    <?php endif; ?>
                    <div class="news-content">
                        <h2><?php echo htmlspecialchars($item['title']); ?></h2>
                        <div class="news-meta">
                            <span class="event-date">📅 <?php echo date('F j, Y', strtotime($item['event_date'])); ?></span>
                            <span class="author">👤 <?php echo htmlspecialchars($item['author_name']); ?></span>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($item['description'])); ?></p>
                        <div class="news-footer">
                            <small>Posted on <?php echo date('M j, Y', strtotime($item['created_at'])); ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
