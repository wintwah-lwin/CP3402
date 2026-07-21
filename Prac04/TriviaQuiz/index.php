<?php
session_start();
include('dbconnect.php');

// Fetch live platform statistics
$userRes = mysqli_query($connect, "SELECT COUNT(*) AS total FROM usertb");
$totalUsers = ($userRes) ? (mysqli_fetch_assoc($userRes)['total'] ?? 0) : 0;

$attemptRes = mysqli_query($connect, "SELECT COUNT(*) AS total FROM attempts");
$totalAttempts = ($attemptRes) ? (mysqli_fetch_assoc($attemptRes)['total'] ?? 0) : 0;

$topScoreRes = mysqli_query($connect, "SELECT MAX(Score) AS top_score FROM attempts");
$topScore = ($topScoreRes) ? (mysqli_fetch_assoc($topScoreRes)['top_score'] ?? 0) : 0;
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
    <!-- AOS Scroll Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Trivia Quiz - Home</title>
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
                    <li class="nav-item px-2"><a class="nav-link active" href="index.php"><i class="bi bi-house-door-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="quiz.php"><i class="bi bi-dpad-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="history.php"><i class="bi bi-clock-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="leaderboard.php"><i class="bi bi-trophy-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container py-5">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-7 text-center text-lg-start" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-3">Test Your Knowledge with <span class="text-primary">Trivia Quiz</span></h1>
                <p class="lead text-secondary mb-4">
                    Challenge yourself with engaging trivia questions. Compete on the leaderboard, track your personal progress, and aim for the top score!
                </p>
                
                <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start mb-4">
                    <?php if (isset($_SESSION['UserID'])): ?>
                        <a href="quiz.php" class="btn btn-primary btn-lg shadow-sm"><i class="bi bi-play-circle-fill"></i> Play Quiz Now</a>
                        <a href="leaderboard.php" class="btn btn-outline-secondary btn-lg"><i class="bi bi-trophy"></i> View Rankings</a>
                    <?php else: ?>
                        <a href="profile.php" class="btn btn-primary btn-lg shadow-sm"><i class="bi bi-person-plus-fill"></i> Join Now</a>
                        <a href="quiz.php" class="btn btn-outline-primary btn-lg"><i class="bi bi-dpad"></i> Try as Guest</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-5 text-center mt-4 mt-lg-0" data-aos="fade-left">
                <div class="p-5 bg-light rounded-4 shadow-sm border">
                    <i class="bi bi-question-circle-fill text-primary display-1"></i>
                    <h4 class="mt-3">Ready to Start?</h4>
                    <p class="text-muted small mb-0">Log in to save your progress and climb the leaderboard.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Live Statistics Counter -->
    <section class="bg-light py-5 border-top border-bottom">
        <div class="container" data-aos="fade-up">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 h-100">
                        <h2 class="text-primary fw-bold display-6 mb-1"><?php echo $totalUsers; ?></h2>
                        <p class="text-muted mb-0"><i class="bi bi-people-fill text-primary me-1"></i> Registered Players</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 h-100">
                        <h2 class="text-success fw-bold display-6 mb-1"><?php echo $totalAttempts; ?></h2>
                        <p class="text-muted mb-0"><i class="bi bi-controller text-success me-1"></i> Quizzes Played</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 h-100">
                        <h2 class="text-warning fw-bold display-6 mb-1"><?php echo $topScore; ?> pts</h2>
                        <p class="text-muted mb-0"><i class="bi bi-trophy-fill text-warning me-1"></i> Highest Score Achieved</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features / Highlights -->
    <section class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Why Play Trivia Quiz?</h2>
            <p class="text-muted">Simple, competitive, and dynamic features built right in.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 rounded-3 border h-100 bg-white shadow-sm">
                    <i class="bi bi-lightning-charge-fill text-warning display-5 mb-3"></i>
                    <h4>Fast & Dynamic</h4>
                    <p class="text-muted mb-0">Questions are loaded straight from the database for instant feedback and score calculations.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 rounded-3 border h-100 bg-white shadow-sm">
                    <i class="bi bi-bar-chart-line-fill text-success display-5 mb-3"></i>
                    <h4>Track Your Progress</h4>
                    <p class="text-muted mb-0">Log in to automatically record all your quiz runs and view detailed time-stamped history.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="p-4 rounded-3 border h-100 bg-white shadow-sm">
                    <i class="bi bi-award-fill text-primary display-5 mb-3"></i>
                    <h4>Climb the Leaderboard</h4>
                    <p class="text-muted mb-0">Compete against other registered players to earn the top spot on our live global board.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 text-center text-muted">
        <div class="container">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Trivia Quiz. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS & AOS Animations -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>