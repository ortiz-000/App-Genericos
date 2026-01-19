document.addEventListener('DOMContentLoaded', () => {

    // =========================
    // MODAL MOTO
    // =========================
    const btnAbrirMoto = document.getElementById('abrirMoto');
    const btnCerrarMoto = document.getElementById('cerrarModalMoto');
    const modalMoto = document.getElementById('modalMoto');

    if (btnAbrirMoto && btnCerrarMoto && modalMoto) {
        btnAbrirMoto.addEventListener('click', () => {
            modalMoto.classList.add('active');
        });

        btnCerrarMoto.addEventListener('click', () => {
            modalMoto.classList.remove('active');
        });
    }

    // =========================
    // MODAL CARRO
    // =========================
    const btnAbrirCarro = document.getElementById('abrirCarro');
    const btnCerrarCarro = document.getElementById('cerrarModalCarro');
    const modalCarro = document.getElementById('modalCarro');

    if (btnAbrirCarro && btnCerrarCarro && modalCarro) {
        btnAbrirCarro.addEventListener('click', () => {
            modalCarro.classList.add('active');
        });

        btnCerrarCarro.addEventListener('click', () => {
            modalCarro.classList.remove('active');
        });
    }

    // =========================
    // FILTROS (USUARIO / FECHAS)
    // =========================
    const filtroUsuario = document.getElementById('filterUsuario');
    const fechaInicio = document.getElementById('filterFechaInicio');
    const fechaFin = document.getElementById('filterFechaFin');

    const cards = document.querySelectorAll('.inspeccion-card');

    function filtrarInspecciones() {

        const usuario = filtroUsuario?.value.toLowerCase().trim() || '';
        const inicio = fechaInicio?.value ? new Date(fechaInicio.value) : null;

        // 🔹 CLAVE: llevar fecha fin al final del día
        const fin = fechaFin?.value
            ? new Date(fechaFin.value + 'T23:59:59')
            : null;

        cards.forEach(card => {

            const vendedor = (card.dataset.vendedor || '').toLowerCase();
            const mensajero = (card.dataset.mensajero || '').toLowerCase();
            const fecha = card.dataset.fecha || '';

            const fechaCard = fecha ? new Date(fecha) : null;

            let mostrar = true;

            // Filtro por usuario (vendedor o mensajero)
            if (usuario && !vendedor.includes(usuario) && !mensajero.includes(usuario)) {
                mostrar = false;
            }

            // Filtro fecha inicio
            if (inicio && fechaCard && fechaCard < inicio) {
                mostrar = false;
            }

            // Filtro fecha fin
            if (fin && fechaCard && fechaCard > fin) {
                mostrar = false;
            }

            card.closest('.col-12').style.display = mostrar ? '' : 'none';
        });
    }

    if (filtroUsuario) filtroUsuario.addEventListener('input', filtrarInspecciones);
    if (fechaInicio) fechaInicio.addEventListener('change', filtrarInspecciones);
    if (fechaFin) fechaFin.addEventListener('change', filtrarInspecciones);

});
