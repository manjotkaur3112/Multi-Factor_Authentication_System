<?php
session_start();
include_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit();
}

$user_id = (int)$_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../public/profile.php');
    exit();
}

if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['avatar_error'] = 'No file uploaded or upload error.';
    header('Location: ../public/profile.php');
    exit();
}

$file = $_FILES['avatar'];
$allowed = ['image/jpeg','image/png','image/gif'];
if (!in_array($file['type'], $allowed)) {
    $_SESSION['avatar_error'] = 'Unsupported file type. Use JPG, PNG, or GIF.';
    header('Location: ../public/profile.php');
    exit();
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$ext = strtolower($ext);
if (!in_array($ext, ['jpg','jpeg','png','gif'])) {
    $_SESSION['avatar_error'] = 'Invalid file extension.';
    header('Location: ../public/profile.php');
    exit();
}

$uploadDir = __DIR__ . '/../assets/uploads/avatars';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$target = $uploadDir . '/' . $user_id . '.' . $ext;
// remove previous avatars for this user
foreach (glob($uploadDir . '/' . $user_id . '.*') as $f) {
    @unlink($f);
}

if (!move_uploaded_file($file['tmp_name'], $target)) {
    $_SESSION['avatar_error'] = 'Failed to move uploaded file.';
    header('Location: ../public/profile.php');
    exit();
}

// optionally set permissions
@chmod($target, 0644);

$_SESSION['avatar_success'] = 'Profile photo updated.';
header('Location: ../public/profile.php');
exit();
