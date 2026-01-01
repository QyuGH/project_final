// EmailJS Handler
(function () {
  emailjs.init("oGsSBUwIoX1BGGZkj");
})();

// Get contact modal's class value
const contactModal = document.querySelector(".contact-modal");

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

        // Call modal for success message
        showModal(
          contactModal,
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

        // Call modal for error message
        showModal(
          contactModal,
          "error",
          "Oops! Something Went Wrong",
          "Failed to send your message. Please try again or contact me directly via my social media accounts."
        );

        submitBtn.textContent = originalBtnText;
        submitBtn.disabled = false;
      }
    );
  });
