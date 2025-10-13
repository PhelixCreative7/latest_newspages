<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        // Query using full_name as username
        $stmt = $pdo->prepare("SELECT id, full_name, password FROM users WHERE full_name = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name']; // store full_name in session
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

$pageTitle = 'Admin Login - College News Portal';
include 'includes/header.php';
?>

<div class="container">
    <div class="login-container">
        <h1>Admin Login</h1>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="login-hint">
            Default admin users:<br>
            <strong>admin1</strong> | password1<br>
            <strong>admin2</strong> | password2<br>
            <strong>admin3</strong> | password3<br>
            <strong>admin4</strong> | password4
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
