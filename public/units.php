<?php
include_once '../includes/session_check.php';
include_once '../includes/notes_functions.php';

$data = get_all_units();
$units = $data['units'] ?? [];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>All Units</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header class="page-header">
    <h1>All Units</h1>
    <p>Explore the full course with notes and quizzes for every topic. Tap a unit to review the material or test your learning instantly.</p>
  </header>

  <main class="card-grid">
    <?php foreach ($units as $u): ?>
      <article class="card">
        <div>
          <h3><?php echo htmlspecialchars($u['title']); ?></h3>
          <p class="meta">Unit <?php echo htmlspecialchars($u['id']); ?> • Notes + Quiz</p>
        </div>
        <div class="action-row">
          <a class="btn btn-primary" href="unit.php?unit=<?php echo $u['id']; ?>">Read Notes</a>
          <a class="btn btn-secondary" href="quiz.php?unit=<?php echo $u['id']; ?>">Take Quiz</a>
        </div>
      </article>
    <?php endforeach; ?>
  </main>
</body>
</html>
