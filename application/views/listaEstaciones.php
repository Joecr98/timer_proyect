<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
	<style>
		body {
			background-color: #121212;
			color: #ffffff;
		}

		.container {
			margin-top: 50px;
		}

		.card {
			background-color: #1e1e1e;
			border: none;
		}

		.card-header {
			background-color: #2c2c2c;
			border-bottom: 1px solid #444;
		}

		.card-body {
			background-color: #1e1e1e;
		}

		.table {
			color: #ffffff;
		}

		.table thead {
			background-color: #333333;
		}

		.table tbody tr {
			background-color: #2a2a2a;
		}

		.btn {
			border: none;
		}

		.btn-success {
			background-color: #28a745;
		}

		.btn-primary {
			background-color: #007bff;
		}

		.btn-warning {
			background-color: #ffc107;
			color: #000;
		}

		.btn-danger {
			background-color: #dc3545;
		}

		.form-control {
			background-color: #2c2c2c;
			color: #ffffff;
			border: 1px solid #444;
		}

		.form-control::placeholder {
			color: #888888;
		}
	</style>
</head>

<body>
	<?php $this->load->view('barraNavegacion'); ?>
	<div class="container">
		<div class="row mb-3">
			<a href="<?php echo base_url('EquiposController/crearEstacion'); ?>" class="btn btn-success">Crear Estación</a>
		</div>
		<div class="row">
			<div class="card col-12">
				<div class="card-header">
					<h4>Tabla de estaciones</h4>
				</div>
				<div class="card-body">
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nombre</th>
								<th scope="col">Descripción</th>
								<th scope="col">Estado</th>
								<th scope="col">Editar</th>
								<th scope="col">Eliminar</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$contador = 0;
							foreach ($equipos as $equipo) {
								echo '
                                    <tr>
                                        <td>' . ++$contador . '</td>
                                        <td>' . $equipo->nombre . '</td>
                                        <td>' . $equipo->descripcion . '</td>
                                        <td>' . ($equipo->estado == 1 ? 'Activa' : 'Inactiva') . '</td>
                                        <td><a href="' . base_url('EquiposController/actualizarEstacion/' . $equipo->idEquipo) . '" class="btn btn-warning text-white">Editar</a></td>
                                        <td><button type="button" class="btn btn-danger" onclick="confirmarEliminacion(`' . base_url('EquiposController/eliminarEquipo/' . $equipo->idEquipo) . '`)">Eliminar</button></td>
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
				text: "Esta acción eliminará la estación.",
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
</body>

</html>