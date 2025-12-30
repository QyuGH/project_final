<?php
require_once 'db_connect.php';

/**
 * CREATE FUNCTION FOR ADDING NEW REVIEWS
 */
function addReview($conn, $username, $rating, $review_message) {
    // Sanitize inputs
    $username = trim($username) !== '' ? trim($username) : 'Anonymous' . rand(1000, 9999);
    $rating = (int)$rating;
    $review_message = trim($review_message) !== '' ? trim($review_message) : 'Empty review message';

    $stmt = $conn->prepare("INSERT INTO reviews (username, rating, message) VALUES (?, ?, ?)");
    if (!$stmt) return 0; // failed to prepare

    $stmt->bind_param("sis", $username, $rating, $review_message);

    if ($stmt->execute()) {
        $stmt->close();
        return 1; // success
    } else {
        $stmt->close();
        return 0; // failure
    }
}

/**
 * RETRIEVE FUNCTION TO FETCH ALL REVIEWS FROM THE DATABASE
 */
function getReviews($conn) {
    $query = "
    SELECT r.*,
           COALESCE(SUM(CASE WHEN rr.reaction = 'like' THEN 1 ELSE 0 END), 0) AS likes_count,
           COALESCE(SUM(CASE WHEN rr.reaction = 'dislike' THEN 1 ELSE 0 END), 0) AS dislikes_count
    FROM reviews r
    LEFT JOIN review_reactions rr ON r.id = rr.review_id
    GROUP BY r.id
    ORDER BY r.created_at DESC
    ";

    $result = $conn->query($query);
    $reviews = [];

    if ($result && $result->num_rows > 0) {
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $reviews;
}
