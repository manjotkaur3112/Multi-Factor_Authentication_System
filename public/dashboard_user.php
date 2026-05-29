<?php 
include_once '../includes/session_check.php'; 
include_once '../includes/functions.php'; 

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'user') {
    header('Location: access_denied.php?reason=User%20Only%20Page'); 
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$avatar = null;
if ($user_id) {
    foreach (['png','jpg','jpeg','gif'] as $ext) {
        $path = __DIR__ . "/../assets/uploads/avatars/{$user_id}.{$ext}";
        if (file_exists($path)) {
            $avatar = "../assets/uploads/avatars/{$user_id}.{$ext}";
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>User Dashboard | Secure Auth</title>
<style>
    :root {
        color-scheme: light;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: #1f2937;
        background: #eef2ff;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        background: radial-gradient(circle at top left, rgba(59,130,246,0.12), transparent 35%),
                    linear-gradient(180deg, #f8fbff 0%, #eef2ff 100%);
    }

    body, button, input, select, textarea {
        font-family: inherit;
    }

    .container {
        width: min(1140px, calc(100% - 32px));
        margin: 32px auto;
        padding: 0;
    }

    .dashboard-header {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(240px, 1fr);
        gap: 24px;
        margin-bottom: 28px;
    }

    .hero-panel {
        background: rgba(255,255,255,0.92);
        border: 1px solid rgba(148,163,184,0.18);
        box-shadow: 0 18px 60px rgba(15,23,42,0.08);
        border-radius: 28px;
        padding: 34px 36px;
    }

    .hero-panel p {
        margin: 18px 0 0;
        color: #475569;
        font-size: 1.05rem;
        max-width: 680px;
    }

    .hero-title {
        margin: 0;
        color: #0f172a;
        font-size: clamp(2.4rem, 3vw, 3.4rem);
        line-height: 1.05;
    }

    .hero-meta {
        margin-top: 22px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .meta-card {
        background: #f8fafc;
        border-radius: 18px;
        border: 1px solid rgba(148,163,184,0.16);
        padding: 18px 20px;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.8);
    }

    .meta-card strong {
        display: block;
        margin-top: 10px;
        color: #0f172a;
        font-size: 1.15rem;
    }

    .profile-card {
        background: #0f172a;
        color: #ffffff;
        border-radius: 28px;
        padding: 28px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 100%;
    }

    .profile-avatar {
        width: 112px;
        height: 112px;
        border-radius: 999px;
        background: linear-gradient(135deg, #e0f2fe, #e0e7ff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: #1e293b;
        border: 5px solid rgba(255,255,255,0.85);
        overflow: hidden;
        margin-bottom: 18px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .profile-card h2 {
        margin: 0;
        font-size: 1.15rem;
    }

    .profile-card p {
        margin: 10px 0 20px;
        color: #dbeafe;
        max-width: 260px;
        font-size: 0.96rem;
    }

    .button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 12px 20px;
        border: none;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .button-primary {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 14px 35px rgba(37,99,235,0.18);
    }

    .button-secondary {
        background: #f8fafc;
        color: #0f172a;
        border: 1px solid rgba(15,23,42,0.08);
    }

    .button-tertiary {
        background: transparent;
        color: #2563eb;
    }

    .button:hover {
        transform: translateY(-1px);
    }

    .profile-card .button {
        width: 100%;
        max-width: 220px;
    }

    .section-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin: 20px 0 14px;
    }

    .section-heading h2 {
        margin: 0;
        color: #0f172a;
        font-size: 1.7rem;
    }

    .section-heading p {
        margin: 0;
        color: #475569;
    }

    .unit-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .unit-card {
        background: #ffffff;
        border: 1px solid rgba(148,163,184,0.16);
        border-radius: 24px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 18px;
        box-shadow: 0 18px 40px rgba(15,23,42,0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .unit-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 24px 56px rgba(15,23,42,0.1);
    }

    .unit-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: rgba(59,130,246,0.12);
        color: #1d4ed8;
        font-size: 0.88rem;
        font-weight: 700;
        padding: 8px 12px;
        width: fit-content;
    }

    .unit-card h3 {
        margin: 0;
        font-size: 1.15rem;
        color: #0f172a;
        line-height: 1.35;
    }

    .unit-card p {
        margin: 0;
        color: #475569;
        font-size: 0.97rem;
    }

    .unit-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .support-card {
        margin-top: 28px;
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid rgba(148,163,184,0.16);
        box-shadow: 0 18px 40px rgba(15,23,42,0.06);
        padding: 28px 32px;
    }

    .support-card h3 {
        margin-top: 0;
        font-size: 1.35rem;
    }

    .support-card ul {
        display: grid;
        gap: 14px;
        margin-top: 18px;
    }

    .support-card li {
        background: #f8fafc;
        border: 1px solid rgba(148,163,184,0.12);
        border-radius: 16px;
        padding: 16px 18px;
    }

    .support-card button {
        width: 100%;
        max-width: 300px;
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(37,99,235,0.18);
    }

    .support-card a {
        color: #2563eb;
        font-weight: 600;
    }

    @media (max-width: 900px) {
        .dashboard-header {
            grid-template-columns: 1fr;
        }

        .hero-meta {
            grid-template-columns: 1fr;
        }

        .section-heading {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 640px) {
        .container {
            width: min(100%, calc(100% - 20px));
            margin: 20px auto;
        }

        .hero-panel,
        .profile-card,
        .support-card,
        .unit-card {
            padding: 22px;
        }

        .profile-avatar {
            width: 96px;
            height: 96px;
        }
    }
</style>
</head>
<body>

<div class="container">
    <div class="dashboard-header">
        <section class="hero-panel">
            <p class="eyebrow" style="margin:0; color:#2563eb; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; font-size:0.8rem;">Dashboard</p>
            <h1 class="hero-title">Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p class="dashboard-header__sub">Manage your learning dashboard and continue your course progress.</p>
        </section>

        <aside class="profile-card">
            <a href="profile.php" class="profile-avatar" title="Edit profile">
                <?php if ($avatar): ?>
                    <img src="<?= htmlspecialchars($avatar) ?>" alt="avatar">
                <?php else: ?>
                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                <?php endif; ?>
            </a>
            <h2 style="margin:8px 0 6px; font-size:1.15rem;"><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <a href="logout.php" class="button button-secondary">Logout</a>
        </aside>
    </div>

    <?php
    $unitsFile = __DIR__ . '/../data/units_notes.json';
    $units = [];
    if (file_exists($unitsFile)) {
        $raw = file_get_contents($unitsFile);
        $data = json_decode($raw, true);
        if (is_array($data) && isset($data['units'])) {
            $units = $data['units'];
        }
    }
    ?>

    <section>
        <div class="section-heading">
            <div>
                <h2>All Units</h2>
                <p>Select a unit below to read the notes or take the quiz.</p>
            </div>
            <a href="units.php" class="button button-primary">Browse All Units</a>
        </div>

        <?php if (empty($units)): ?>
            <div class="unit-grid">
                <div class="unit-card">
                    <h3>No units available</h3>
                    <p>We could not load unit data at the moment. Please check the unit file or try again later.</p>
                    <div class="unit-actions">
                        <a href="units.php" class="button button-secondary">Open units list</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="unit-grid">
                <?php foreach ($units as $unit): ?>
                    <article class="unit-card">
                        <span class="unit-chip">Unit <?php echo htmlspecialchars($unit['id'] ?? ''); ?></span>
                        <h3><?php echo htmlspecialchars($unit['title'] ?? 'Untitled Unit'); ?></h3>
                        <p>Review the notes or test your knowledge with a quick quiz for this unit.</p>
                        <div class="unit-actions">
                            <a href="unit.php?unit=<?php echo urlencode($unit['id'] ?? ''); ?>" class="button button-tertiary">View Notes</a>
                            <a href="quiz.php?unit=<?php echo urlencode($unit['id'] ?? ''); ?>" class="button button-primary">Take Quiz</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="support-card">
        <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:16px;">
            <div>
                <h3>Support & Security</h3>
                <p style="margin:0; color:#475569;">Need help with your account? Review security guidance or report an issue instantly.</p>
            </div>
            <a href="helper.php" class="button button-tertiary">Help & Support</a>
        </div>
        <ul>
            <li>
                <form method="POST" action="../includes/report_compromise.php" style="margin:0;">
                    <button type="submit" class="button button-primary">Report Account Compromised</button>
                </form>
            </li>
        </ul>
    </section>
</div>

<script src="../assets/js/popup.js"></script>
<script>
function requestAccess(e, page) {
    e.preventDefault();
    fetch('../includes/request_access.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'page=' + encodeURIComponent(page)
    })
    .then(response => response.text())
    .then(text => alert(text));
    return false;
}
</script>
</body>
</html>
