// Scroll Effects for Portfolio Website
// 1. HEADER SCROLL ANIMATION
const header = document.querySelector(".header");
let headerLastScrollY = window.scrollY;

// Add/remove header style on scroll
function handleHeaderScroll() {
  const currentScrollY = window.scrollY;
  if (currentScrollY > 50) header.classList.add("scrolled");
  else header.classList.remove("scrolled");
  headerLastScrollY = currentScrollY;
}

// Optimize header scroll listener
let headerTicking = false;
window.addEventListener("scroll", () => {
  if (!headerTicking) {
    window.requestAnimationFrame(() => {
      handleHeaderScroll();
      headerTicking = false;
    });
    headerTicking = true;
  }
});
handleHeaderScroll();

// 2. SCROLL DIRECTION TRACKER
let scrollLastY = window.scrollY;
let scrollIsDown = true;

// Detect scroll direction
window.addEventListener("scroll", () => {
  const currentScrollY = window.scrollY;
  scrollIsDown = currentScrollY > scrollLastY;
  scrollLastY = currentScrollY;
});

// 3. TOOLS SECTION ANIMATION
document.addEventListener("DOMContentLoaded", () => {
  // Animate tool cards when visible
  const toolCards = document.querySelectorAll(".tool-icon-container");
  const toolObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && scrollIsDown) {
          entry.target.classList.add("tool-visible");
          toolObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2, rootMargin: "0px" }
  );

  toolCards.forEach((card) => toolObserver.observe(card));
});

// 4. PROJECTS SECTION ANIMATION
document.addEventListener("DOMContentLoaded", () => {
  // Animate project cards when visible
  const projectCards = document.querySelectorAll(".project-card");
  const projectObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && scrollIsDown) {
          entry.target.classList.add("project-visible");
          projectObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2, rootMargin: "0px" }
  );

  projectCards.forEach((card) => projectObserver.observe(card));
});

// 5. CONTACT SECTION ANIMATION
document.addEventListener("DOMContentLoaded", () => {
  // Animate contact icons and email when visible
  const contactElements = document.querySelectorAll(
    ".contact-icon-container, .email-box"
  );
  const contactObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && scrollIsDown) {
          entry.target.classList.add("contact-visible");
          contactObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2, rootMargin: "0px" }
  );

  contactElements.forEach((element) => contactObserver.observe(element));
});

// 6. HERO SECTION ANIMATION
document.addEventListener("DOMContentLoaded", () => {
  // Trigger hero section fade-in
  const heroContents = document.querySelector(".hero-contents");
  const heroImgContainer = document.querySelector(".hero-img-container");

  setTimeout(() => {
    if (heroContents) heroContents.classList.add("fade-in-active");
    setTimeout(() => {
      if (heroImgContainer) heroImgContainer.classList.add("fade-in-active");
    }, 200);
  }, 100);
});

// 7. COMMENT CARD OUTPUT ANIMATION
document.addEventListener("DOMContentLoaded", () => {
  const reviewCards = document.querySelectorAll(".review-card-container");

  const reviewObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("review-visible");
          reviewObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.2 }
  );

  reviewCards.forEach((card) => reviewObserver.observe(card));
});

// END OF FILE