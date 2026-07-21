<?php
session_start();
include('dbconnect.php');

// Fetch top 10 players ordered by highest score
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
    <title>Trivia Quiz - Leaderboard</title>
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
                    <li class="nav-item px-2"><a class="nav-link" href="quiz.php"><i class="bi bi-dpad-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="history.php"><i class="bi bi-clock-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link active" href="leaderboard.php"><i class="bi bi-trophy-fill"></i></a></li>
                    <li class="nav-item px-2"><a class="nav-link" href="profile.php"><i class="bi bi-person-circle"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="container py-5" id="leaderboard">
        <!-- Header -->
        <div class="text-center mb-5" data-aos="fade-down">
            <h2 class="fw-bold mb-2"><i class="bi bi-trophy-fill text-warning me-2"></i> Global Leaderboard</h2>
            <p class="text-muted">Celebrating our highest-scoring trivia champions.</p>
        </div>

        <?php if (empty($leaderboard)): ?>
            <!-- Empty State -->
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
            <!-- Podium Top 3 Highlights -->
            <?php if (count($leaderboard) >= 1): ?>
                <div class="row g-3 justify-content-center mb-5" data-aos="fade-up">
                    <!-- Rank 2 -->
                    <?php if (isset($leaderboard[1])): ?>
                        <div class="col-md-4 order-2 order-md-1">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 bg-light">
                                <i class="bi bi-award-fill text-secondary display-4 mb-2"></i>
                                <span class="badge bg-secondary rounded-pill w-auto mx-auto mb-2 px-3 py-1">2nd Place</span>
                                <h4 class="fw-bold"><?php echo htmlspecialchars($leaderboard[1]['Username']); ?></h4>
                                <p class="text-primary fw-bold mb-0"><?php echo $leaderboard[1]['HighestScore']; ?> pts</p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Rank 1 -->
                    <div class="col-md-4 order-1 order-md-2">
                        <div class="card border-2 border-warning shadow rounded-4 text-center p-4 h-100 bg-white">
                            <i class="bi bi-trophy-fill text-warning display-3 mb-2"></i>
                            <span class="badge bg-warning text-dark rounded-pill w-auto mx-auto mb-2 px-3 py-1 fw-bold">Champion #1</span>
                            <h3 class="fw-bold"><?php echo htmlspecialchars($leaderboard[0]['Username']); ?></h3>
                            <h4 class="text-success fw-bold mb-0"><?php echo $leaderboard[0]['HighestScore']; ?> pts</h4>
                        </div>
                    </div>

                    <!-- Rank 3 -->
                    <?php if (isset($leaderboard[2])): ?>
                        <div class="col-md-4 order-3 order-md-3">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100 bg-light">
                                <i class="bi bi-award-fill display-4 mb-2" style="color: #cd7f32;"></i>
                                <span class="badge rounded-pill w-auto mx-auto mb-2 px-3 py-1 text-white" style="background-color: #cd7f32;">3rd Place</span>
                                <h4 class="fw-bold"><?php echo htmlspecialchars($leaderboard[2]['Username']); ?></h4>
                                <p class="text-primary fw-bold mb-0"><?php echo $leaderboard[2]['HighestScore']; ?> pts</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Complete Rankings Table -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" data-aos="fade-up">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Rank</th>
                                <th scope="col">Player Username</th>
                                <th scope="col" class="text-end pe-4">Highest Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaderboard as $index => $row): ?>
                                <?php $rank = $index + 1; ?>
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        <?php if ($rank === 1): ?>
                                            <i class="bi bi-trophy-fill text-warning fs-5 me-2"></i> #1
                                        <?php elseif ($rank === 2): ?>
                                            <i class="bi bi-award-fill text-secondary fs-5 me-2"></i> #2
                                        <?php elseif ($rank === 3): ?>
                                            <i class="bi bi-award-fill fs-5 me-2" style="color: #cd7f32;"></i> #3
                                        <?php else: ?>
                                            <span class="text-muted ms-1">#<?php echo $rank; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary-subtle text-primary fw-bold rounded-circle p-2 me-2 text-center" style="width: 38px; height: 38px;">
                                                <?php echo strtoupper(substr($row['Username'], 0, 1)); ?>
                                            </div>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($row['Username']); ?></span>
                                        </div>
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

    <!-- Bootstrap JS & AOS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>