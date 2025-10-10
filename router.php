<?php
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/^\/uploads\/.*\.php$/i', $request_uri)) {
    http_response_code(403);
    die('Access forbidden');
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $request_uri) && !is_dir($_SERVER['DOCUMENT_ROOT'] . $request_uri)) {
    return false;
}

require 'index.php';
?>
