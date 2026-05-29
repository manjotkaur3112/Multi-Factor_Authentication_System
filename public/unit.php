<?php
include_once '../includes/session_check.php';
include_once '../includes/notes_functions.php';

$id = isset($_GET['unit']) ? (int)$_GET['unit'] : 0;
$unit = get_unit($id);
if (!$unit) {
    header('Location: units.php'); exit();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($unit['title']); ?></title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header class="page-header">
    <h1><?php echo htmlspecialchars($unit['title']); ?></h1>
    <p>Read the full unit notes with a clean, responsive layout. When you are ready, take the unit quiz to check your knowledge.</p>
  </header>

  <main class="content-card">
    <div class="note-content">
      <?php echo $unit['content']; ?>
    </div>
    <div class="action-row">
      <a class="btn btn-primary" href="quiz.php?unit=<?php echo $unit['id']; ?>">Take Quiz</a>
      <a class="btn btn-secondary" href="units.php">All Units</a>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a class="btn btn-outline" href="edit_note.php?unit=<?php echo $unit['id']; ?>">Edit Notes</a>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>
