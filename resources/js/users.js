document.addEventListener('DOMContentLoaded', () => {
    // ================== MODAL AGREGAR ==================
    const btnAdd = document.querySelector('.btn-add-user');
    const modalAdd = document.getElementById('modalAgregar'); // ID único de modal Agregar
    const closeAdd = modalAdd.querySelector('.close-modal-btn');

    if (btnAdd && modalAdd && closeAdd) {
        btnAdd.addEventListener('click', (e) => {
            e.preventDefault();
            modalAdd.classList.add('show-modal'); // o modalAdd.style.display = 'flex';
        });

        closeAdd.addEventListener('click', (e) => {
            e.preventDefault();
            modalAdd.classList.remove('show-modal'); // o modalAdd.style.display = 'none';
        });

        modalAdd.addEventListener('click', (e) => {
            if (e.target === modalAdd) modalAdd.classList.remove('show-modal');
        });
    }
    const btnEdits = document.querySelectorAll('.btn_edit_users');
    const modalEdit = document.getElementById('modalEditar');
    const closeEdit = modalEdit.querySelector('.close_modal_btn');
    const formEditar = document.getElementById('formEditar');

if (modalEdit && closeEdit && formEditar) {

    btnEdits.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const row = button.closest('tr');

            // RELLENAR INPUTS
            document.getElementById('edit_id').value       = row.children[0].textContent;
            document.getElementById('edit_cedula').value   = row.children[1].textContent;
            document.getElementById('edit_nombre').value   = row.children[2].textContent;
            document.getElementById('edit_email').value    = row.children[3].textContent;
            document.getElementById('edit_telefono').value = row.children[5].textContent;
            document.getElementById('edit-rol').value      = row.children[6].textContent;

            // ASIGNAR RUTA DINÁMICA AL FORM
            const userId = row.children[0].textContent;
            formEditar.action = `/usuarios/${userId}`;

            // ABRIR MODAL
            modalEdit.classList.add('show-modal');
        });
    });

    closeEdit.addEventListener('click', (e) => {
        e.preventDefault();
        modalEdit.classList.remove('show-modal');
    });

    modalEdit.addEventListener('click', (e) => {
        if (e.target === modalEdit) modalEdit.classList.remove('show-modal');
    });
}
});
/*
 * Funcionalidad para el botón de búsqueda
 */
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('searchInput');
  const table = document.getElementById('miTabla');
  if (!input || !table) return;
  function buscar() {
    const value = input.value.toLowerCase();
    const filas = table.getElementsByTagName('tr');
    for (let i = 1; i < filas.length; i++) {
      const celdas = filas[i].getElementsByTagName('td');
      let encontrado = false;
      for (let j = 0; j < celdas.length; j++) {
        if (celdas[j].innerText.toLowerCase().includes(value)) {
          encontrado = true;
          break;
        }
      }
      filas[i].style.display = encontrado ? '' : 'none';
    }
  }
  input.addEventListener('input', buscar);
  const btn = document.querySelector('.btn-search');
  if (btn) btn.addEventListener('click', (e) => { e.preventDefault(); buscar(); });
});


