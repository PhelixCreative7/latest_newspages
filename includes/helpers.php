<?php

function get_csrf_token() {
    if (!isset($_SESSION['csrf_token_current'])) {
        $_SESSION['csrf_token_current'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token_current'];
}

function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token_current']) || !hash_equals($_SESSION['csrf_token_current'], $token)) {
        return false;
    }
    unset($_SESSION['csrf_token_current']);
    return true;
}

function validate_and_upload_image($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error.'];
    }
    
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $max_file_size = 5 * 1024 * 1024;
    
    if ($file['size'] > $max_file_size) {
        return ['success' => false, 'error' => 'File size exceeds 5MB limit.'];
    }
    
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'error' => 'Invalid file extension. Only JPG, PNG, GIF, and WebP allowed.'];
    }
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    $allowed_mimes = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png' => ['png'],
        'image/gif' => ['gif'],
        'image/webp' => ['webp']
    ];
    
    $mime_valid = false;
    foreach ($allowed_mimes as $allowed_mime => $extensions) {
        if ($mime_type === $allowed_mime && in_array($file_extension, $extensions)) {
            $mime_valid = true;
            break;
        }
    }
    
    if (!$mime_valid) {
        return ['success' => false, 'error' => 'File content does not match extension. Possible security threat.'];
    }
    
    $new_filename = bin2hex(random_bytes(16)) . '.' . $file_extension;
    $upload_path = 'uploads/' . $new_filename;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return ['success' => true, 'path' => '/uploads/' . $new_filename];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file.'];
}

function safe_delete_file($file_path) {
    if (empty($file_path)) {
        return;
    }
    
    $normalized_path = ltrim(str_replace('//', '/', $file_path), '/');
    
    if (file_exists($normalized_path) && strpos(realpath($normalized_path), realpath('uploads/')) === 0) {
        unlink($normalized_path);
    }
}
?>
