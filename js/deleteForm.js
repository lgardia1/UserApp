const btnDelete = document.getElementById("btn-delete");
const tbody = document.getElementById("table");
const formDelete = document.getElementById("formDelete");
const urlDelete = document
  .querySelector('meta[name="app-url-delete"]')
  .getAttribute("content")
  .slice(0, -1);

let currentId;

tbody?.addEventListener("contextmenu", (event) => {
  event.preventDefault();

  const tr = event.target.closest("tr");

  if (!tr) {
    return;
  }

  const { userId } = tr.dataset;

  if (!userId) {
    return;
  }

  btnDelete.classList.remove("d-none");
  btnDelete.style.top = `${event.clientY + 4}px`;
  btnDelete.style.left = `${event.clientX + 6}px`;
  currentId = userId;
});

document.addEventListener("click", ({ target }) => {
  btnDelete.classList.add("d-none");
});

document.getElementById("confirmDelete").addEventListener("click", () => {
  formDelete.action = urlDelete + currentId;
  formDelete.submit();

  const deleteModal = bootstrap.Modal.getInstance(
    document.getElementById("deleteModal")
  );
  deleteModal.hide();
});
