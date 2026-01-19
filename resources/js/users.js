console.log('users.js cargado');

document.addEventListener('DOMContentLoaded', () => {

  // 🔒 MODAL EDITAR USUARIOS (si no existe, salimos)
  const modalEdit = document.getElementById('modalEditar');
  if (!modalEdit) {
    // Este JS no corresponde a esta vista
    return;
  }

  // =========================
  // FUNCIONES GENERALES
  // =========================
  const closeAllModals = () => {
    document.querySelectorAll('.modal, .modal__editar').forEach(modal => {
      modal.classList.remove('show-modal');
    });
  };

  // =========================
  // MODAL AGREGAR USUARIO
  // =========================
  const btnAdd = document.querySelector('.btn-add-user');
  const modalAdd = document.getElementById('modalAgregar');
  const closeAdd = modalAdd?.querySelector('.close-modal-btn');

  btnAdd?.addEventListener('click', () => {
    closeAllModals();
    modalAdd?.classList.add('show-modal');
  });

  closeAdd?.addEventListener('click', () => {
    modalAdd?.classList.remove('show-modal');
  });

  // =========================
  // MODAL EDITAR USUARIO
  // =========================
  const closeEdit = modalEdit.querySelector('.close_modal_btn');

  document.querySelectorAll('.btn-editar').forEach(btn => {
    btn.addEventListener('click', () => {

      closeAllModals();
      modalEdit.classList.add('show-modal');

      // 🔹 Datos DIRECTOS del botón (NO CAMBIADO)
      const { id, nombre, cedula, email, telefono, rol } = btn.dataset;

      document.getElementById('edit_id').value = id;
      document.getElementById('edit_nombre').value = nombre;
      document.getElementById('edit_cedula').value = cedula;
      document.getElementById('edit_email').value = email;
      document.getElementById('edit_telefono').value = telefono;
      document.getElementById('edit-rol').value = rol;

      document.getElementById('formEditar').action = `/usuarios/${id}`;
    });
  });

  closeEdit?.addEventListener('click', () => {
    modalEdit.classList.remove('show-modal');
  });

});
