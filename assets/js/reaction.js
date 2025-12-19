// Reaction button handling for likes/dislikes on reviews
document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".like-btn");

    buttons.forEach(button => {
        button.addEventListener("click", async () => {
            const card = button.closest(".review-card-container");
            const reviewId = card.dataset.reviewId;
            const reactionType = button.dataset.type; 

            if (!reviewId || !reactionType) return;

            const oppositeType = reactionType === "like" ? "dislike" : "like";
            const oppositeButton = card.querySelector(`.like-btn[data-type="${oppositeType}"]`);

            try {
                const response = await fetch("connection/db_add_reaction.php", {
                  method: "POST",
                  headers: { "Content-Type": "application/json" },
                  body: JSON.stringify({
                    review_id: reviewId,
                    vote_type: reactionType,
                  }),
                });

                const data = await response.json();

                if (data.success) {
                    // Update review counts
                    const likeCountSpan = card.querySelector(".like-count");
                    const dislikeCountSpan = card.querySelector(".dislike-count");

                    if (likeCountSpan) likeCountSpan.textContent = data.likes;
                    if (dislikeCountSpan) dislikeCountSpan.textContent = data.dislikes;

                    // Change button states as a feedback
                    if (data.active_reaction === reactionType) {
                        button.classList.add("voted");
                        button.disabled = false;
                        if (oppositeButton) {
                            oppositeButton.classList.remove("voted");
                            oppositeButton.disabled = false;
                        }
                    } else {
                        button.classList.remove("voted");
                    }
                }
            } catch (error) {
                alert("Reaction failed.");
            }
        });
    });
});
