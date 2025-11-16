<?php
require_once 'db.php';

// Users you want to create
$users = [
    ['full_name' => 'skc', 'password' => 'skc123'],
    ['full_name' => 'Rajat', 'password' => 'Science123'],
    ['full_name' => 'SwatiVitkar', 'password' => '02011'],
    ['full_name' => 'Shikha', 'password' => '201011'],
];

foreach ($users as $user) {
    // Hash the password
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO latestnewsusers (full_name, password) VALUES (:full_name, :password)");
    $stmt->execute([
        ':full_name' => $user['full_name'],
        ':password' => $hashed_password
    ]);

    echo "Created user: " . htmlspecialchars($user['full_name']) . "<br>";
}

echo "All users created successfully!";
?>
