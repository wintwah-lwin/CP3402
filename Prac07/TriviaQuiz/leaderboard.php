<?php
include('includes/header.php');

/** @var mysqli $connect */

$query = "SELECT u.UserID, u.Username, MAX(a.Score) AS HighestScore 
          FROM attempts a 
          JOIN usertb u ON a.UserID = u.UserID 
          GROUP BY u.UserID, u.Username 
          ORDER BY HighestScore DESC 
          LIMIT 10";

$result = mysqli_query($connect, $query);
$leaderboard = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $leaderboard[] = $row;
    }
}
?>

<section class="container py-5" id="leaderboard">
    <div class="text-center mb-5" data-aos="fade-down">
        <h2 class="fw-bold mb-2"><i class="bi bi-trophy-fill text-warning me-2"></i> Global Leaderboard</h2>
        <p class="text-muted">Celebrating our highest-scoring trivia champions.</p>
    </div>

    <?php if (empty($leaderboard)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center p-5 my-4" data-aos="zoom-in">
            <div class="card-body">
                <i class="bi bi-trophy text-muted display-2 mb-3"></i>
                <h3 class="fw-bold">No Rankings Yet</h3>
                <p class="text-muted">Be the first player to complete a quiz and claim the #1 spot!</p>
                <a href="quiz.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm mt-2">
                    <i class="bi bi-controller me-1"></i> Play Quiz Now
                </a>
            </div>
        </div>

    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Rank</th>
                            <th scope="col">Player Username</th>
                            <th scope="col">Badge</th>
                            <th scope="col" class="text-end pe-4">Highest Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaderboard as $index => $row): ?>
                            <?php $rank = $index + 1; ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?php echo $rank; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary-subtle text-primary fw-bold rounded-circle p-2 me-2 text-center" style="width: 38px; height: 38px;">
                                            <?php echo strtoupper(substr($row['Username'], 0, 1)); ?>
                                        </div>
                                        <span class="fw-semibold"><?php echo htmlspecialchars($row['Username']); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php echo getRankBadge($rank); ?>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">
                                        <?php echo $row['HighestScore']; ?> pts
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