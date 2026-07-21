<?php
include('includes/header.php');

/** @var mysqli $connect */

$isLoggedIn = isset($_SESSION['UserID']);
$attempts = [];
$bestScore = 0;

if ($isLoggedIn) {
    $userID = $_SESSION['UserID'];
    $stmt = $connect->prepare("SELECT Score, DatePlayed FROM attempts WHERE UserID = ? ORDER BY DatePlayed DESC");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $attempts[] = $row;
        if ($row['Score'] > $bestScore) {
            $bestScore = $row['Score'];
        }
    }
    $stmt->close();
}
$totalAttempts = count($attempts);
?>

<section class="container py-5" id="history">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4" data-aos="fade-down">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-clock-history text-primary me-2"></i> Quiz Attempts History</h2>
            <p class="text-muted mb-0">Track all your previous quiz runs and personal performance logs.</p>
        </div>
        <?php if ($isLoggedIn && $totalAttempts > 0): ?>
            <a href="quiz.php" class="btn btn-primary rounded-pill mt-3 mt-md-0 shadow-sm">
                <i class="bi bi-play-fill"></i> Take Another Quiz
            </a>
        <?php endif; ?>
    </div>

    <?php if (!$isLoggedIn): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4" data-aos="zoom-in">
            <div class="card-body">
                <i class="bi bi-shield-lock-fill text-warning display-2 mb-3"></i>
                <h3 class="fw-bold">Login Required</h3>
                <p class="text-muted lead max-w-md mx-auto">Please log in or register an account to view and save your quiz attempt history.</p>
                <a href="profile.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm mt-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Go to Login / Register
                </a>
            </div>
        </div>

    <?php elseif ($totalAttempts === 0): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4" data-aos="zoom-in">
            <div class="card-body">
                <i class="bi bi-journal-x text-muted display-2 mb-3"></i>
                <h3 class="fw-bold">No History Found</h3>
                <p class="text-muted">You haven't played any quizzes yet. Test your knowledge now!</p>
                <a href="quiz.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm mt-2">
                    <i class="bi bi-controller me-1"></i> Start Your First Quiz
                </a>
            </div>
        </div>

    <?php else: ?>
        <div class="row g-3 mb-4" data-aos="fade-up">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-light">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary text-white rounded-3 me-3">
                            <i class="bi bi-controller fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0"><?php echo $totalAttempts; ?></h4>
                            <small class="text-muted">Total Quizzes Attempted</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-light">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-success text-white rounded-3 me-3">
                            <i class="bi bi-star-fill fs-3"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0"><?php echo $bestScore; ?> pts</h4>
                            <small class="text-muted">Personal High Score</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">#</th>
                            <th scope="col">Date Played</th>
                            <th scope="col">Score Earned</th>
                            <th scope="col">Rating</th>
                            <th scope="col" class="text-end pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attempts as $index => $attempt): ?>
                            <tr>
                                <th scope="row" class="ps-4 text-muted"><?php echo $totalAttempts - $index; ?></th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-event text-primary me-2"></i>
                                        <span><?php echo date("F j, Y, g:i a", strtotime($attempt['DatePlayed'])); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">
                                        <?php echo $attempt['Score']; ?> pts
                                    </span>
                                </td>
                                <td>
                                    <?php echo renderScoreStars($attempt['Score'], 100); ?>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-light text-success border border-success rounded-pill px-3 py-1">
                                        <i class="bi bi-check-circle-fill me-1"></i> Recorded
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php include('includes/footer.php'); ?>