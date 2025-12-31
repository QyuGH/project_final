/**
 * HELPER FUNCTION FOR MODALS
 */
function showModal(modal, type, title, message, redirectUrl = null) {
  if (!modal) return;

  const modalTitle = modal.querySelector(".modal-title");
  const modalMessage = modal.querySelector(".modal-message");
  const modalCloseBtn = modal.querySelector(".modal-close-btn");
  const modalContent = modal.querySelector(".modal-content");

  modalTitle.textContent = title;
  modalMessage.textContent = message;

  modal.classList.remove("success", "error");
  modal.classList.add(type);

  setTimeout(() => {
    modal.classList.add("active");
  }, 10);

  document.body.style.overflow = "hidden";

  // Reset close button click
  modalCloseBtn.onclick = () => {
    modal.classList.remove("active");
    document.body.style.overflow = "auto";

    // If redirectUrl exists, redirect when closing
    if (redirectUrl) {
      window.location.href = redirectUrl;
    }
  };

  // Close modal on overlay click
  modal.onclick = (e) => {
    if (e.target === modal) {
      modal.classList.remove("active");
      document.body.style.overflow = "auto";

      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    }
  };
}



function hideModal(modalEl) {
  if (!modalEl) return;
  modalEl.classList.remove("active");
  document.body.style.overflow = "auto";
}
