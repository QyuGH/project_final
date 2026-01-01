<?php

require_once __DIR__ . '/../connection/db_reviews.php';
require_once __DIR__ . '/../component/modal.php';

session_start();

$success = "";
$isEditMode = false;
$editReview = null;

/**
 * POST SUBMISSION FOR CREATING A REVIEW
 */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = $_POST['rating'] ?? 1;
    $review_message = $_POST['review_message'] ?? '';

    // Check if the page is in edit or create review mode
    if (isset($_POST['review_id']) && is_numeric($_POST['review_id'])) {
        // Use update review function if in edit mode
        $reviewId = (int) $_POST['review_id'];
        $success = updateReview($conn, $reviewId, $rating, $review_message);
    } else {
        // Use add review function if in normal or create mode
        $username = $_POST['username'] ?? '';
        $success = addReview($conn, $username, $rating, $review_message);
    }
}

/**
 * HANDLE EDIT MODE
 */
if (
    isset($_GET['action'], $_GET['id']) &&
    $_GET['action'] === 'edit' &&
    is_numeric($_GET['id'])
) {
    $editReviewId = (int) $_GET['id'];

    // Retrieve review data using the get review function
    $editReview = getReviewById($conn, $editReviewId);

    if ($editReview) {
        $isEditMode = true;
    }
}

/**
 * HANDLE DELETE ACTION
 */
if (
    isset($_GET['action'], $_GET['id']) &&
    $_GET['action'] === 'delete' &&
    is_numeric($_GET['id'])
) {
    $reviewId = (int) $_GET['id'];

    // Assign a session based boolean flag to be used for modal
    if (deleteReview($conn, $reviewId)) {
        $_SESSION['delete_success'] = true;
    } else {
        $_SESSION['delete_success'] = false;
    }

    header("Location: ?page=testimonials");
    exit;
}

/**
 * FLAG SUCCESS DELETION
 */
$showDeleteSuccessModal = false;

if (isset($_SESSION['delete_success'])) {
    $showDeleteSuccessModal = $_SESSION['delete_success'];
    unset($_SESSION['delete_success']);
}


?>

<!-- Testimonial Section -->
<section id="testimonials" class="testimonials">
    <h1 class="section-heading">Testimonials</h1>
    <p class="section-detail">Reviews from my trusted clients</p>

    <div class="testimonial-slider">
        <div class="testimonial-track">
            <div class="testimonial-card">
                <div class="testimonial-image">
                    <img src="assets/images/profile/franz-hermmann.jpg" alt="Franz Hermmann" />
                </div>
                <div class="testimonial-content">
                    <h3 class="testimonial-name">Franz Hermmann</h3>
                    <p class="testimonial-text">
                        <em>"Lovely websites. You can really count on Anton for
                            developing your ideas into a complete websites. "</em>
                    </p>
                </div>
            </div>

            <div class="testimonial-card active">
                <div class="testimonial-image">
                    <img src="assets/images/profile/lh44.jpg" alt="Lewis Hamilton" />
                </div>
                <div class="testimonial-content">
                    <h3 class="testimonial-name">Lewis Hamilton</h3>
                    <p class="testimonial-text">
                        <em>"Working with Anton was an absolute pleasure. What
                            impressed me most was his ability to explain complex
                            technical concepts in simple terms."</em>
                    </p>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-image">
                    <img src="assets/images/profile/pfp-male2.jpg" alt="John Doe" />
                </div>
                <div class="testimonial-content">
                    <h3 class="testimonial-name">John Doe</h3>
                    <p class="testimonial-text">
                        <em>"Anton joined our small startup at a critical time and
                            completely turned things around. His problem-solving mindset
                            and calm attitude made a huge difference in keeping the
                            project on track."</em>
                    </p>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-image">
                    <img src="assets/images/profile/pfp-female.jpg" alt="Jane Doe" />
                </div>
                <div class="testimonial-content">
                    <h3 class="testimonial-name">Jane Doe</h3>
                    <p class="testimonial-text">
                        <em>"I had the chance to collaborate with Anton on a web
                            systems project. You can always count on him to suggest
                            better solutions or catch small issues before they become
                            real problems."</em>
                    </p>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-image">
                    <img src="assets/images/profile/pfp-male.jpg" alt="James Lawnly" />
                </div>
                <div class="testimonial-content">
                    <h3 class="testimonial-name">James Lawnly</h3>
                    <p class="testimonial-text">
                        <em>"Anton consistently demonstrates strong technical skills.
                            Highly recommend him as your web developer</em>
                    </p>
                </div>
            </div>
        </div>

        <!-- Dots indicator -->
        <div class="testimonial-dots">
            <div class="testimonial-dot active"></div>
            <div class="testimonial-dot"></div>
            <div class="testimonial-dot"></div>
            <div class="testimonial-dot"></div>
            <div class="testimonial-dot"></div>
        </div>
    </div>
