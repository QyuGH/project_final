// Functionality for sidebar burger menu icon
const burger = document.querySelector(".burger-menu");
const closeBtn = document.querySelector(".close-menu");
const navWrapper = document.querySelector(".nav-wrapper");
const overlay = document.querySelector(".overlay");

function openSidebar() {
  navWrapper.classList.add("nav-open");
  overlay.classList.add("active");
}

function closeSidebar() {
  navWrapper.classList.remove("nav-open");
  overlay.classList.remove("active");
}

burger.addEventListener("click", openSidebar);
closeBtn.addEventListener("click", closeSidebar);
overlay.addEventListener("click", closeSidebar);

// Star Rating Handler with Validation
  document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll(".star-rating .star i");
    const ratingInput = document.getElementById("rating");
    const starContainer = document.querySelector(".star-rating");
    const form = document.querySelector(".review-form");

    let currentRating = Number(ratingInput?.value || 0);

    /* Render stars */
    function renderStars(hoverIndex = null) {
      stars.forEach((star, index) => {
        star.classList.remove("star-filled", "star-empty", "star-hover");

        if (hoverIndex !== null) {
          if (index <= hoverIndex) {
            star.classList.add("star-filled", "star-hover");
          } else {
            star.classList.add("star-empty");
          }
        } else {
          if (index < currentRating) {
            star.classList.add("star-filled");
          } else {
            star.classList.add("star-empty");
          }
        }
      });
    }

    /* Initial render */
    renderStars();

    /* Hover and Click logic of Star Icon */
    stars.forEach((star, index) => {
      star.addEventListener("mouseenter", () => {
        renderStars(index);
      });

      star.addEventListener("mouseleave", () => {
        renderStars();
      });

      star.addEventListener("click", () => {
        currentRating = index + 1;
        ratingInput.value = currentRating;

        /* Clear validation error on valid selection */
        starContainer.classList.remove("rating-error");

        renderStars();
      });
    });

    /* Form submit validation */
    form.addEventListener("submit", (e) => {
    if (currentRating <= 0) {
      e.preventDefault();

      /* Shake animation for every invalid submission */
      starContainer.classList.remove("rating-error");
      
      /* Rerender star icon and trigger animation */
      renderStars();
      void starContainer.offsetWidth;

      starContainer.classList.add("rating-error");

      starContainer.scrollIntoView({
        behavior: "smooth",
        block: "center",
      });
    }
  });
});

