<?php
function renderScoreStars($score, $maxScore = 100) {
    $percentage = ($maxScore > 0) ? ($score / $maxScore) * 100 : 0;
    $starCount = (int)round(($percentage / 100) * 5);

    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $starCount) {
            $stars .= '<i class="bi bi-star-fill text-warning"></i> ';
        } else {
            $stars .= '<i class="bi bi-star text-muted"></i> ';
        }
    }
    return $stars;
}

function getRankBadge($rank) {
    if ($rank === 1) {
        return '<span class="badge bg-warning text-dark"><i class="bi bi-trophy-fill me-1"></i> Champion #1</span>';
    } elseif ($rank === 2) {
        return '<span class="badge bg-secondary">2nd Place</span>';
    } elseif ($rank === 3) {
        return '<span class="badge text-white" style="background-color: #cd7f32;">3rd Place</span>';
    } else {
        return '<span class="badge bg-light text-dark border">Rank #' . $rank . '</span>';
    }
}

function calculateAccuracy($score, $totalQuestions) {
    $maxPossible = $totalQuestions * 10;
    if ($maxPossible <= 0) return 0;
    return round(($score / $maxPossible) * 100);
}
?>