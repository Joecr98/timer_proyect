<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Estación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/globalEstilos.css') ?>">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php $this->load->view('barraNavegacion'); ?>
    <div class="container">
        <div class="row mb-3">
            <a href="<?php echo base_url('EquiposController/listarNotificaciones'); ?>" class="btn btn-primary">Cancelar creación</a>
        </div>
        <div class="mb-5">
            <?php echo form_open('EquiposController/crearNotificacion', ['id' => 'form-notificacion']); ?>
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?= set_value('name'); ?>" required
                        placeholder="Nombre" id="name" maxlength="50">
                </div>

                <div class="form-group col-sm-3">
                    <label for="icon">Icono</label>
                    <select name="icon" class="form-control">
                        <option value="">Ninguno</option>
                        <option value="success" <?= set_select('icon', 'success'); ?>>Éxito</option>
                        <option value="info" <?= set_select('icon', 'info'); ?>>Información</option>
                        <option value="question" <?= set_select('icon', 'question'); ?>>Pregunta</option>
                        <option value="warning" <?= set_select('icon', 'warning'); ?>>Advertencia</option>
                        <option value="error" <?= set_select('icon', 'error'); ?>>Error</option>
                    </select>
                </div>

                <div class="form-group col-sm-3">
                    <label for="title">Título</label>
                    <input type="text" name="title" class="form-control" value="<?= set_value('title'); ?>"
                        placeholder="Título" id="title" maxlength="25">
                </div>

                <div class="form-group col-sm-3">
                    <label for="text">Texto</label>
                    <input type="text" name="text" class="form-control" value="<?= set_value('text'); ?>"
                        placeholder="Texto" id="text" maxlength="50">
                </div>

                <div class="form-group col-sm-3">
                    <label for="colorButton">Color del botón</label>
                    <input type="color" name="colorButton" class="form-control" value="<?= set_value('colorButton', '#3085d6'); ?>"
                        id="colorButton">
                </div>

                <div class="form-group col-sm-3">
                    <label for="estacionFilter" class="mr-2">Escoger estación</label>
                    <select id="estacionFilter" name="estacionFilter" class="form-control mr-2">
                        <option value="">Todas las estaciones</option>
                        <?php foreach ($equipos as $equipo) : ?>
                            <option value="<?= $equipo->idEquipo ?>"><?= $equipo->nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group col-sm-3">
                    <label for="configureTime">Tiempo configurado (minutos)</label>
                    <input type="number" name="configureTime" class="form-control" value="<?= set_value('configureTime'); ?>"
                        placeholder="Tiempo configurado" id="configureTime" max="9999" required>
                </div>

                <div class="form-group col-sm-3">
                    <label for="BackdropColor">Color del telón</label>
                    <input type="color" name="BackdropColor" class="form-control" value="<?= set_value('BackdropColor'); ?>"
                        id="BackdropColor">
                </div>

            </div>

            <div class="form-group mt-5">
                <label>
                    <input type="hidden" name="hayImagen" value="0">
                    <input type="checkbox" name="hayImagen" value="1" id="hayImagen">
                    Agregar Imagen
                </label>
            </div>
            <!-- Campos adicionales para imagen (inicialmente ocultos) -->
            <div id="imageFields" class=" row hidden border border-success p-3 mb-2">
                <div class="form-group col-sm-3">
                    <label for="imageUrl">URL de la Imagen</label>
                    <input type="url" name="imageUrl" class="form-control" value="<?= set_value('imageUrl'); ?>"
                        placeholder="URL de la Imagen" id="imageUrl" maxlength="250">
                </div>

                <div class="form-group col-sm-3">
                    <label for="imageWidth">Ancho (px)</label>
                    <input type="number" name="imageWidth" class="form-control" value="<?= set_value('imageWidth'); ?>"
                        placeholder=" Ancho de la Imagen" id="imageWidth">
                </div>

                <div class="form-group col-sm-3">
                    <label for="imageHeight">Alto (px)</label>
                    <input type="number" name="imageHeight" class="form-control" value="<?= set_value('imageHeight'); ?>"
                        placeholder="Alto de la Imagen" id="imageHeight">
                </div>

                <div class="form-group col-sm-3">
                    <label for="altName">Nombre alernativo</label>
                    <input type="text" name="altName" class="form-control" value="<?= set_value('altName'); ?>"
                        placeholder="Nombre alternativo" id="altName" maxlength="50">
                </div>
            </div>

            <div class="form-group mt-5">
                <label>
                    <input type="hidden" name="hayBackground" value="0">
                    <input type="checkbox" value="1" id="hayBackground">
                    Agregar fondo
                </label>
            </div>
            <!-- Campos adicionales para background (inicialmente ocultos) -->
            <div id="backgroundFields" class="hidden row border border-warning p-3 mb-2">
                <div class="form-group col-sm-3">
                    <label for="BackgroundImageUrl">URL de la Imagen del fondo</label>
                    <input type="url" name="BackgroundImageUrl" class="form-control" value="<?= set_value('BackgroundImageUrl'); ?>"
                        placeholder="URL de la Imagen del fondo" id="BackgroundImageUrl" maxlength="250">
                </div>

                <div class="form-group col-sm-3">
                    <label for="BackgroundColor">Color del fondo</label>
                    <input type="color" name="BackgroundColor" class="form-control" value="<?= set_value('BackgroundColor'); ?>"
                        id="BackgroundColor">
                </div>

                <div class="form-group col-sm-3">
                    <p class="bg-light text-dark p-2 rounded" style="font-size: 0.875rem; background-color: rgba(255, 255, 255, 0.5);">
                        *Ten en cuenta que la imagen de fondo tiene más prioridad que el color del fondo,
                        si personalizaste ambos solo se mostrará la imagen (si la url es válida)*
                    </p>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">Guardar notificacion</button>
            <?php echo form_close(); ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <script>
            document.getElementById('hayImagen').addEventListener('change', function() {
                var imageFields = document.getElementById('imageFields');
                var imageUrl = document.getElementById('imageUrl');
                var imageWidth = document.getElementById('imageWidth');
                var imageHeight = document.getElementById('imageHeight');

                if (this.checked) {
                    imageFields.classList.remove('hidden');
                } else {
                    imageFields.classList.add('hidden');
                    // Limpiar los valores de los campos
                    imageUrl.value = '';
                    imageWidth.value = '';
                    imageHeight.value = '';
                }
            });

            document.getElementById('hayBackground').addEventListener('change', function() {
                var backgroundFields = document.getElementById('backgroundFields');
                var BackgroundImageUrl = document.getElementById('BackgroundImageUrl');
                var BackgroundColor = document.getElementById('BackgroundColor');

                if (this.checked) {
                    backgroundFields.classList.remove('hidden');
                } else {
                    backgroundFields.classList.add('hidden');
                    // Limpiar los valores de los campos
                    backgroundFields.value = '';
                    BackgroundImageUrl.value = '';
                    BackgroundColor.value = '';
                }
            });

            <?php if ($this->session->flashdata('notificacion_creada')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '¡Notificación personalizada creada con éxito!',
                    confirmButtonColor: '#28a745'
                });
            <?php elseif ($this->session->flashdata('error_notificacion')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al crear la notificación personalizada: Este nombre ya existe',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    // Borrar el valor del input nombre
                    document.getElementById('nombre').value = '';
                    // Colocar el puntero en el input nombre
                    document.getElementById('nombre').focus();
                });
            <?php endif; ?>
        </script>

</body>

</html>