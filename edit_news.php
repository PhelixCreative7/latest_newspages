<?php
require_once 'includes/auth_check.php';
require_once 'db.php';

$error = '';
$success = '';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    
    if (empty($title) || empty($description) || empty($event_date)) {
        $error = 'Please fill in all required fields.';
    } else {
        $image_path = $news['image'];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = 'uploads/' . $new_filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    if ($news['image'] && file_exists(ltrim($news['image'], '/'))) {
                        unlink(ltrim($news['image'], '/'));
                    }
                    $image_path = '/' . $upload_path;
                } else {
                    $error = 'Failed to upload image.';
                }
            } else {
                $error = 'Invalid image type. Only JPEG, PNG, GIF, and WebP are allowed.';
            }
        }
        
        if (!$error) {
            $stmt = $pdo->prepare("UPDATE news SET title = ?, description = ?, image = ?, event_date = ? WHERE id = ? AND created_by = ?");
            if ($stmt->execute([$title, $description, $image_path, $event_date, $news_id, $_SESSION['user_id']])) {
                $success = 'News updated successfully!';
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Failed to update news. Please try again.';
            }
        }
    }
}

$pageTitle = 'Edit News - College News Portal';
include 'includes/header.php';
?>

<div class="container">
    <div class="form-container">
        <h1>Edit News</h1>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="edit_news.php?id=<?php echo $news_id; ?>" enctype="multipart/form-data" class="news-form">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($_POST['title'] ?? $news['title']); ?>">
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="6" required><?php echo htmlspecialchars($_POST['description'] ?? $news['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="event_date">Event Date *</label>
                <input type="date" id="event_date" name="event_date" required value="<?php echo htmlspecialchars($_POST['event_date'] ?? $news['event_date']); ?>">
            </div>
            
            <div class="form-group">
                <label for="image">Image (optional)</label>
                <?php if ($news['image']): ?>
                    <div class="current-image">
                        <img src="<?php echo htmlspecialchars($news['image']); ?>" alt="Current image" style="max-width: 200px; margin-bottom: 10px;">
                        <p><small>Current image (upload new to replace)</small></p>
                    </div>
                <?php endif; ?>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Allowed formats: JPEG, PNG, GIF, WebP</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update News</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
