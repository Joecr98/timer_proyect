$(document).ready(function () {
    // Función para restaurar el estado de bloqueo al cargar la página
    function restoreLockedStations() {
        const lockedStations = JSON.parse(localStorage.getItem('lockedStations')) || [];
        lockedStations.forEach(stationId => {
            $(`.station[data-id="${stationId}"]`).addClass('locked');
        });
    }

    // Llamada inicial para restaurar el estado de bloqueo
    restoreLockedStations();

    // Función para bloquear estación seleccionada con PIN
    $('.btn-lock').click(function () {
        const selectedStationId = $('#station-select').val();
        if (!selectedStationId) {
            Swal.fire('Por favor seleccione una estación');
            return;
        }
        Swal.fire({
            title: 'Ingrese el PIN para bloquear la estación seleccionada',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Bloquear',
            showLoaderOnConfirm: true,
            preConfirm: (pin) => {
                if (pin === '1234') { // PIN de ejemplo
                    $(`.station[data-id="${selectedStationId}"]`).addClass('locked');

                    // Guardar en localStorage
                    let lockedStations = JSON.parse(localStorage.getItem('lockedStations')) || [];
                    if (!lockedStations.includes(selectedStationId)) {
                        lockedStations.push(selectedStationId);
                    }
                    localStorage.setItem('lockedStations', JSON.stringify(lockedStations));
                } else {
                    Swal.showValidationMessage('PIN incorrecto');
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });

    // Función para desbloquear estación seleccionada con PIN
    $('.btn-unlock').click(function () {
        const selectedStationId = $('#station-select').val();
        if (!selectedStationId) {
            Swal.fire('Por favor seleccione una estación');
            return;
        }
        Swal.fire({
            title: 'Ingrese el PIN para desbloquear la estación seleccionada',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Desbloquear',
            showLoaderOnConfirm: true,
            preConfirm: (pin) => {
                if (pin === '1234') { // PIN de ejemplo
                    $(`.station[data-id="${selectedStationId}"]`).removeClass('locked');

                    // Eliminar del localStorage
                    let lockedStations = JSON.parse(localStorage.getItem('lockedStations')) || [];
                    lockedStations = lockedStations.filter(id => id !== selectedStationId);
                    localStorage.setItem('lockedStations', JSON.stringify(lockedStations));
                } else {
                    Swal.showValidationMessage('PIN incorrecto');
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    });
});