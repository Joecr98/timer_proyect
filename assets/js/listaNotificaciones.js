document.addEventListener("DOMContentLoaded", function() {
    // Selecciona todos los botones de vista previa
    const botonesVistaPrevia = document.querySelectorAll('.vista-previa');

    // Agrega el evento click a cada botón
    botonesVistaPrevia.forEach(function(boton) {
        boton.addEventListener('click', function() {
            // Obtiene los datos del botón (id, título, texto, icono, imagen, background, backdrop)
            const titulo = this.getAttribute('data-title');
            const texto = this.getAttribute('data-text');
            const icono = this.getAttribute('data-icon');
            const imageUrl = this.getAttribute('data-imageUrl');
            const imageWidth = this.getAttribute('data-imageWidth');
            const imageHeight = this.getAttribute('data-imageHeight');
            const imageAlt = this.getAttribute('data-imageAlt');
            const confirmButtonColor = this.getAttribute('data-confirmButtonColor');
            const backgroundUrl = this.getAttribute('data-backgroundUrl');
            const backgroundColor = this.getAttribute('data-backgroundColor');
            const backdropColor = this.getAttribute('data-backdropColor');
            // Configuración básica de la alerta
            let configAlerta = {
                showConfirmButton: true
            };

            // Verifica si el título no es nulo o vacío
            if (titulo && titulo !== 'null') {
                configAlerta.title = titulo;
            }

            // Verifica si el texto no es nulo o vacío
            if (texto && texto !== 'null') {
                configAlerta.text = texto;
            }

            // Verifica si el icono no es nulo o vacío
            if (icono && icono !== 'null') {
                configAlerta.icon = icono; // 'success', 'error', 'warning', 'info', 'question'
            }

            // Verifica si imageUrl no es nulo o vacío
            if (imageUrl && imageUrl !== 'null') {
                configAlerta.imageUrl = imageUrl;

                // Configura el ancho de la imagen si se proporciona
                if (imageWidth && imageWidth !== 'null') {
                    configAlerta.imageWidth = imageWidth;
                }

                // Configura la altura de la imagen si se proporciona
                if (imageHeight && imageHeight !== 'null') {
                    configAlerta.imageHeight = imageHeight;
                }

                // Configura el texto alternativo de la imagen si se proporciona
                if (imageAlt && imageAlt !== 'null') {
                    configAlerta.imageAlt = imageAlt;
                }
            }

            // Verifica si colorBackgroundNotificacion no es nulo o vacío
            if (backgroundColor && backgroundColor !== 'null') {
                configAlerta.background = backgroundColor;
            }

            // Verifica si backgroundUrl no es nulo o vacío
            if (backgroundUrl && backgroundUrl !== 'null') {
                // Aplica no-repeat y center center por defecto, pero permite el estilo cover o contain
                configAlerta.background = `
                url(${backgroundUrl}) no-repeat center center / cover
            `;
            }

            // Configura el color del telón si está presente
            if (backdropColor && backdropColor !== 'null') {
                // Convierte el color hexadecimal a RGB con opacidad por defecto
                configAlerta.backdrop = hexToRgb(backdropColor);
            }

            // Verifica si confirmButtonColor no es nulo o vacío
            if (confirmButtonColor && confirmButtonColor !== 'null') {
                configAlerta.confirmButtonColor = confirmButtonColor;
            }

            // Ejecuta la alerta con la configuración adecuada
            Swal.fire(configAlerta);
        });
    });
});

function hexToRgb(hex) {
    // Elimina el código de color '#' si existe
    hex = hex.replace(/^#/, '');

    // Convierte los valores hexadecimales a números decimales
    if (hex.length === 3) {
        hex = hex.split('');
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }

    // Convierte a RGB
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);

    // Retorna el color en formato rgba con opacidad por defecto de 0.4
    return `rgba(${r}, ${g}, ${b}, 0.4)`;
}

function confirmarEliminacion(url) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la notificación personalizada.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}