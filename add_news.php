<?php
require_once 'includes/auth_check.php';
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $event_date = $_POST['event_date'] ?? '';
    
    if (empty($title) || empty($description) || empty($event_date)) {
        $error = 'Please fill in all required fields.';
    } else {
        $image_path = null;
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $file_type = $_FILES['image']['type'];
            
            if (in_array($file_type, $allowed_types)) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = 'uploads/' . $new_filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image_path = '/' . $upload_path;
                } else {
                    $error = 'Failed to upload image.';
                }
            } else {
                $error = 'Invalid image type. Only JPEG, PNG, GIF, and WebP are allowed.';
            }
        }
        
        if (!$error) {
            $stmt = $pdo->prepare("INSERT INTO news (title, description, image, event_date, created_by) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$title, $description, $image_path, $event_date, $_SESSION['user_id']])) {
                $success = 'News posted successfully!';
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Failed to post news. Please try again.';
            }
        }
    }
}

$pageTitle = 'Add News - College News Portal';
include 'includes/header.php';
?>

<div class="container">
    <div class="form-container">
        <h1>Add New News</h1>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="add_news.php" enctype="multipart/form-data" class="news-form">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="6" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="event_date">Event Date *</label>
                <input type="date" id="event_date" name="event_date" required value="<?php echo htmlspecialchars($_POST['event_date'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="image">Image (optional)</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small>Allowed formats: JPEG, PNG, GIF, WebP</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Post News</button>
                <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
