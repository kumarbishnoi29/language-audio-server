<?php
require_once 'verify_auth.php';
require_once 'config.php';

if (!isset($_FILES['audio']) || !isset($_POST['category'])) {
    die("Missing data");
}

$category = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($_POST['category']));
$file = $_FILES['audio'];

if ($file['size'] > MAX_FILE_SIZE) die("File too large");

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ALLOWED_EXTENSIONS)) die("Invalid file type");

$catPath = AUDIO_BASE_DIR . $category;
if (!is_dir($catPath)) mkdir($catPath, 0775, true);

$filename = uniqid('audio_', true) . '.' . $ext;
if (move_uploaded_file($file['tmp_name'], "$catPath/$filename")) {
    header("Location: dashboard.php");
    exit;
} else {
    die("Upload failed");
}
?>
