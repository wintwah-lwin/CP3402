<?php
session_start();
include('dbconnect.php');

$quizSubmitted = false;
$score = 0;
$reviewData = []; // Array to store detailed answer review

// Process Quiz Submission
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
                    $score += 10; // Award 10 points per correct answer
                }

                // Save question review details
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

    // Save attempt to database if logged in
    if (isset($_SESSION['UserID'])) {
        $userID = $_SESSION['UserID'];
        $stmt = $connect->prepare("INSERT INTO attempts (UserID, Score) VALUES (?, ?)");
        $stmt->bind_param("ii", $userID, $score);
        $stmt->execute();
        $stmt->close();
    }
} else {
    // Fetch 10 RANDOM questions from database for initial load
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Figtree Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- AOS Scroll Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Trivia Quiz - Play</title>
    <style>
        .option-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 14px 18px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
        }

        .option-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .btn-check:checked + .option-card {
            border-color: #0d6efd;
            background-color: #e7f1ff;
            font-weight: 600;
        }

        .btn-check:focus + .option-card {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm bg-white" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-lightbulb-fill"></i> Trivia Quiz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item px-2"><a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link active" href="quiz.php"><i class="bi bi-dpad-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="history.php"><i class="bi bi-clock-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="leaderboard.php"><i class="bi bi-trophy-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if ($quizSubmitted): ?>
        <?php 
            $percentage = ($totalPossibleScore > 0) ? round(($score / $totalPossibleScore) * 100) : 0;
            $badgeColor = ($percentage >= 80) ? 'success' : (($percentage >= 50) ? 'warning' : 'danger');
            $badgeText = ($percentage >= 80) ? 'Outstanding!' : (($percentage >= 50) ? 'Good Effort!' : 'Keep Practicing!');
            $correctCount = $score / 10;
        ?>
        <!-- Quiz Results & Review Section -->
        <section class="container py-5" id="results-section" data-aos="zoom-in">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Score Summary Card -->
                    <div class="card shadow border-0 text-center p-4 rounded-4 mb-5">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="badge bg-<?php echo $badgeColor; ?> fs-6 px-3 py-2 rounded-pill"><?php echo $badgeText; ?></span>
                            </div>
                            <i class="bi bi-trophy-fill text-warning display-1"></i>
                            <h2 class="card-title fw-bold mt-3">Quiz Completed!</h2>
                            
                            <div class="p-3 bg-light rounded-3 my-4 border">
                                <span class="text-muted small text-uppercase fw-semibold">Your Final Score</span>
                                <h1 class="display-4 fw-bold text-primary mb-0"><?php echo $score; ?> <span class="fs-4 text-muted">/ <?php echo $totalPossibleScore; ?></span></h1>
                                <small class="text-muted"><?php echo $percentage; ?>% Accuracy (<?php echo $correctCount; ?> of <?php echo $totalQuestions; ?> Correct)</small>
                            </div>
                            
                            <?php if (!isset($_SESSION['UserID'])): ?>
                                <div class="alert alert-warning my-3 text-start border-0 shadow-sm" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Playing as guest. <a href="profile.php" class="alert-link">Log in</a> to save your scores to the leaderboard!
                                </div>
                            <?php else: ?>
                                <div class="alert alert-success my-3 text-start border-0 shadow-sm" role="alert">
                                    <i class="bi bi-check-circle-fill me-1"></i> Score saved to your account!
                                </div>
                            <?php endif; ?>

                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                                <a href="quiz.php" class="btn btn-primary btn-lg px-4"><i class="bi bi-arrow-counterclockwise me-1"></i> Try Again</a>
                                <a href="history.php" class="btn btn-outline-secondary btn-lg px-4"><i class="bi bi-clock-history me-1"></i> History</a>
                                <a href="leaderboard.php" class="btn btn-outline-primary btn-lg px-4"><i class="bi bi-trophy me-1"></i> Ranks</a>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Answers Review -->
                    <div class="mb-4">
                        <h3 class="fw-bold"><i class="bi bi-journal-check text-primary me-2"></i> Question Review</h3>
                        <p class="text-muted">Review your answers and see where you got things right or wrong.</p>
                    </div>

                    <?php foreach ($reviewData as $idx => $item): ?>
                        <div class="card shadow-sm border-0 rounded-4 mb-3 border-start border-4 <?php echo $item['isCorrect'] ? 'border-success' : 'border-danger'; ?>">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark border mb-2 px-3 py-1 rounded-pill fw-semibold">
                                        Question <?php echo $idx + 1; ?>
                                    </span>
                                    <?php if ($item['isCorrect']): ?>
                                        <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> Correct (+10 pts)
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-1">
                                            <i class="bi bi-x-circle-fill me-1"></i> Incorrect
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <h5 class="fw-bold mb-3"><?php echo htmlspecialchars($item['question']); ?></h5>

                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="p-3 rounded-3 <?php echo $item['isCorrect'] ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>">
                                            <small class="fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Your Answer:</small>
                                            <i class="bi <?php echo $item['isCorrect'] ? 'bi-check-lg' : 'bi-x-lg'; ?> me-2"></i>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($item['userAnswer']); ?></span>
                                        </div>
                                    </div>

                                    <?php if (!$item['isCorrect']): ?>
                                        <div class="col-12">
                                            <div class="p-3 rounded-3 bg-success-subtle text-success">
                                                <small class="fw-bold d-block text-uppercase mb-1" style="font-size: 0.75rem;">Correct Answer:</small>
                                                <i class="bi bi-check-lg me-2"></i>
                                                <span class="fw-semibold"><?php echo htmlspecialchars($item['correctAnswer']); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="text-center mt-4">
                        <a href="quiz.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Take Another Quiz
                        </a>
                    </div>
                </div>
            </div>
        </section>

    <?php else: ?>
        <!-- Welcome Screen -->
        <section class="container py-5" id="begin-quiz-section" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <div class="card-body">
                            <i class="bi bi-shuffle text-primary display-2"></i>
                            <h1 class="fw-bold mt-3">Ready for a Random Challenge?</h1>
                            <p class="text-secondary lead">10 random questions picked straight from our database. Answer them one by one to earn points.</p>
                            
                            <div class="d-flex justify-content-center gap-4 my-4">
                                <div class="text-center">
                                    <i class="bi bi-question-circle text-primary fs-3"></i>
                                    <p class="mb-0 small text-muted"><strong><?php echo $totalQuestions; ?></strong> Random Questions</p>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-star text-warning fs-3"></i>
                                    <p class="mb-0 small text-muted"><strong><?php echo $totalPossibleScore; ?></strong> Points Total</p>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary btn-lg px-5 py-3 shadow-sm rounded-pill fw-bold" id="begin-btn">
                                <i class="bi bi-play-fill me-1"></i> Start Challenge
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic Step-by-Step Questions Form -->
        <section class="container py-5" id="quiz" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Progress Bar Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="back-btn">
                            <i class="bi bi-arrow-left"></i> Exit Quiz
                        </button>
                        <span id="progress-text" class="fw-bold text-primary">Question 1 of <?php echo $totalQuestions; ?></span>
                    </div>

                    <div class="progress mb-4" style="height: 10px;">
                        <div id="quiz-progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%;"></div>
                    </div>

                    <?php if (empty($questions)): ?>
                        <div class="alert alert-danger border-0 shadow-sm">No questions found in the database. Please run the SQL setup script in phpMyAdmin.</div>
                    <?php else: ?>
                        <form action="quiz.php" method="POST" id="quizForm">
                            <?php foreach ($questions as $index => $q): ?>
                                <div class="question-step" id="step-<?php echo $index; ?>" style="<?php echo ($index > 0) ? 'display: none;' : ''; ?>">
                                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                                        <div class="card-body p-4">
                                            <span class="badge bg-light text-primary border border-primary mb-3 px-3 py-2 rounded-pill fw-bold">
                                                Question <?php echo $index + 1; ?>
                                            </span>
                                            <h5 class="fw-bold mb-4"><?php echo htmlspecialchars($q['QuestionText']); ?></h5>
                                            
                                            <div class="row g-3">
                                                <?php 
                                                    $options = [
                                                        'opt1' => $q['Option1'],
                                                        'opt2' => $q['Option2'],
                                                        'opt3' => $q['Option3'],
                                                        'opt4' => $q['Option4']
                                                    ];
                                                    foreach ($options as $optKey => $optVal): 
                                                        $inputID = "q" . $q['QuestionID'] . "_" . $optKey;
                                                ?>
                                                    <div class="col-12">
                                                        <input type="radio" class="btn-check" name="answers[<?php echo $q['QuestionID']; ?>]" id="<?php echo $inputID; ?>" value="<?php echo htmlspecialchars($optVal); ?>">
                                                        <label class="option-card w-100" for="<?php echo $inputID; ?>">
                                                            <i class="bi bi-circle text-muted me-3"></i>
                                                            <span><?php echo htmlspecialchars($optVal); ?></span>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Navigation Action Controls -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" class="btn btn-outline-secondary btn-lg px-4 rounded-pill" id="prev-btn" style="display: none;">
                                    <i class="bi bi-chevron-left me-1"></i> Previous
                                </button>
                                
                                <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill ms-auto" id="next-btn">
                                    Next <i class="bi bi-chevron-right ms-1"></i>
                                </button>
                                
                                <button type="submit" name="btnSubmitQuiz" class="btn btn-success btn-lg px-5 shadow rounded-pill ms-auto" id="submit-btn" style="display: none;">
                                    Submit Answers <i class="bi bi-send-fill ms-2"></i>
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Bootstrap JS & AOS Animations -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();

        const beginBtn = document.getElementById('begin-btn');
        const backBtn = document.getElementById('back-btn');
        const steps = document.querySelectorAll('.question-step');
        const totalSteps = steps.length;
        let currentStep = 0;

        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');
        const progressBar = document.getElementById('quiz-progress-bar');
        const progressText = document.getElementById('progress-text');

        function updateStepView() {
            steps.forEach((step, index) => {
                step.style.display = (index === currentStep) ? 'block' : 'none';
            });

            // Update Progress Bar & Counter
            const progressPercent = ((currentStep + 1) / totalSteps) * 100;
            if (progressBar) progressBar.style.width = progressPercent + '%';
            if (progressText) progressText.innerText = `Question ${currentStep + 1} of ${totalSteps}`;

            // Button Visibility Controls
            if (prevBtn) prevBtn.style.display = (currentStep === 0) ? 'none' : 'inline-block';
            
            if (currentStep === totalSteps - 1) {
                if (nextBtn) nextBtn.style.display = 'none';
                if (submitBtn) submitBtn.style.display = 'inline-block';
            } else {
                if (nextBtn) nextBtn.style.display = 'inline-block';
                if (submitBtn) submitBtn.style.display = 'none';
            }
        }

        if (beginBtn) {
            beginBtn.addEventListener('click', function() {
                document.getElementById('begin-quiz-section').style.display = 'none';
                document.getElementById('quiz').style.display = 'block';
                currentStep = 0;
                updateStepView();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        if (backBtn) {
            backBtn.addEventListener('click', function() {
                document.getElementById('quiz').style.display = 'none';
                document.getElementById('begin-quiz-section').style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                // Ensure the user picks an option before proceeding
                const currentInputs = steps[currentStep].querySelectorAll('input[type="radio"]');
                const isSelected = Array.from(currentInputs).some(input => input.checked);

                if (!isSelected) {
                    alert('Please select an answer before moving to the next question!');
                    return;
                }

                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateStepView();
                }
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateStepView();
                }
            });
        }

        if (submitBtn) {
            document.getElementById('quizForm').addEventListener('submit', function(e) {
                const currentInputs = steps[currentStep].querySelectorAll('input[type="radio"]');
                const isSelected = Array.from(currentInputs).some(input => input.checked);

                if (!isSelected) {
                    e.preventDefault();
                    alert('Please select an answer for the final question!');
                }
            });
        }
    </script>
</body>
</html>