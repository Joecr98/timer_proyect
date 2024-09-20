document.addEventListener("DOMContentLoaded", function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    function successCallback(position) {
        // Extraer latitud y longitud
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        // Enviar las coordenadas a tu controlador
        fetch('http://localhost/index.php/EquiposController/getWeatherByCoordinates', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ latitude: lat, longitude: lon })
        })
        .then(response => response.json())
        .then(data => {
            // Aquí podrías actualizar el DOM para mostrar el clima
            document.getElementById("weather-info").innerHTML = `
                <p class="text-card-clima">
                    <span class="material-symbols-outlined">thermostat</span> ${data.main.temp}°C
                    <span class="material-symbols-outlined">partly_cloudy_day</span> ${data.weather[0].description}
                </p>`;
        })
        .catch(error => console.error('Error:', error));
    }

    function errorCallback(error) {
        console.error('Error al obtener la geolocalización:', error);
    }
});
