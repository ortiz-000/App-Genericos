document.addEventListener('DOMContentLoaded', () => {
    const inputVendedor = document.getElementById('filterVendedor');
    const inputCiudad = document.getElementById('filterCiudad');
    const inputFechaInicio = document.getElementById('filterFechaInicio');
    const inputFechaFin = document.getElementById('filterFechaFin');
    const tabla = document.querySelector('#miTabla tbody');

    // Convierte fecha de tabla a Date solo con año, mes, día
    function parseFechaTabla(fechaStr) {
        const date = new Date(fechaStr);
        if (isNaN(date)) return null;
        // Solo año, mes, día
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

    function filtrarTabla() {
        const vendedorValor = inputVendedor.value.toLowerCase().trim();
        const ciudadValor = inputCiudad.value.toLowerCase().trim();
        const fechaInicio = inputFechaInicio.value ? new Date(inputFechaInicio.value) : null;
        const fechaFin = inputFechaFin.value ? new Date(inputFechaFin.value) : null;

        // Ajustamos fechaInicio y fechaFin para ignorar horas
        const inicio = fechaInicio ? new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), fechaInicio.getDate()) : null;
        const fin = fechaFin ? new Date(fechaFin.getFullYear(), fechaFin.getMonth(), fechaFin.getDate()) : null;

        Array.from(tabla.rows).forEach(row => {
            const vendedor = row.cells[1].textContent.toLowerCase().trim();
            const ciudad = row.cells[4].textContent.toLowerCase().trim();
            const fechaTabla = parseFechaTabla(row.cells[9].textContent);

            const coincideVendedor = vendedor.includes(vendedorValor) || vendedorValor === '';
            const coincideCiudad = ciudad.includes(ciudadValor) || ciudadValor === '';

            let coincideFecha = true;
            if (fechaTabla) {
                if (inicio && fin) {
                    coincideFecha = fechaTabla >= inicio && fechaTabla <= fin;
                } else if (inicio) {
                    coincideFecha = fechaTabla >= inicio;
                } else if (fin) {
                    coincideFecha = fechaTabla <= fin;
                }
            }

            row.style.display = (coincideVendedor && coincideCiudad && coincideFecha) ? '' : 'none';
        });
    }

    // Escuchar cambios en todos los filtros
    if (inputVendedor) inputVendedor.addEventListener('input', filtrarTabla);
    if (inputCiudad) inputCiudad.addEventListener('input', filtrarTabla);
    if (inputFechaInicio) inputFechaInicio.addEventListener('change', filtrarTabla);
    if (inputFechaFin) inputFechaFin.addEventListener('change', filtrarTabla);
});
