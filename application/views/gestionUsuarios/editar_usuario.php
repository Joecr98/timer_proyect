<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Sistema de Temporizadores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-title {
            color: #3498db;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-guardar {
            background-color: #3498db;
            border: none;
            transition: all 0.3s;
        }
        .btn-guardar:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .btn-volver {
            color: #3498db;
            background-color: transparent;
            border: 1px solid #3498db;
        }
        .btn-volver:hover {
            color: #fff;
            background-color: #3498db;
        }
        .input-group-text {
            background-color: #3498db;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="text-center form-title">
                <i class="fas fa-user-edit me-2"></i>Editar Usuario
            </h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php echo form_open('UsuariosController/editar/' . $usuario->idUsuario, ['class' => 'needs-validation', 'novalidate' => '']); ?>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo set_value('nombre', $usuario->nombre); ?>" required>
                </div>
                <?php echo form_error('nombre', '<div class="text-danger mt-1">', '</div>'); ?>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo set_value('apellido', $usuario->apellido); ?>" required>
                </div>
                <?php echo form_error('apellido', '<div class="text-danger mt-1">', '</div>'); ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email', $usuario->email); ?>" required>
                </div>
                <?php echo form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
            </div>

            <div class="mb-4">
                <label for="rol" class="form-label">Rol</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="administrador" <?php echo set_select('rol', 'administrador', $usuario->rol == 'administrador'); ?>>Administrador</option>
                        <option value="operador" <?php echo set_select('rol', 'operador', $usuario->rol == 'operador'); ?>>Operador</option>
                    </select>
                </div>
                <?php echo form_error('rol', '<div class="text-danger mt-1">', '</div>'); ?>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-guardar btn-lg">
                    <i class="fas fa-save me-2"></i>Guardar cambios
                </button>
                <a href="<?php echo site_url('UsuariosController/listaUsuarios'); ?>" class="btn btn-volver btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Volver a la lista de usuarios
                </a>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
          'use strict'

          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.querySelectorAll('.needs-validation')

          // Loop over them and prevent submission
          Array.prototype.slice.call(forms)
            .forEach(function (form) {
              form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                  event.preventDefault()
                  event.stopPropagation()
                }

                form.classList.add('was-validated')
              }, false)
            })
        })()
    </script>
</body>
</html>