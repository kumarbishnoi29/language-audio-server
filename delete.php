<?php
require_once 'verify_auth.php';
require_once 'config.php';

$category = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['category'] ?? '');
$file = basename($_POST['file'] ?? '');
$path = AUDIO_BASE_DIR . "$category/$file";

if (file_exists($path)) unlink($path);
header("Location: dashboard.php");
exit;
?>
