<?php
include_once '../includes/session_check.php';
include_once '../includes/notes_functions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: access_denied.php?reason=Admin%20Only');
    exit();
}

$data = get_all_units();
$units = $data['units'] ?? [];
$selectedUnit = isset($_GET['unit']) ? (int)$_GET['unit'] : 0;
$quiz = $selectedUnit ? get_quiz($selectedUnit) : null;

$messages = [];
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedUnit = isset($_POST['unit']) ? (int)$_POST['unit'] : 0;
    $rawJson = trim($_POST['quiz_json'] ?? '');
    $quizData = json_decode($rawJson, true);

    if ($selectedUnit <= 0) {
        $error = 'Please choose a unit before saving the quiz.';
    } elseif (!$rawJson) {
        $error = 'Quiz JSON cannot be empty.';
    } elseif (!is_array($quizData) || !isset($quizData['questions']) || !is_array($quizData['questions'])) {
        $error = 'Invalid quiz format. Ensure you provide valid JSON with a questions array.';
    } else {
        if (save_quiz($selectedUnit, $quizData)) {
            $messages[] = 'Quiz saved successfully.';
            $quiz = $quizData;
        } else {
            $error = 'Unable to save quiz file. Check folder permissions.';
        }
    }
}

if (!$quiz && $selectedUnit) {
    $quiz = [
        'title' => 'Unit ' . $selectedUnit . ' Quiz',
        'description' => 'Enter the question array below to create a quiz for this unit.',
        'questions' => [
            [
                'q' => 'Example question text',
                'options' => ['Choice A', 'Choice B', 'Choice C', 'Choice D'],
                'a' => 0,
            ],
        ],
    ];
}

$quizString = $quiz ? json_encode($quiz, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Manage Unit Quizzes</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header class="page-header">
    <h1>Manage Unit Quizzes</h1>
    <p>Create or update unit quiz content with JSON. Use the built-in unit selector, then save the quiz to publish it instantly for learners.</p>
    <div class="action-row" style="margin-top:18px;">
      <a class="badge" href="notes.php">View Notes</a>
      <a class="badge" href="edit_note.php">Edit Notes</a>
    </div>
  </header>

  <main class="form-card">
    <?php if ($messages): ?>
      <?php foreach ($messages as $message): ?>
        <div class="msg success"><?php echo htmlspecialchars($message); ?></div>
      <?php endforeach; ?>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="edit_quiz.php">
      <div class="form-group">
        <label for="unit">Select Unit</label>
        <select id="unit" class="input-field" name="unit" onchange="this.form.submit()">
          <option value="0">Choose a unit</option>
          <?php foreach ($units as $u): ?>
            <option value="<?php echo $u['id']; ?>" <?php echo $u['id'] === $selectedUnit ? 'selected' : ''; ?>>Unit <?php echo $u['id']; ?> - <?php echo htmlspecialchars($u['title']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="quiz_json">Quiz JSON</label>
        <textarea id="quiz_json" class="textarea-field" name="quiz_json"><?php echo htmlspecialchars($quizString); ?></textarea>
      </div>

      <div class="action-row">
        <button class="btn btn-primary" type="submit">Save Quiz</button>
        <a class="btn btn-secondary" href="units.php">Back to Units</a>
      </div>
    </form>

    <section style="margin-top:28px;">
      <h2 style="margin-bottom:14px;">Quiz Format</h2>
      <p style="color:#475569;line-height:1.75;">Use the following JSON structure to define each quiz:</p>
      <pre style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:16px;padding:16px;overflow:auto;font-size:0.92rem;line-height:1.6;">{
  "title": "Unit X Quiz",
  "description": "Optional unit quiz description.",
  "questions": [
    {
      "q": "Question text?",
      "options": ["Option 1", "Option 2", "Option 3", "Option 4"],
      "a": 0
    }
  ]
}</pre>
    </section>
  </main>
</body>
</html>
