<?php
include_once '../includes/session_check.php';

$unitId = isset($_GET['unit']) ? (int)$_GET['unit'] : 0;
$quizFile = __DIR__ . "/../data/quiz_unit{$unitId}.json";
if (!file_exists($quizFile)) {
    $missing = true;
    $quiz = ['title' => 'Quiz not found', 'description' => 'This unit does not have a quiz available yet.'];
    $questions = [];
} else {
    $missing = false;
    $quiz = json_decode(file_get_contents($quizFile), true);
    $questions = $quiz['questions'] ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $total = count($questions);
    foreach ($questions as $i => $q) {
        $name = 'q'.$i;
        $given = isset($_POST[$name]) ? (int)$_POST[$name] : -1;
        if ($given === (int)$q['a']) {
            $score++;
        }
    }
    ?>
    <!doctype html>
    <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <title><?php echo htmlspecialchars($quiz['title'] ?? 'Quiz Results'); ?></title>
      <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
      <header class="page-header">
        <h1><?php echo htmlspecialchars($quiz['title'] ?? 'Quiz Results'); ?></h1>
        <p>You completed the quiz. Review your score and the correct answers below.</p>
      </header>
      <main class="content-card">
        <div class="msg success">Your score: <?php echo $score; ?> / <?php echo $total; ?></div>
        <div class="action-row">
          <a class="btn btn-primary" href="quiz.php?unit=<?php echo $unitId; ?>">Retake Quiz</a>
          <a class="btn btn-secondary" href="units.php">All Units</a>
        </div>
        <section style="margin-top:28px;">
          <h2>Correct Answers</h2>
          <ol style="padding-left:20px;">
            <?php foreach ($questions as $i => $q): ?>
              <li style="margin-bottom:18px;">
                <div style="font-weight:700;color:#0f172a;"><?php echo htmlspecialchars($q['q']); ?></div>
                <div style="margin-top:8px;color:#475569;"><strong>Answer:</strong> <?php echo htmlspecialchars($q['options'][$q['a']]); ?></div>
              </li>
            <?php endforeach; ?>
          </ol>
        </section>
      </main>
    </body>
    </html>
    <?php
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($quiz['title'] ?? 'Unit Quiz'); ?></title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <header class="page-header">
    <h1><?php echo htmlspecialchars($quiz['title'] ?? 'Unit Quiz'); ?></h1>
    <p><?php echo htmlspecialchars($quiz['description'] ?? 'Answer the questions below to gauge your understanding.'); ?></p>
  </header>

  <main class="form-card">
    <?php if ($missing || empty($questions)): ?>
      <div class="msg error">No quiz is currently available for this unit. Return to the unit list to continue.</div>
      <div class="action-row">
        <a class="btn btn-secondary" href="units.php">Back to Units</a>
      </div>
    <?php else: ?>
      <form method="POST" action="quiz.php?unit=<?php echo $unitId; ?>">
        <ol style="padding-left:20px;">
          <?php foreach ($questions as $i => $q): ?>
            <li style="margin-bottom:24px;">
              <div style="font-weight:700;margin-bottom:14px;color:#0f172a;"><?php echo htmlspecialchars($q['q']); ?></div>
              <?php foreach ($q['options'] as $idx => $opt): ?>
                <label class="quiz-option"><input type="radio" name="q<?php echo $i; ?>" value="<?php echo $idx; ?>"> <?php echo htmlspecialchars($opt); ?></label>
              <?php endforeach; ?>
            </li>
          <?php endforeach; ?>
        </ol>
        <div class="action-row">
          <button class="btn btn-primary" type="submit">Submit Quiz</button>
          <a class="btn btn-secondary" href="units.php">Back to Units</a>
        </div>
      </form>
    <?php endif; ?>
  </main>
</body>
</html>
