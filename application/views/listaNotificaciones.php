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

    <script src="<?= base_url('assets/js/listaNotificaciones.js') ?>"></script>

    <script>
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