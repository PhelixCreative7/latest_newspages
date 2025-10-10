<?php
require_once 'includes/auth_check.php';
require_once 'db.php';

$stmt = $pdo->prepare("
    SELECT n.*, u.full_name as author_name 
    FROM news n 
    LEFT JOIN users u ON n.created_by = u.id 
    WHERE n.created_by = ?
    ORDER BY n.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$myNews = $stmt->fetchAll();

$pageTitle = 'Dashboard - College News Portal';
include 'includes/header.php';
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
        <a href="add_news.php" class="btn btn-primary">➕ Add New News</a>
    </div>

    <div class="dashboard-section">
        <h2>My News Posts</h2>
        <?php if (empty($myNews)): ?>
            <p class="no-content">You haven't posted any news yet. Click "Add New News" to get started!</p>
        <?php else: ?>
            <div class="news-table">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Event Date</th>
                            <th>Posted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($myNews as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['title']); ?></td>
                                <td><?php echo date('M j, Y', strtotime($item['event_date'])); ?></td>
                                <td><?php echo date('M j, Y', strtotime($item['created_at'])); ?></td>
                                <td class="actions">
                                    <a href="edit_news.php?id=<?php echo $item['id']; ?>" class="btn btn-small btn-secondary">Edit</a>
                                    <a href="delete_news.php?id=<?php echo $item['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this news?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
