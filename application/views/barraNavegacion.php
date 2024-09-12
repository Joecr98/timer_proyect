<!-- archivo: application/views/barraNavegacion.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo base_url('EquiposController'); ?>">
        <i class="fas fa-home"></i> <!-- Ícono de casa -->
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('EquiposController/listarEstaciones'); ?>">
                    <i class="fas fa-list"></i> Lista de Equipos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('EquiposController/listarHistorial'); ?>">
                    <i class="fas fa-history"></i> Historial
                </a>
            </li>
            <!-- Agrega más enlaces aquí según sea necesario -->
        </ul>
    </div>
</nav>