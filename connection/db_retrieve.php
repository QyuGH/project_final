<?php
// This file retrieves review messages along with their like and dislike counts

require_once 'db_connect.php';

// Fetch reviews and sorted from newest to oldest
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
$review_messages = [];

if ($result->num_rows > 0) {
    $review_messages = $result->fetch_all(MYSQLI_ASSOC);
}
