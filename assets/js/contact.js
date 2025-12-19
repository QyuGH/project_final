// EmailJS Handler 

(function () {
  emailjs.init("oGsSBUwIoX1BGGZkj");
})();

// MODAL FUNCTIONS
const modal = document.getElementById("email-modal");
const modalTitle = document.querySelector(".modal-title");
const modalMessage = document.querySelector(".modal-message");
const modalCloseBtn = document.querySelector(".modal-close-btn");

// Show modal with success or error state
function showModal(type, title, message) {
  modalTitle.textContent = title;
  modalMessage.textContent = message;

  modal.classList.remove("success", "error");
  modal.classList.add(type);

  setTimeout(() => {
    modal.classList.add("active");
  }, 10);

  document.body.style.overflow = "hidden";
}

// Hide modal and re-enable scrolling
function hideModal() {
  modal.classList.remove("active");
  document.body.style.overflow = "";
}

// Close modal events
modalCloseBtn.addEventListener("click", hideModal);
modal.addEventListener("click", (event) => {
  if (event.target === modal) hideModal();
});
document.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && modal.classList.contains("active")) {
    hideModal();
  }
});

// FORM SUBMISSION HANDLER

document
  .getElementById("contact-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const submitBtn = this.querySelector(".send-btn");
    const originalBtnText = submitBtn.textContent;
    submitBtn.textContent = "Sending...";
    submitBtn.disabled = true;

    // Send email using EmailJS
    emailjs.sendForm("service_jnl65w4", "template_ao3f0s3", this).then(
      (response) => {
        console.log("SUCCESS!", response.status, response.text);

        showModal(
          "success",
          "Message Sent!",
          "Thank you for reaching out! I'll get back to you as soon as possible."
        );

        this.reset();
        submitBtn.textContent = originalBtnText;
        submitBtn.disabled = false;
      },
      (error) => {
        console.log("FAILED...", error);

        showModal(
          "error",
          "Oops! Something Went Wrong",
          "Failed to send your message. Please try again or contact me directly via my social media accounts."
        );

        submitBtn.textContent = originalBtnText;
        submitBtn.disabled = false;
      }
    );
  });
