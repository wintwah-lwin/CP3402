<?php
include('includes/header.php');

/** @var mysqli $connect */

$userRes = mysqli_query($connect, "SELECT COUNT(*) AS total FROM usertb");
$totalUsers = ($userRes) ? (mysqli_fetch_assoc($userRes)['total'] ?? 0) : 0;

$attemptRes = mysqli_query($connect, "SELECT COUNT(*) AS total FROM attempts");
$totalAttempts = ($attemptRes) ? (mysqli_fetch_assoc($attemptRes)['total'] ?? 0) : 0;

$topScoreRes = mysqli_query($connect, "SELECT MAX(Score) AS top_score FROM attempts");
$topScore = ($topScoreRes) ? (mysqli_fetch_assoc($topScoreRes)['top_score'] ?? 0) : 0;

$features = [
    ["icon" => "bi-lightning-charge-fill", "color" => "text-warning", "title" => "Fast & Dynamic", "desc" => "Questions load instantly from the database."],
    ["icon" => "bi-bar-chart-line-fill", "color" => "text-success", "title" => "Track Progress", "desc" => "Log in to record your scores and history."],
    ["icon" => "bi-award-fill", "color" => "text-primary", "title" => "Global Leaderboard", "desc" => "Compete against players globally."]
];
?>

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

<section class="container py-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold">Why Play Trivia Quiz?</h2>
        <p class="text-muted">Simple, competitive, and dynamic features built right in.</p>
    </div>
    <div class="row g-4 text-center">
        <?php foreach ($features as $f): ?>
            <div class="col-md-4" data-aos="fade-up">
                <div class="p-4 rounded-3 border h-100 bg-white shadow-sm">
                    <i class="bi <?php echo $f['icon'] . ' ' . $f['color']; ?> display-5 mb-3"></i>
                    <h4><?php echo $f['title']; ?></h4>
                    <p class="text-muted mb-0"><?php echo $f['desc']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php 
include('includes/footer.php'); 
?>