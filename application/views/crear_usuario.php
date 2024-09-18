<h2>Crear Nuevo Usuario</h2>
<?php if ($this->session->flashdata('success')): ?>
    <p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<?php echo validation_errors(); ?>
<?php echo form_open('UsuariosController/crearUsuario'); ?>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" required>

    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" value="<?php echo set_value('apellido'); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo set_value('email'); ?>" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>

    <label for="rol">Rol:</label>
    <select name="rol" required>
        <option value="operador" <?php echo set_select('rol', 'operador'); ?>>Operador</option>
        <option value="administrador" <?php echo set_select('rol', 'administrador'); ?>>Administrador</option>
    </select>

    <input type="submit" value="Crear Usuario">
</form>