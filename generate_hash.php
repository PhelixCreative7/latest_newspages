<?php
// Array of passwords for your 4 admin users
$passwords = [
    'password1', // for admin1
    'password2', // for admin2
    'password3', // for admin3
    'password4'  // for admin4
];

// Loop through each password and generate a hash
foreach ($passwords as $index => $pwd) {
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    echo "Admin" . ($index + 1) . " password: " . $pwd . "<br>";
    echo "Hashed password: " . $hash . "<br><br>";
}
?>
