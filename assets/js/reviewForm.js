// Script for opening review form
document.addEventListener("DOMContentLoaded", () => {
  const reviewBtn = document.querySelector(".review-btn");
  const reviewFormContainer = document.querySelector(".review-form-container");

  reviewBtn.addEventListener("click", () => {
    reviewFormContainer.classList.toggle("active");
    if (reviewFormContainer.classList.contains("active")) {
      reviewBtn.textContent = "Close";
    } else {
      reviewBtn.textContent = "Write a Review";
    }
  });
});