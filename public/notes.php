<?php
include_once '../includes/session_check.php';
include_once '../includes/notes_functions.php';

$data = get_all_units();
$units = $data['units'] ?? [];
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Course Units & Notes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header class="page-header">
    <h1>Course Notes & Quizzes</h1>
    <p>Learn with rich unit notes, then validate your understanding with responsive quizzes. Admins can edit content directly from the course dashboard.</p>
    <?php if ($isAdmin): ?>
      <div class="action-row" style="margin-top:18px;">
        <a class="badge" href="edit_note.php">Manage Unit Notes</a>
        <a class="badge" href="edit_quiz.php">Manage Unit Quizzes</a>
      </div>
    <?php endif; ?>
  </header>

  <main class="card-grid">
    <?php foreach ($units as $u): ?>
      <article class="card">
        <div class="action-row" style="justify-content:space-between;align-items:flex-start;">
          <div>
            <h2><?php echo htmlspecialchars($u['title']); ?></h2>
            <p class="meta">Unit <?php echo htmlspecialchars($u['id']); ?> • Notes & Quiz</p>
          </div>
          <?php if ($isAdmin): ?>
            <a class="badge" href="edit_note.php?unit=<?php echo $u['id']; ?>">Edit Notes</a>
          <?php endif; ?>
        </div>
        <div class="note-content">
          <?php echo $u['content']; ?>
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