</section>

<!-- Review Section -->
<section class="review">
    <h1 class="section-heading">Rating & Reviews</h1>
    <p class="section-detail">Read public comments from my followers</p>

    <p class="section-detail">
        <?= $isEditMode ? 'Edit your review' : 'Leave your own reviews' ?>
    </p>
    <!-- Dynamic button label to handle both edit and creation mode -->
    <?php if ($isEditMode): ?>
        <a href="?page=testimonials" class="review-btn">Cancel</a>
    <?php else: ?>
    <button class="review-btn">Write a Review</button>
    <?php endif; ?>


    <div class="review-form-container <?= $isEditMode ? 'active' : '' ?>">
        <form method="post" action="" class="review-form">

            <?php if ($isEditMode): ?>
                <!-- Hidden input to store review ID for update -->
                <input type="hidden" name="review_id" value="<?= $editReview['id'] ?>">
            <?php endif; ?>

            <div class="username-container">
                <label for="username" class="review-label">Username</label>
                <input type="text" name="username" id="username"
                    class="review-input <?= $isEditMode ? 'not-allowed' : '' ?>"
                    value="<?= $isEditMode ? htmlspecialchars($editReview['username']) : '' ?>" autocomplete="name"
                    <?= $isEditMode ? 'disabled' : '' ?> />
            </div>

            <div class="star-container">
                <label class="review-label">Star Rating</label>
                <div class="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star" data-value="<?= $i ?>">
                            <i class="fa-solid fa-star <?= ($isEditMode && $i <= $editReview['rating']) ? 'star-filled' : '' ?>"></i>
                        </span>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" id="rating" value="<?= $isEditMode ? $editReview['rating'] : 0 ?>" required>
            </div>

            <div class="review-message-container">
                <label for="review_message" class="review-label">Message</label>
                <textarea name="review_message" id="review_message" class="review-text" maxlength="255"
                    required><?= $isEditMode ? htmlspecialchars($editReview['message']) : '' ?></textarea>
            </div>

            <div class="button-container">
                <button type="submit" class="review-submit-btn">
                    <?= $isEditMode ? 'Submit Update' : 'Submit Review' ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Importing Review Output Cards -->
    <div class="review-output-container">
        <?php include 'component/review_cards.php'; ?>
        </div>
</section>

<!-- Assets scripts for testimonial and reviews -->
<script src="assets/js/testimonialSlider.js"></script>
<script src="assets/js/reaction.js"></script>
<script src="assets/js/starRating.js"></script>
<script src="assets/js/reviewForm.js"></script>
<script src="assets/js/deleteReview.js"></script>
<script src="assets/js/modal.js"></script>

<!-- Modal Script for Submission Feedback -->
<?php if ($success === 1): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const reviewModal = document.querySelector(".review-modal");

            <?php if ($isEditMode): ?>
                // Edit mode
                showModal(
                    reviewModal,
                    "success",
                    "Review Updated!",
                    "Your review has been updated successfully.",
                    "?page=testimonials"
                );
            <?php else: ?>
            // Create mode
                showModal(
                    reviewModal,
                    "success",
                    "Review Submitted!",
                    "Thank you! Your review has been posted successfully."
                );
            <?php endif; ?>
        });
    </script>
<?php elseif ($success === 0): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const reviewModal = document.getElementById("modal");

            <?php if ($isEditMode): ?>
                showModal(
                    reviewModal,
                    "error",
                    "Update Failed",
                    "Oops! Something went wrong while updating your review. Please try again."
                );
            <?php else: ?>
            showModal(
                reviewModal,
                "error",
                "Submission Failed",
                    "Oops! Something went wrong while submitting your review. Please try again."
                );
            <?php endif; ?>
        });
                    </script>
    <?php endif; ?>
    
    
    <!-- Modal Script for Success deletion feedback -->
    <?php if ($showDeleteSuccessModal): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.querySelector(".delete-modal");

            showModal(
                modal,
                "success",
                "Review Deleted",
                "The review has been deleted successfully.",
                "?page=testimonials"
            );
        });
    </script>
<?php endif; ?>