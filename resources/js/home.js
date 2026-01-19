document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // MODAL AGREGAR CLIENTE
    // =========================
    // MODAL CLIENTE
    // =========================
    const modalClientes = document.getElementById('modalClientes');
    const btnAbrirModalClientes = document.querySelector('.Clienteadd');
    const btnCerrarModalClientes = document.querySelector('#modalClientes .Cerrar-model');

    function abrirModal(modal) {
        if (modal) modal.style.display = 'flex';
    }

    function cerrarModal(modal) {
        if (modal) modal.style.display = 'none';
    }

    if (btnAbrirModalClientes) {
        btnAbrirModalClientes.addEventListener('click', e => {
            e.preventDefault();
            abrirModal(modalClientes);
        });
    }

    if (btnCerrarModalClientes) {
        btnCerrarModalClientes.addEventListener('click', e => {
            e.preventDefault();
            cerrarModal(modalClientes);
        });
    }

    // =========================
    // MODAL EVIDENCIA
    // =========================
    const modalEvidencia = document.getElementById('modalEvidencia');
    const botonesEvidencia = document.querySelectorAll('.btn-evidencia');
    const nombreInput = document.getElementById('nombre_establecimiento');
    const ciudadInput = document.getElementById('ciudad_establecimiento');
    const ubicacionInput = document.getElementById('ubicacion');
    const motivoInput = document.getElementById('motivo');

    botonesEvidencia.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();

            const fila = btn.closest('tr');
            if (!fila) return;

            nombreInput.value = fila.children[1]?.textContent.trim() || '';
            ciudadInput.value = fila.children[3]?.textContent.trim() || '';

            abrirModal(modalEvidencia);
            obtenerUbicacion();
        });
    });

    function obtenerUbicacion() {
        if (!ubicacionInput || !navigator.geolocation) return;

        navigator.geolocation.getCurrentPosition(
            pos => {
                ubicacionInput.value =
                    `https://www.google.com/maps?q=${pos.coords.latitude},${pos.coords.longitude}`;
            },
            () => {
                ubicacionInput.value = '';
            }
        );
    }

    if (motivoInput) {
        motivoInput.addEventListener('change', () => {
            document.getElementById('otro-container').style.display =
                motivoInput.value === 'Otro' ? 'block' : 'none';
        });
    }

    // =========================
    // 🔍 BARRA DE BÚSQUEDA
    // =========================
    const searchInput = document.getElementById('searchInput');
    const filasTabla = document.querySelectorAll('tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const texto = searchInput.value.toLowerCase();

            filasTabla.forEach(fila => {
                fila.style.display =
                    fila.textContent.toLowerCase().includes(texto) ? '' : 'none';
            });
        });
    }

});
