/**
 * HELPER FUNCTION FOR MODALS
 */
function showModal(modalEl, type = "", title = "", message = "") {
  if (!modalEl) return;

  const modalTitle = modalEl.querySelector(".modal-title");
  const modalMessage = modalEl.querySelector(".modal-message");

  if (modalTitle) modalTitle.textContent = title;
  if (modalMessage) modalMessage.textContent = message;

  modalEl.classList.remove("success", "error");
  if (type) modalEl.classList.add(type);

  setTimeout(() => modalEl.classList.add("active"), 10);

  document.body.style.overflow = "hidden";

  const closeBtn = modalEl.querySelector(".modal-close-btn");
  if (closeBtn && !closeBtn.dataset.listenerAdded) {
    closeBtn.addEventListener("click", () => hideModal(modalEl));
    closeBtn.dataset.listenerAdded = "true";
  }

  if (!modalEl.dataset.listenerAdded) {
    modalEl.addEventListener("click", (e) => {
      if (e.target === modalEl) hideModal(modalEl);
    });
    modalEl.dataset.listenerAdded = "true";
  }
}

function hideModal(modalEl) {
  if (!modalEl) return;
  modalEl.classList.remove("active");
  document.body.style.overflow = "auto";
}
