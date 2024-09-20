<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Notificaciones personalizadas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/globalEstilos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/listaEstaciones.css') ?>">
</head>

<body>
    <?php $this->load->view('barraNavegacion'); ?>
    <div class="container">
        <div class="row mb-3">
            <a href="<?php echo base_url('EquiposController/cargarVistaCrearNotificaciones'); ?>" class="btn btn-success">Crear Notificacion</a>
        </div>
        <div class="row">
            <div class="card col-14">
                <div class="card-header">
                    <h4>Tabla de notificaciones</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Nombre</th>
                                <th scope="col" class="text-center">Imagen</th>
                                <th scope="col" class="text-center">Tiempo establecido (minutos)</th>
                                <th scope="col" class="text-center">Estación</th>
                                <th scope="col" class="text-center">Editar</th>
                                <th scope="col" class="text-center">Eliminar</th>
                                <th scope="col" class="text-center">Vista previa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            foreach ($notificaciones as $notificacion) {
                                echo '
                            <tr>
                                <td class="text-center">' . ++$contador . '</td>
                                <td class="text-center">' . $notificacion->nombreNotificacion . '</td>
                                <td class="w-25 text-center" style="max-width: 200px;">
                                    ' . ($notificacion->imagenUrlNotificacion ? $notificacion->imagenUrlNotificacion : 'Sin imagen') . '
                                </td>
                                <td class="text-center">' . $notificacion->tiempoConfiguradoNotificacion . '</td>
                                <td class="text-center">' . ($notificacion->nombreEquipo == null ? 'Todas las estaciones' : $notificacion->nombreEquipo) . '</td>
                                <td><a href="' . base_url('EquiposController/vistaActualizarNotificacion/' . $notificacion->idNotificacion) . '" class="btn btn-warning">Editar</a></td>
                                <td><button type="button" class="btn btn-danger" onclick="confirmarEliminacion(`' . base_url('EquiposController/eliminarNotificacion/' . $notificacion->idNotificacion) . '`)">Eliminar</button></td>
                                <td>
                                    <button class="vista-previa btn btn-primary" 
                                        data-id="' . $notificacion->idNotificacion . '" 
                                        data-title="' . $notificacion->tituloNotificacion . '" 
                                        data-text="' . $notificacion->textoNotificacion . '" 
                                        data-icon="' . $notificacion->iconoNotificacion . '"
                                        data-imageUrl="' . $notificacion->imagenUrlNotificacion . '"
                                        data-imageWidth="' . $notificacion->anchoImagenNotificacion . '"
                                        data-imageHeight="' . $notificacion->largoImagenNotificacion . '"
                                        data-imageAlt="' . $notificacion->nombreAlternoImagenNotificacion . '"
                                        data-confirmButtonColor="' . $notificacion->colorBotonNotificacion . '"
                                        data-backgroundUrl="' . $notificacion->imagenUrlBackgroundNotificacion . '"
                                        data-backgroundColor="' . $notificacion->colorBackgroundNotificacion . '"
                                        data-backdropColor="' . $notificacion->colorBackdropNotificacion . '">
                                        Vista Previa
                                    </button>
                                </td>
                            </tr>
                            ';
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/1y0xI+zj7rbj/ds7BIIqWz3pu6p06lgf1Ew1b2g" crossorigin="anonymous"></script>
    <!-- Bootstrap Bundle (con Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
    </script>

    <script>
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

        <?php if ($this->session->flashdata('notificacion_actualizada')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '¡Notificación personalizada actualizada con éxito!',
                confirmButtonColor: '#28a745'
            });
        <?php elseif ($this->session->flashdata('notificacion_eliminada')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '¡Notificación personalizada eliminada con éxito!',
                confirmButtonColor: '#28a745'
            });
        <?php elseif ($this->session->flashdata('error_eliminarNotificacion')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al eliminar la notificación personalizada',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
    </script>

</body>

</html>