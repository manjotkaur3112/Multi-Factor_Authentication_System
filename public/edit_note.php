<?php
include_once '../includes/session_check.php';
include_once '../includes/notes_functions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: access_denied.php?reason=Admin%20Only');
    exit();
}

$data = get_all_units();
$units = $data['units'] ?? [];

$editing = null;
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['unit'])) {
    $editing = get_unit((int)$_GET['unit']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = trim($_POST['title'] ?? '');
    $content = $_POST['content'] ?? '';

    foreach ($units as &$u) {
        if ((int)$u['id'] === $id) {
            $u['title'] = $title;
            $u['content'] = $content;
        }
    }
    unset($u);

    if (save_units(['units' => $units])) {
        $_SESSION['notes_success'] = 'Unit saved.';
    } else {
        $_SESSION['notes_error'] = 'Failed to save unit.';
    }
    header('Location: edit_note.php?unit=' . $id);
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Unit Notes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header class="page-header">
    <h1>Edit Unit Notes</h1>
    <p>Update titles, revise note content, and publish changes instantly across the course view.</p>
    <div class="action-row" style="margin-top:18px;">
      <a class="badge" href="notes.php">View Notes</a>
      <a class="badge" href="edit_quiz.php">Manage Quizzes</a>
    </div>
  </header>

  <main class="form-card">
    <?php if (!empty($_SESSION['notes_success'])): ?>
      <div class="msg success"><?php echo $_SESSION['notes_success']; unset($_SESSION['notes_success']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['notes_error'])): ?>
      <div class="msg error"><?php echo $_SESSION['notes_error']; unset($_SESSION['notes_error']); ?></div>
    <?php endif; ?>

    <div class="form-group">
      <label>Select a Unit to Edit</label>
      <div class="action-row">
        <?php foreach ($units as $u): ?>
          <a class="btn btn-secondary" href="edit_note.php?unit=<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['title']); ?></a>
        <?php endforeach; ?>
      </div>
    </div>

    <?php if ($editing): ?>
      <form method="POST" action="edit_note.php">
        <input type="hidden" name="id" value="<?php echo (int)$editing['id']; ?>">
        <div class="form-group">
          <label for="title">Unit Title</label>
          <input id="title" class="input-field" type="text" name="title" value="<?php echo htmlspecialchars($editing['title']); ?>">
        </div>
        <div class="form-group">
          <label for="content">Content (HTML allowed)</label>
          <textarea id="content" class="textarea-field" name="content"><?php echo htmlspecialchars($editing['content']); ?></textarea>
        </div>
        <div class="action-row">
          <button class="btn btn-primary" type="submit">Save Unit</button>
          <a class="btn btn-secondary" href="notes.php">View Notes</a>
          <a class="btn btn-outline" href="edit_quiz.php?unit=<?php echo $editing['id']; ?>">Edit Unit Quiz</a>
        </div>
      </form>
    <?php else: ?>
      <div class="msg">Select a unit above to begin editing its notes.</div>
    <?php endif; ?>
  </main>
</body>
</html>
