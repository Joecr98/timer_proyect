<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios - Sistema de Temporizadores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 20px;
        }
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #3498db;
            color: white;
            border: none;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(52, 152, 219, 0.05);
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }
        .btn-edit {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-delete {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-create {
            background-color: #28a745;
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-users me-2"></i>Lista de Usuarios
            </h2>
            <div>
                <a href="<?php echo site_url('UsuariosController/crearUsuario'); ?>" class="btn btn-create">
                    <i class="fas fa-user-plus me-2"></i>Crear Usuario
                </a>
                <a href="<?php echo site_url('equipos'); ?>" class="btn btn-back ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Regresar
                </a>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario->idUsuario; ?></td>
                            <td><?php echo $usuario->nombre; ?></td>
                            <td><?php echo $usuario->apellido; ?></td>
                            <td><?php echo $usuario->email; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $usuario->rol === 'administrador' ? 'primary' : 'secondary'; ?>">
                                    <?php echo ucfirst($usuario->rol); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo site_url('UsuariosController/editar/' . $usuario->idUsuario); ?>" class="btn btn-action btn-edit me-1" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-action btn-delete" title="Eliminar" onclick="confirmarEliminacion(<?php echo $usuario->idUsuario; ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmarEliminacion(idUsuario) {
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo site_url('UsuariosController/eliminar/'); ?>" + idUsuario;
                }
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
