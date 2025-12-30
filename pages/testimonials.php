<?php

require_once __DIR__ . '/../connection/db_reviews.php';

$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $rating = $_POST['rating'] ?? 1;
    $review_message = $_POST['review_message'] ?? '';

    // Call function to insert review
    $success = addReview($conn, $username, $rating, $review_message);
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

    <p class="section-detail">Leave your own review</p>
    <button class="review-btn">Write a Review</button>

    <div class="review-form-container">
        <form method="post" action="" class="review-form">

            <div class="username-container">
                <label for="username" class="review-label">Username</label>
                <input type="text" name="username" id="username" class="review-input" autocomplete="name" />
            </div>

            <div class="star-container">
                <label class="review-label">Star Rating</label>
                <div class="star-rating">
                    <span class="star" data-value="1"><i class="fa-solid fa-star"></i></span>
                    <span class="star" data-value="2"><i class="fa-solid fa-star"></i></span>
                    <span class="star" data-value="3"><i class="fa-solid fa-star"></i></span>
                    <span class="star" data-value="4"><i class="fa-solid fa-star"></i></span>
                    <span class="star" data-value="5"><i class="fa-solid fa-star"></i></span>
                </div>
                <input type="hidden" name="rating" id="rating" value="0" required>
            </div>

            <div class="review-message-container">
                <label for="review_message" class="review-label">Message</label>
                <textarea name="review_message" id="review_message" class="review-text" maxlength="255"
                    required></textarea>
            </div>

            <div class="button-container">
                <button type="submit" class="review-submit-btn">Submit Review</button>
            </div>
        </form>
    </div>

    <!-- Importing Review Output Cards -->
    <div class="review-output-container">
        <!-- Review card results will be viewed here -->
      <?php include 'component/review_cards.php'; ?>
</div>

</section>

<!-- Modal Structure -->
<div class="modal-overlay">
    <div class="modal-container">
        <div class="modal-content">
            <div class="modal-status"></div>
            <h2 class="modal-title">Title</h2>
            <p class="modal-message">Message</p>
            <button class="modal-close-btn">Close</button>
        </div>
    </div>
</div>

<!-- Assets scripts for testimonial and reviews -->
<script src="assets/js/testimonialSlider.js"></script>
<script src="assets/js/reaction.js"></script>
<script src="assets/js/starRating.js"></script>
<script src="assets/js/reviewForm.js"></script>
<script src="assets/js/modal.js"></script>

<!-- Modal Script for Submission Feedback -->
<?php if ($success === 1): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // get the modal element
            const reviewModal = document.querySelector(".modal-overlay");

            showModal(
                reviewModal,
                "success",
                "Review Submitted!",
                "Thank you! Your review has been posted successfully."
            );

            // Reset form and stars
            const form = document.querySelector(".review-form");
            if (form) form.reset();

            const ratingInput = document.getElementById("rating");
            if (ratingInput) ratingInput.value = 0;

            const stars = document.querySelectorAll(".star-rating .star i");
            stars.forEach(star => star.classList.remove("star-filled"));
        });
    </script>
<?php elseif ($success === 0): ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const reviewModal = document.querySelector(".modal-overlay");

            showModal(
                reviewModal,
                "error",
                "Submission Failed",
                "Oops! Something went wrong. Please try submitting your review again."
            );
        });
    </script>
<?php endif; ?>