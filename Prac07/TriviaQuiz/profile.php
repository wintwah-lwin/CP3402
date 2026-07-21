<?php
include('includes/header.php');

/** @var mysqli $connect */

if(isset($_POST['btnRegister'])){
    $username = trim($_POST['txtusername']);
    $email = trim($_POST['txtemail']);
    $pass = $_POST['txtpassword'];
    $confirm = $_POST['txtconfirmpass'];

    if($pass === $confirm){
        $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
        
        $stmt = $connect->prepare("INSERT INTO usertb (Username, Password, Email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashedpass, $email);
        
        if($stmt->execute()){
            echo "<script>alert('Account successfully registered.'); window.location='profile.php';</script>";
        } else {
            echo "<script>alert('Registration error. Username or Email may already exist.'); window.location='profile.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Passwords do not match.'); window.location='profile.php';</script>";
    }
}

if(isset($_POST['btnLogin'])){
    $user_input = trim($_POST['txtuser']);
    $pass = $_POST['txtpassword'];

    $stmt = $connect->prepare("SELECT UserID, Username, Password, Email FROM usertb WHERE Username = ? OR Email = ?");
    $stmt->bind_param("ss", $user_input, $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if($row = $result->fetch_assoc()){
        if(password_verify($pass, $row['Password'])){
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
            $_SESSION['Email'] = $row['Email'];
            echo "<script>alert('Welcome back, " . htmlspecialchars($row['Username']) . "!'); window.location='profile.php';</script>";
        } else {
            echo "<script>alert('Incorrect password.'); window.location='profile.php';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location='profile.php';</script>";
    }
    $stmt->close();
}

if(isset($_GET['action']) && $_GET['action'] == 'logout'){
    session_destroy();
    echo "<script>window.location='profile.php';</script>";
    exit();
}

$totalPlayed = 0;
$highScore = 0;
$totalPoints = 0;

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    $statStmt = $connect->prepare("SELECT COUNT(*) AS total_played, MAX(Score) AS high_score, SUM(Score) AS total_points FROM attempts WHERE UserID = ?");
    $statStmt->bind_param("i", $userID);
    $statStmt->execute();
    $stats = $statStmt->get_result()->fetch_assoc();
    $statStmt->close();

    $totalPlayed = $stats['total_played'] ?? 0;
    $highScore = $stats['high_score'] ?? 0;
    $totalPoints = $stats['total_points'] ?? 0;
}
?>

<section class="container py-5" id="profile" data-aos="fade-up">
    <?php if (isset($_SESSION['UserID'])): ?>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="bi bi-person-circle display-1 text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-1"><?php echo htmlspecialchars($_SESSION['Username']); ?></h3>
                        <p class="text-muted small mb-4"><i class="bi bi-envelope me-1"></i> <?php echo htmlspecialchars($_SESSION['Email']); ?></p>
                        
                        <a href="profile.php?action=logout" class="btn btn-outline-danger w-100 rounded-pill">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout Account
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i> Career Performance</h4>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-sm-4">
                                <div class="card border-0 bg-light p-3 rounded-3 text-center">
                                    <h2 class="fw-bold text-primary mb-0"><?php echo $totalPlayed; ?></h2>
                                    <small class="text-muted">Quizzes Played</small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-0 bg-light p-3 rounded-3 text-center">
                                    <h2 class="fw-bold text-success mb-0"><?php echo $highScore; ?></h2>
                                    <small class="text-muted">Highest Score</small>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card border-0 bg-light p-3 rounded-3 text-center">
                                    <h2 class="fw-bold text-warning mb-0"><?php echo $totalPoints; ?></h2>
                                    <small class="text-muted">Total Points</small>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-primary text-white rounded-4 d-flex flex-column flex-sm-row align-items-center justify-content-between">
                            <div class="mb-3 mb-sm-0 text-center text-sm-start">
                                <h5 class="fw-bold mb-1">Ready for a new high score?</h5>
                                <p class="mb-0 small opacity-75">Challenge yourself and climb higher on the global leaderboard.</p>
                            </div>
                            <a href="quiz.php" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                                <i class="bi bi-play-fill me-1"></i> Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-md-5">
                        <ul class="nav nav-pills nav-justified mb-4" id="authTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active rounded-pill fw-bold" id="login-tab" data-bs-toggle="pill" data-bs-target="#login" type="button">Login</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link rounded-pill fw-bold" id="register-tab" data-bs-toggle="pill" data-bs-target="#register" type="button">Register</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="authTabContent">
                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                <h3 class="fw-bold mb-3"><i class="bi bi-box-arrow-in-right text-primary me-2"></i> Welcome Back</h3>
                                <form action="profile.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Username or Email</label>
                                        <input type="text" class="form-control rounded-3" name="txtuser" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold">Password</label>
                                        <input type="password" class="form-control rounded-3" name="txtpassword" required>
                                    </div>
                                    <button type="submit" name="btnLogin" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                        Login Account
                                    </button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="register" role="tabpanel">
                                <h3 class="fw-bold mb-3"><i class="bi bi-person-plus text-primary me-2"></i> Create Account</h3>
                                <form action="profile.php" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Username</label>
                                        <input type="text" class="form-control rounded-3" name="txtusername" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Email</label>
                                        <input type="email" class="form-control rounded-3" name="txtemail" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Password</label>
                                        <input type="password" class="form-control rounded-3" name="txtpassword" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold">Confirm Password</label>
                                        <input type="password" class="form-control rounded-3" name="txtconfirmpass" required>
                                    </div>
                                    <button type="submit" name="btnRegister" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                        Register Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php include('includes/footer.php'); ?>