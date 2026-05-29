<?php
include_once '../includes/session_check.php';
include_once '../includes/functions.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';

$avatarPath = null;
$search = glob(__DIR__ . '/../assets/uploads/avatars/' . $user_id . '.*');
if ($search && isset($search[0])) {
    $p = $search[0];
    $avatarPath = str_replace(__DIR__ . '/..', '..', $p);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>My Profile</title>
    <style>
        body { font-family: Inter, Poppins, sans-serif; background:#f7fbff; color:#0f172a; margin:0; padding:24px; }
        .wrap { max-width:900px; margin:24px auto; display:flex; gap:24px; }
        .card { background:#fff; border-radius:12px; padding:20px; box-shadow:0 8px 30px rgba(15,23,42,0.06); }
        .profile { width:280px; text-align:center; }
        .profile .avatar { width:160px; height:160px; border-radius:80px; overflow:hidden; margin:0 auto 12px; display:inline-block; background:#e6eefc; display:flex;align-items:center;justify-content:center;font-size:36px;color:#1e293b }
        .info { flex:1; padding:20px; }
        .info h2{ margin:0 0 8px }
        .info p{ margin:6px 0; color:#334155 }
        .upload-form { margin-top:12px }
        input[type=file]{ display:block; margin:12px auto }
        .btn { background:#2563eb;color:#fff;padding:10px 14px;border-radius:10px;border:none;cursor:pointer }
        .msg { padding:10px;border-radius:8px;margin-bottom:12px }
        .success{ background:#ecfdf5;color:#065f46 }
        .error{ background:#ffe4e6;color:#9f1239 }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card profile">
            <?php if ($avatarPath): ?>
                <div class="avatar"><img src="<?= htmlspecialchars($avatarPath) ?>" alt="avatar" style="width:100%;height:100%;object-fit:cover;display:block"></div>
            <?php else: ?>
                <div class="avatar"><?php echo strtoupper(substr($username,0,1)); ?></div>
            <?php endif; ?>
            <div>
                <a href="profile.php" style="text-decoration:none"><button class="btn">Change Photo</button></a>
            </div>
            <?php if (!empty($_SESSION['avatar_success'])): ?><div class="msg success"><?php echo $_SESSION['avatar_success']; unset($_SESSION['avatar_success']); ?></div><?php endif; ?>
            <?php if (!empty($_SESSION['avatar_error'])): ?><div class="msg error"><?php echo $_SESSION['avatar_error']; unset($_SESSION['avatar_error']); ?></div><?php endif; ?>
            <form class="upload-form" action="../includes/upload_avatar.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="avatar" accept="image/*" required>
                <button class="btn" type="submit">Upload</button>
            </form>
        </div>
        <div class="card info">
            <h2>Account Information</h2>
            <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['role'] ?? '') ?></p>
            <p style="margin-top:18px;color:#475569">Click on the photo area to change your profile picture. The image will be used across the site.</p>
            <div style="margin-top:18px"><a href="dashboard_user.php">Back to Dashboard</a></div>
        </div>
    </div>
</body>
</html>
