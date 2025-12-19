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
  document.body.style.overflow = "auto";
}

// Event listener for close button
modalCloseBtn.addEventListener("click", hideModal);

// Close modal on outside click
modal.addEventListener("click", (e) => {
  if (e.target === modal) {
    hideModal();
  }
});