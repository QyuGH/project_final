// Testimonial Slider Animation and Functionality
const testimonialCards = document.querySelectorAll(".testimonial-card");
const testimonialDots = document.querySelectorAll(".testimonial-dot");
const sliderContainer = document.querySelector(".testimonial-slider");
const testimonialTrack = document.querySelector(".testimonial-track");

let currentIndex = 1;
let previousIndex = 1;
const totalCards = testimonialCards.length;

let autoPlayInterval;
let isAutoPlaying = true;

// Reset all cards to default state
function resetAllCards() {
  testimonialCards.forEach((card) => {
    card.className = "testimonial-card";
    card.style.transform = "";
    card.style.opacity = "";
    card.style.zIndex = "";
    card.style.left = "";
    card.style.position = "absolute";
  });
}

// Update slider for mobile or desktop
function updateSlider() {
  const isMobile = window.innerWidth <= 768;
  if (isMobile) updateMobileSlider();
  else updateDesktopSlider();
  updateDots();
}

// Mobile slider behavior
function updateMobileSlider() {
  const direction = currentIndex > previousIndex ? "next" : "prev";

  testimonialCards.forEach((card, index) => {
    card.classList.remove(
      "mobile-active",
      "slide-in-left",
      "slide-in-right",
      "slide-out-left",
      "slide-out-right"
    );

    card.style.transform = "";
    card.style.position = "absolute";
    card.style.left = "50%";

    if (index === currentIndex) {
      card.classList.add("mobile-active");
      card.style.opacity = "1";
      card.style.zIndex = "10";
      card.classList.add(
        direction === "next" ? "slide-in-right" : "slide-in-left"
      );
    } else if (index === previousIndex) {
      card.style.zIndex = "5";
      card.classList.add(
        direction === "next" ? "slide-out-left" : "slide-out-right"
      );
      setTimeout(() => {
        if (index !== currentIndex) {
          card.style.opacity = "0";
          card.style.zIndex = "1";
        }
      }, 500);
    } else {
      card.style.opacity = "0";
      card.style.zIndex = "1";
    }
  });
}

// Desktop 3D carousel behavior
function updateDesktopSlider() {
  const isTablet = window.innerWidth <= 1024;
  const radius = isTablet ? 350 : 450;
  const angleStep = (2 * Math.PI) / totalCards;

  testimonialCards.forEach((card, index) => {
    card.classList.remove(
      "mobile-active",
      "slide-in-left",
      "slide-in-right",
      "slide-out-left",
      "slide-out-right"
    );

    card.style.left = "";
    card.style.position = "absolute";

    const position = (index - currentIndex + totalCards) % totalCards;
    const angle = position * angleStep;

    const x = Math.sin(angle) * radius;
    const z = Math.cos(angle) * radius - radius;
    const scale = 0.7 + Math.cos(angle) * 0.3;
    const opacity = 0.3 + Math.cos(angle) * 0.7;
    const zIndex = Math.round(50 + z);

    card.style.transform = `translate3d(${x}px, 0, ${z}px) scale(${scale})`;
    card.style.opacity = opacity;
    card.style.zIndex = zIndex;
  });
}

// Update active dot indicator
function updateDots() {
  testimonialDots.forEach((dot, index) => {
    dot.classList.toggle("active", index === currentIndex);
  });
}

// Slide navigation
function nextSlide() {
  previousIndex = currentIndex;
  currentIndex = (currentIndex + 1) % totalCards;
  updateSlider();
}

function prevSlide() {
  previousIndex = currentIndex;
  currentIndex = (currentIndex - 1 + totalCards) % totalCards;
  updateSlider();
}

function goToSlide(index) {
  previousIndex = currentIndex;
  currentIndex = index;
  updateSlider();
}

// Autoplay controls
function startAutoPlay() {
  if (isAutoPlaying) {
    autoPlayInterval = setInterval(() => nextSlide(), 3000);
  }
}

function stopAutoPlay() {
  clearInterval(autoPlayInterval);
}

function resumeAutoPlay() {
  stopAutoPlay();
  startAutoPlay();
}

// Pause/resume on hover
sliderContainer.addEventListener("mouseenter", () => {
  isAutoPlaying = false;
  stopAutoPlay();
});

sliderContainer.addEventListener("mouseleave", () => {
  isAutoPlaying = true;
  resumeAutoPlay();
});

// Dot navigation
testimonialDots.forEach((dot, index) => {
  dot.addEventListener("click", () => {
    stopAutoPlay();
    goToSlide(index);
    if (isAutoPlaying) resumeAutoPlay();
  });
});

// Card click navigation
testimonialCards.forEach((card, index) => {
  card.addEventListener("click", () => {
    stopAutoPlay();
    goToSlide(index);
    if (isAutoPlaying) resumeAutoPlay();
  });
});

// Keyboard navigation
document.addEventListener("keydown", (e) => {
  if (e.key === "ArrowLeft") {
    stopAutoPlay();
    prevSlide();
    if (isAutoPlaying) resumeAutoPlay();
  }
  if (e.key === "ArrowRight") {
    stopAutoPlay();
    nextSlide();
    if (isAutoPlaying) resumeAutoPlay();
  }
});

// Desktop drag navigation
let isDragging = false;
let startPos = 0;
let currentTranslate = 0;

testimonialTrack.addEventListener("mousedown", (e) => {
  if (window.innerWidth > 768) {
    isDragging = true;
    startPos = e.clientX;
    stopAutoPlay();
  }
});

testimonialTrack.addEventListener("mousemove", (e) => {
  if (!isDragging || window.innerWidth <= 768) return;
  currentTranslate = e.clientX - startPos;
});

testimonialTrack.addEventListener("mouseup", () => {
  if (!isDragging || window.innerWidth <= 768) return;

  isDragging = false;
  const movedBy = currentTranslate;

  if (movedBy < -50) nextSlide();
  else if (movedBy > 50) prevSlide();

  currentTranslate = 0;
  if (isAutoPlaying) resumeAutoPlay();
});

testimonialTrack.addEventListener("mouseleave", () => {
  if (isDragging && window.innerWidth > 768) {
    isDragging = false;
    currentTranslate = 0;
    if (isAutoPlaying) resumeAutoPlay();
  }
});

// Update layout on resize
let resizeTimeout;
window.addEventListener("resize", () => {
  clearTimeout(resizeTimeout);
  resizeTimeout = setTimeout(() => {
    resetAllCards();
    updateSlider();
  }, 100);
});

// Initialize slider
updateSlider();
startAutoPlay();
