console.log('empleados.js cargado');


document.addEventListener('DOMContentLoaded', () => {
    const inputCliente = document.getElementById('filterCliente');
    const inputCiudad = document.getElementById('filterCiudad');
    const inputFecha = document.getElementById('filterFecha');
    const tabla = document.querySelector('#miTabla tbody');

    function formatearFecha(fechaStr) {
        // Convierte fecha de tabla a formato yyyy-mm-dd
        const date = new Date(fechaStr);
        if (isNaN(date)) return '';
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        return `${yyyy}-${mm}-${dd}`;
    }

    function filtrarTabla() {
        const clienteValor = inputCliente.value.toLowerCase().trim();
        const ciudadValor = inputCiudad.value.toLowerCase().trim();
        const fechaValor = inputFecha.value; // yyyy-mm-dd

        Array.from(tabla.rows).forEach(row => {
            const cliente = row.cells[3].textContent.toLowerCase().trim();
            const ciudad = row.cells[4].textContent.toLowerCase().trim();
            const fechaTabla = formatearFecha(row.cells[9].textContent);

            const coincideCliente = cliente.includes(clienteValor) || clienteValor === '';
            const coincideCiudad = ciudad.includes(ciudadValor) || ciudadValor === '';
            const coincideFecha = fechaTabla === fechaValor || fechaValor === '';

            if (coincideCliente && coincideCiudad && coincideFecha) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    inputCliente.addEventListener('input', filtrarTabla);
    inputCiudad.addEventListener('input', filtrarTabla);
    inputFecha.addEventListener('change', filtrarTabla);
});



document.addEventListener('DOMContentLoaded', () => {

    // --- referencias ---
    const modal = document.getElementById('modalEvidencia');
    const botonesEvidencia = document.querySelectorAll('.btn-evidencia');
    const otroContainer = document.getElementById('otro-container');
    const inputOtro = document.getElementById('otro');
    const motivoSelect = document.getElementById('motivo');
    const ubicacionInput = document.getElementById('ubicacion');

    // Inputs que vamos a llenar automáticamente
    const nombreInput = document.getElementById('nombre_establecimiento');
    const ciudadInput = document.getElementById('ciudad_establecimiento');

    // --- abrir modal ---
    function abrirModalEvidencia() {
        if (!modal) return console.error('Modal con id #modalEvidencia no existe');
        modal.style.display = 'flex';
        obtenerUbicacion();
    }

    // --- cerrar modal ---
    window.cerrarModalEvidencia = function () {
        if (!modal) return;
        modal.style.display = 'none';
    }

    // --- llenar campos desde la tabla y abrir modal ---
    botonesEvidencia.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            // buscar la fila del botón clickeado
            const fila = btn.closest('tr');
            if (!fila) return;

            // capturar valores de la fila
            const nombre = fila.children[1]?.textContent.trim() || '';
            const ciudad = fila.children[3]?.textContent.trim() || '';

            // asignar a inputs de la modal
            if (nombreInput) nombreInput.value = nombre;
            if (ciudadInput) ciudadInput.value = ciudad;

            // abrir modal
            abrirModalEvidencia();
        });
    });

    // --- cerrar modal al hacer clic fuera del contenido ---
    window.addEventListener('click', (e) => {
        if (!modal) return;
        if (e.target === modal) {
            cerrarModalEvidencia();
        }
    });

    // --- manejo del motivo / "otro" ---
    if (motivoSelect && otroContainer && inputOtro) {
        function actualizarOtro() {
            if (motivoSelect.value === 'Otro') {
                otroContainer.style.display = 'block';
                inputOtro.setAttribute('required', 'required');
            } else {
                otroContainer.style.display = 'none';
                inputOtro.removeAttribute('required');
                inputOtro.value = '';
            }
        }
        motivoSelect.addEventListener('change', actualizarOtro);
        actualizarOtro();
    }

     // --- obtener ubicación ---
    function obtenerUbicacion() {
        if (!ubicacionInput || !navigator.geolocation) return;
        ubicacionInput.value = '';
        navigator.geolocation.getCurrentPosition(
            pos => {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                ubicacionInput.value = `https://www.google.com/maps?q=${lat},${lon}`;
                console.log('Ubicación guardada:', ubicacionInput.value);
            },
            () => { ubicacionInput.value = ''; },
            { enableHighAccuracy: true, timeout: 8000 }
        );
    }

    // --- envío de evidencia con foto ---
    if (formEvidencia) {
        formEvidencia.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formEvidencia);

            fetch('/ruta_al_backend', { // <- reemplaza con tu ruta real
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                console.log('Éxito:', data);
                alert('Evidencia enviada correctamente');
                cerrarModalEvidencia();
            })
            .catch(err => {
                console.error('Error al enviar evidencia:', err);
                alert('Error al enviar la evidencia');
            });
        });
    }
});







