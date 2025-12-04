document.addEventListener('DOMContentLoaded', () => {
    console.log('Clientes.js cargado');

    // Modal para agregar cliente
    const btnAbrir = document.querySelector('.Clienteadd');  // El botón con la clase 'Clienteadd'
    const modalClientes = document.getElementById('modalClientes');
    const btnCerrarClientes = modalClientes.querySelector('.Cerar-model');  // El enlace con la clase 'modal-close'

    // Abre el modal al hacer clic en el botón "Agregar Cliente"
    if (btnAbrir && modalClientes) {
        btnAbrir.addEventListener('click', () => {
            modalClientes.classList.add('show-modal');  // Agrega la clase para mostrar el modal
        });
    }

    // Cierra el modal al hacer clic en el enlace de "Cerrar"
    if (btnCerrarClientes) {
        btnCerrarClientes.addEventListener('click', (e) => {
            e.preventDefault();  // Prevenir la acción por defecto del enlace
            modalClientes.classList.remove('show-modal');  // Elimina la clase para ocultar el modal
        });
    }

    // Cierra el modal si se hace clic fuera del contenedor del modal
    if (modalClientes) {
        modalClientes.addEventListener('click', (e) => {
            if (e.target === modalClientes) {
                modalClientes.classList.remove('show-modal');
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', () => {
    const openModalButtons = document.querySelectorAll('.btn-editar');
    const modal = document.getElementById('modalEditarCliente');
    const closeModal = modal.querySelector('.modal-close');
    const Formedit = modal.querySelector('#Formedit');
    
    // Abrir el modal
    openModalButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();  // Evita el comportamiento predeterminado del botón

            const clientId = button.getAttribute('data-id');  // 'data-id' del cliente

            // Configura la acción del formulario para enviar a la ruta correcta
            Formedit.action = `/clientes/${clientId}`;  // Ruta PATCH de Laravel

            // Precarga los datos del cliente en los campos del formulario
            document.getElementById('edit_nombre').value = button.getAttribute('data-nombre');
            document.getElementById('edit_direccion').value = button.getAttribute('data-direccion');
            document.getElementById('edit_ciudad').value = button.getAttribute('data-ciudad');
            document.getElementById('edit_telefono').value = button.getAttribute('data-telefono');

            // Abre el modal
            modal.classList.add('show-modal');
        });
    });

    // Cerrar el modal
    closeModal.addEventListener('click', () => {
        modal.classList.remove('show-modal');  // Elimina la clase 'show-modal' para cerrar el modal
    });

    // Cerrar el modal al hacer clic fuera del contenedor
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {  // Si el clic es fuera del contenedor del modal
            modal.classList.remove('show-modal');  // Cierra el modal
        }
    });
});




