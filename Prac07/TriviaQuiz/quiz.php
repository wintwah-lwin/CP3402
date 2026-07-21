<?php
include('includes/header.php');

/** @var mysqli $connect */

$quizSubmitted = false;
$score = 0;
$reviewData = [];

if (isset($_POST['btnSubmitQuiz'])) {
    $quizSubmitted = true;
    
    if (isset($_POST['answers']) && is_array($_POST['answers'])) {
        foreach ($_POST['answers'] as $qID => $selectedOption) {
            $stmt = $connect->prepare("SELECT QuestionText, CorrectAnswer FROM questions WHERE QuestionID = ?");
            $stmt->bind_param("i", $qID);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $isCorrect = ($row['CorrectAnswer'] === $selectedOption);
                if ($isCorrect) {
                    $score += 10;
                }

                $reviewData[] = [
                    'question' => $row['QuestionText'],
                    'userAnswer' => $selectedOption,
                    'correctAnswer' => $row['CorrectAnswer'],
                    'isCorrect' => $isCorrect
                ];
            }
            $stmt->close();
        }
    }

    $totalQuestions = count($reviewData);
    $totalPossibleScore = $totalQuestions * 10;

    if (isset($_SESSION['UserID'])) {
        $userID = $_SESSION['UserID'];
        $stmt = $connect->prepare("INSERT INTO attempts (UserID, Score) VALUES (?, ?)");
        $stmt->bind_param("ii", $userID, $score);
        $stmt->execute();
        $stmt->close();
    }
} else {
    $questionsQuery = mysqli_query($connect, "SELECT * FROM questions ORDER BY RAND() LIMIT 10");
    $questions = [];
    if ($questionsQuery) {
        while ($row = mysqli_fetch_assoc($questionsQuery)) {
            $questions[] = $row;
        }
    }
    $totalQuestions = count($questions);
    $totalPossibleScore = $totalQuestions * 10;
}
?>

<?php if ($quizSubmitted): ?>
    <?php 
        $accuracy = calculateAccuracy($score, $totalQuestions);
    ?>
    <section class="container py-5" id="results-section" data-aos="zoom-in">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 text-center p-4 rounded-4 mb-5">
                    <div class="card-body">
                        <h2 class="card-title fw-bold mt-3">Quiz Completed!</h2>
                        
                        <div class="p-3 bg-light rounded-3 my-4 border">
                            <span class="text-muted small text-uppercase fw-semibold">Your Rating</span>
                            <div class="my-2 fs-3">
                                <?php echo renderScoreStars($score, $totalPossibleScore); ?>
                            </div>
                            <h1 class="display-4 fw-bold text-primary mb-0"><?php echo $score; ?> <span class="fs-4 text-muted">/ <?php echo $totalPossibleScore; ?></span></h1>
                            <small class="text-muted">Accuracy Rate: <?php echo $accuracy; ?>%</small>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                            <a href="quiz.php" class="btn btn-primary btn-lg px-4"><i class="bi bi-arrow-counterclockwise me-1"></i> Try Again</a>
                            <a href="history.php" class="btn btn-outline-secondary btn-lg px-4"><i class="bi bi-clock-history me-1"></i> History</a>
                            <a href="leaderboard.php" class="btn btn-outline-primary btn-lg px-4"><i class="bi bi-trophy me-1"></i> Ranks</a>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold"><i class="bi bi-journal-check text-primary me-2"></i> Question Review</h3>
                </div>

                <?php foreach ($reviewData as $idx => $item): ?>
                    <div class="card shadow-sm border-0 rounded-4 mb-3 border-start border-4 <?php echo $item['isCorrect'] ? 'border-success' : 'border-danger'; ?>">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($item['question']); ?></h5>
                            <p class="mb-0">
                                <strong>Your Answer:</strong> 
                                <span class="<?php echo $item['isCorrect'] ? 'text-success' : 'text-danger'; ?>">
                                    <?php echo htmlspecialchars($item['userAnswer']); ?>
                                </span>
                            </p>
                            <?php if (!$item['isCorrect']): ?>
                                <p class="mb-0 text-success">
                                    <strong>Correct Answer:</strong> <?php echo htmlspecialchars($item['correctAnswer']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

<?php else: ?>
    <section class="container py-5" id="begin-quiz-section" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm rounded-4 p-5">
                    <div class="card-body">
                        <i class="bi bi-shuffle text-primary display-2"></i>
                        <h1 class="fw-bold mt-3">Ready for a Random Challenge?</h1>
                        <p class="text-secondary lead">10 random questions picked straight from our database.</p>
                        
                        <form action="quiz.php" method="POST">
                            <button type="button" class="btn btn-primary btn-lg px-5 py-3 shadow-sm rounded-pill fw-bold" id="start-btn">
                                <i class="bi bi-play-fill me-1"></i> Start Challenge
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5" id="quiz-form-section" style="display:none;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="quiz.php" method="POST">
                    <?php foreach ($questions as $index => $q): ?>
                        <div class="card shadow-sm border-0 rounded-4 mb-4 p-3">
                            <h5 class="fw-bold mb-3">Q<?php echo $index + 1; ?>. <?php echo htmlspecialchars($q['QuestionText']); ?></h5>
                            <?php 
                                $opts = [$q['Option1'], $q['Option2'], $q['Option3'], $q['Option4']];
                                foreach ($opts as $optVal): 
                            ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="answers[<?php echo $q['QuestionID']; ?>]" value="<?php echo htmlspecialchars($optVal); ?>" required>
                                    <label class="form-check-label"><?php echo htmlspecialchars($optVal); ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" name="btnSubmitQuiz" class="btn btn-success btn-lg px-5 shadow rounded-pill w-100">
                        Submit Answers <i class="bi bi-send-fill ms-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('start-btn').addEventListener('click', function() {
            document.getElementById('begin-quiz-section').style.display = 'none';
            document.getElementById('quiz-form-section').style.display = 'block';
        });
    </script>
<?php endif; ?>

<?php include('includes/footer.php'); ?>