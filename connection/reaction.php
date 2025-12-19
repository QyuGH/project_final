<?php
// This file handles like/dislike reactions for reviews

session_start();
header('Content-Type: application/json');

require_once 'db_connect.php';

// Read JSON POST data
$input = json_decode(file_get_contents('php://input'), true);
$review_id = isset($input['review_id']) ? (int)$input['review_id'] : 0;
$vote_type = isset($input['vote_type']) ? $input['vote_type'] : '';

if (!$review_id || !in_array($vote_type, ['like', 'dislike'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Using session ID to identify user without login features
$userSession = session_id();

// Check if the user already has a reaction for this review
$stmt = $conn->prepare("
    SELECT reaction 
    FROM review_reactions 
    WHERE review_id = ? AND user_session = ?
");
$stmt->bind_param("is", $review_id, $userSession);
$stmt->execute();
$stmt->bind_result($previousReaction);
$stmt->fetch();
$stmt->close();

// Toggle logic of the reaction icons
if ($previousReaction === $vote_type) {
    // Removing reaction count if the same reaction is clicked again
    $stmt = $conn->prepare("
        DELETE FROM review_reactions
        WHERE review_id = ? AND reaction = ? AND user_session = ?
    ");
    $stmt->bind_param("iss", $review_id, $vote_type, $userSession);
    $stmt->execute();
    $stmt->close();

    $activeReaction = null;

} else {
    // Removing previous reaction that exists before adding new one
    if ($previousReaction) {
        $stmt = $conn->prepare("
            DELETE FROM review_reactions
            WHERE review_id = ? AND reaction = ? AND user_session = ?
        ");
        $stmt->bind_param("iss", $review_id, $previousReaction, $userSession);
        $stmt->execute();
        $stmt->close();
    }

    // Inserting new reaction
    $stmt = $conn->prepare("
        INSERT INTO review_reactions (review_id, reaction, user_session, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("iss", $review_id, $vote_type, $userSession);
    $stmt->execute();
    $stmt->close();

    $activeReaction = $vote_type;
}

// Fetch updated reaction counts for this review
$stmt = $conn->prepare("
    SELECT 
        COALESCE(SUM(CASE WHEN reaction='like' THEN 1 ELSE 0 END), 0) AS likes_count,
        COALESCE(SUM(CASE WHEN reaction='dislike' THEN 1 ELSE 0 END), 0) AS dislikes_count
    FROM review_reactions
    WHERE review_id = ?
");
$stmt->bind_param("i", $review_id);
$stmt->execute();
$stmt->bind_result($likes_count, $dislikes_count);
$stmt->fetch();
$stmt->close();

// Return JSON response
echo json_encode([
    'success' => true,
    'likes' => $likes_count,
    'dislikes' => $dislikes_count,
    'active_reaction' => $activeReaction
]);
