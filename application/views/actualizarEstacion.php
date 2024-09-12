<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Estación</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/globalEstilos.css') ?>">
</head>

<body>
    <?php $this->load->view('barraNavegacion'); ?>
    <div class="container">
        <div class="row mb-3">
            <a href="<?php echo base_url('EquiposController/listarEstaciones'); ?>" class="btn btn-primary">Cancelar actualización</a>
        </div>
        <div class="mb-5">
            <?php echo form_open('EquiposController/editarEquipo/' . $equipo->idEquipo, ['id' => 'form-equipo']); ?>
            <input type="hidden" name="idEquipo" value="<?php echo $equipo->idEquipo; ?>">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required placeholder="Nombre" id="nombre" value="<?php echo $equipo->nombre; ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label for="">Descripción</label>
                    <input type="text" name="descripcion" class="form-control" required placeholder="Descripción" id="descripcion" value="<?php echo $equipo->descripcion; ?>">
                </div>
                <div class="form-group col-sm-4">
                    <label for="estado">Estado</label>
                    <select name="estado" class="form-control" required id="estado">
                        <option value="1" <?php echo $equipo->estado == 1 ? 'selected' : ''; ?>>Activa</option>
                        <option value="0" <?php echo $equipo->estado == 0 ? 'selected' : ''; ?>>Inactiva</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">Actualizar estación</button>
            <?php echo form_close(); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Actualización',
            text: 'Estás editando una estación',
            confirmButtonColor: '#007bff'
        });
    </script>
</body>

</html>