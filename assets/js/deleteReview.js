document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.action-btn[data-type="delete"]').forEach(btn => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();

      const deleteUrl = btn.getAttribute("href");
      const modal = document.querySelector(".delete-modal");

      showDeleteConfirmationModal(modal, deleteUrl);
    });
  });
});

function showDeleteConfirmationModal(modal, deleteUrl) {
  const modalTitle = modal.querySelector(".modal-title");
  const modalMessage = modal.querySelector(".modal-message");
  const modalContent = modal.querySelector(".modal-content");
  const closeBtn = modal.querySelector(".modal-close-btn");

  // Set content    
  modalTitle.textContent = "Confirm Deletion";
  modalMessage.textContent = "Are you sure you want to delete this review? This action cannot be undone.";
  closeBtn.textContent = "Cancel";

  // Reset modal state
  modal.classList.remove("success", "error");
  modal.classList.add("warning");

  // Remove existing confirm button 
  const existingBtn = modalContent.querySelector(".modal-confirm-delete");
  if (existingBtn) existingBtn.remove();

  // Create confirm delete button
  const confirmBtn = document.createElement("button");
  confirmBtn.textContent = "Confirm Delete";
  confirmBtn.className = "modal-confirm-delete";

  confirmBtn.addEventListener("click", () => {
    window.location.href = deleteUrl;
  });

  modalContent.appendChild(confirmBtn);

  // Show modal
  modal.classList.add("active");
  document.body.style.overflow = "hidden";

  // Cancel button redirects to the initial page state
  closeBtn.onclick = () => {
    window.location.href = "?page=testimonials";
  };

  modal.onclick = (e) => {
    if (e.target === modal) {
      window.location.href = "?page=testimonials";
    }
  };
}
