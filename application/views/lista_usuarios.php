<h2>Lista de Usuarios</h2>

<?php if ($this->session->flashdata('success')): ?>
    <p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>

<table border="1">
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
                <td><?php echo $usuario->rol; ?></td>
                <td>
                    <a href="<?php echo site_url('UsuariosController/editarUsuario/' . $usuario->idUsuario); ?>">Editar</a>
                    <a href="<?php echo site_url('UsuariosController/eliminarUsuario/' . $usuario->idUsuario); ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
