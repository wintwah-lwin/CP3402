<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../dbconnect.php';
require_once __DIR__ . '/../functions.php';

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Trivia Quiz</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top shadow-sm bg-white" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-lightbulb-fill text-primary"></i> Trivia Quiz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item px-2"><a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a></li>
                    <li class="nav-item px-2"><a class="nav-link <?php echo ($currentPage == 'quiz.php') ? 'active' : ''; ?>" href="quiz.php"><i class="bi bi-dpad-fill"></i> Play</a></li>
                    <li class="nav-item px-2"><a class="nav-link <?php echo ($currentPage == 'history.php') ? 'active' : ''; ?>" href="history.php"><i class="bi bi-clock-fill"></i> History</a></li>
                    <li class="nav-item px-2"><a class="nav-link <?php echo ($currentPage == 'leaderboard.php') ? 'active' : ''; ?>" href="leaderboard.php"><i class="bi bi-trophy-fill"></i> Ranks</a></li>
                    <li class="nav-item px-2"><a class="nav-link <?php echo ($currentPage == 'profile.php') ? 'active' : ''; ?>" href="profile.php"><i class="bi bi-person-circle"></i> Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main></main>