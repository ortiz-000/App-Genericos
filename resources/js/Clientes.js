document.addEventListener('DOMContentLoaded', () => {

    const botonesEditar = document.querySelectorAll('.btn-editar');

    botonesEditar.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            // 🔒 Siempre tomar el botón real
            const button = e.currentTarget;

            // 🔍 Buscar la modal EN EL MOMENTO DEL CLICK
            const modalEdit = document.getElementById('modalEditarCliente');
            if (!modalEdit) {
                console.error('Modal #modalEditarCliente no encontrada');
                return;
            }

            const formEdit = modalEdit.querySelector('#Formedit');
            if (!formEdit) {
                console.error('Formulario #Formedit no encontrado');
                return;
            }

            const id = button.dataset.id;
            if (!id) {
                console.error('ID no encontrado en el botón');
                return;
            }

            // 🔗 Ruta PATCH
            formEdit.action = `/clientes/${id}`;

            // 🆔 Hidden ID
            const hiddenId = document.getElementById('edit_id');
            if (hiddenId) hiddenId.value = id;

            // ✏️ Inputs
            ['nombre', 'direccion', 'ciudad', 'telefono'].forEach(campo => {
                const input = document.getElementById(`edit_${campo}`);
                if (input) {
                    input.value = button.dataset[campo] || '';
                }
            });

            // 🚀 Mostrar modal
            modalEdit.classList.add('show-modal');
        });
    });

    // ❌ Cerrar modal (botón)
    document.querySelectorAll('.modal-close, .close-modal-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modalEdit = document.getElementById('modalEditarCliente');
            if (modalEdit) modalEdit.classList.remove('show-modal');
        });
    });

    // ❌ Cerrar al hacer click fuera
    const modalBg = document.getElementById('modalEditarCliente');
    if (modalBg) {
        modalBg.addEventListener('click', (e) => {
            if (e.target === modalBg) {
                modalBg.classList.remove('show-modal');
            }
        });
    }


    // --- ALERTA DEL FORMULARIO EVIDENCIA ---
    const alerta = document.getElementById("alerta");
    const btnAceptar = document.getElementById("aceptarAlerta");
    const formEvidencia = document.getElementById("formEvidencia");

    if (formEvidencia) {
        formEvidencia.addEventListener("submit", function(e) {
            // Solo mostramos la alerta
            alerta.style.display = "flex";
        });
    }

    if (btnAceptar) {
        btnAceptar.addEventListener("click", function() {
            alerta.style.display = "none";
        });
    }
});
