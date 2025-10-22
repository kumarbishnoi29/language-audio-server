<?php
session_start();

define('AUDIO_BASE_DIR', __DIR__ . '/categories/');
define('ALLOWED_EXTENSIONS', ['mp3', 'wav', 'ogg']);
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB
?>
