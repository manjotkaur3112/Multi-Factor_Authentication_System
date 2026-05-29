<?php
include_once '../includes/session_check.php';
include_once '../includes/functions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: access_denied.php?reason=Admin%20Area');
    exit();
}

$displayName = $_SESSION['username'] 
    ?? ($_SESSION['first_name'] ?? 'Admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 60px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .card {
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            background: #f0f4f8;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout {
            display: inline-block;
            margin-top: 25px;
            background: #e63946;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }
        .logout:hover {
            background: #c72d38;
        }
    </style>
</head>
<body>
<div class="container" style="display:flex; gap:22px; align-items:flex-start;">
    <div style="flex:1">
        <h1>Welcome, <?php echo htmlspecialchars($displayName); ?></h1>

        <div class="card">
            <h3>Admin Controls</h3>
            <ul>
                <li><a href="../admin/manage_users.php">Manage Users</a></li>
                <li><a href="../admin/system_logs.php">System Logs</a></li>
                <li><a href="../admin/compromise_requests.php">Report Compromise</a></li>
                <li><a href="../public/units.php">Manage Unit Notes & Quizzes</a></li>
            </ul>
        </div>
    </div>

    <aside style="width:320px;">
        <?php
        $user_id = $_SESSION['user_id'];
        $avatar = null;
        foreach (['png','jpg','jpeg','gif'] as $ext) {
            $path = __DIR__ . "/../assets/uploads/avatars/{$user_id}.{$ext}";
            if (file_exists($path)) { $avatar = "../assets/uploads/avatars/{$user_id}.{$ext}"; break; }
        }
        ?>
        <div class="card">
            <div style="text-align:center; margin-bottom:12px;">
                <?php if ($avatar): ?>
                    <a href="profile.php"><img src="<?= htmlspecialchars($avatar) ?>" alt="avatar" style="width:120px;height:120px;border-radius:60px;object-fit:cover;border:4px solid #fff;box-shadow:0 6px 18px rgba(16,24,40,0.08)"></a>
                <?php else: ?>
                    <a href="profile.php"><div style="width:120px;height:120px;border-radius:60px;background:#e6eefc;display:inline-flex;align-items:center;justify-content:center;font-size:42px;color:#1e293b;">
                        <?php echo strtoupper(substr($_SESSION['username'] ?? 'A',0,1)); ?></div></a>
                <?php endif; ?>
            </div>
            <h3 style="text-align:center;margin-top:0;">Account Information</h3>
            <ul style="list-style:none;padding:0;margin:8px 0 0 0">
                <li><strong>Username:</strong> <?= htmlspecialchars($displayName) ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email'] ?? 'Unknown') ?></li>
                <li><strong>Role:</strong> Admin</li>
            </ul>
            <div style="text-align:center;margin-top:14px"><a href="profile.php">Manage profile</a></div>
        </div>
        <div style="text-align:center;margin-top:12px"><a href="logout.php" class="logout">Logout</a></div>
    </aside>
</div>

<script src="../assets/js/popup.js"></script>
</body>
</html>
