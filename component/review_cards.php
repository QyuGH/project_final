<?php

// Import database retrieval
require_once 'connection/db_retrieve.php';

?>

<!-- Render Review Cards -->
<?php foreach ($review_messages as $review): ?>
    <div class="review-card-container" data-review-id="<?= $review['id'] ?>">

        <div class="review-header">
            <div class="review-user">
                <div class="user-icon">
                    <img src="assets/images/icons/user.png" alt="User">
                </div>

                <div class="review-detail-container">
                    <h1 class="username">
                        <?php echo htmlspecialchars($review['username']); ?>
                    </h1>
                    <p class="date-submitted">
                        <?php echo date("F j, Y", strtotime($review['created_at'])); ?>
                    </p>
                </div>
            </div>

            <div class="review-stars">
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= (int) $review['rating']
                        ? '<i class="fa-solid fa-star"></i>'
                        : '<i class="fa-regular fa-star"></i>';
                }
                ?>
            </div>
        </div>

        <div class="message-rating-container">
            <p class="review-message">
                <?php echo nl2br(htmlspecialchars($review['message'])); ?>
            </p>
        </div>

        <div class="review-card-bottom">
            <!-- Likes / Dislikes -->
            <div class="like-icon-container">
                <div class="like-count-container">
                    <button class="like-btn" data-type="like">
                        <i class="fa-regular fa-thumbs-up"></i>
                    </button>
                    <span class="like-count"><?= $review['likes_count'] ?? 0 ?></span>
                </div>

                <div class="like-count-container">
                    <button class="like-btn" data-type="dislike">
                        <i class="fa-regular fa-thumbs-down"></i>
                    </button>
                    <span class="dislike-count"><?= $review['dislikes_count'] ?? 0 ?></span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-btn-container">
                <button class="action-btn" data-type="edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="action-btn" data-type="delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>