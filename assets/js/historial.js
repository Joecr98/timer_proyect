function aplicarFiltros() {
    const minutosFilter = document.getElementById('minutosFilter').value;
    const estacionSeleccionada = document.getElementById('estacionFilter').value.toLowerCase();
    const filas = document.querySelectorAll('tbody tr');

    filas.forEach(fila => {
        const minutos = parseInt(fila.querySelector('td:nth-child(5)').textContent.split(' ')[0]);
        const nombreEstacion = fila.querySelector('td:nth-child(4)').textContent.toLowerCase();

        const coincideMinutos = isNaN(minutosFilter) || minutos > minutosFilter;
        const coincideEstacion = estacionSeleccionada === '' || nombreEstacion === estacionSeleccionada;

        // Mostrar la fila solo si cumple ambos filtros
        fila.style.display = coincideMinutos && coincideEstacion ? '' : 'none';
    });
}

function cargarEstadisticas() {
    fetch(`${baseUrl}EquiposController/obtenerEstadisticas`)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verifica los datos recibidos

            document.getElementById('estacionMasRegistros').textContent = `${data.estacionMasRegistros?.nombre || 'Desconocida'} con ${data.estacionMasRegistros?.cantidad || 0} registros.`;
            document.getElementById('estacionMenosUsada').textContent = `${data.estacionMenosUsada?.nombre || 'Desconocida'} con ${data.estacionMenosUsada?.cantidad || 0} registros.`;
        })
        .catch(error => console.error('Error al cargar estadísticas:', error));
}



document.addEventListener('DOMContentLoaded', cargarEstadisticas);

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('reset-filters').addEventListener('click', function() {
        location.reload(); // Refresca la página
    });
});