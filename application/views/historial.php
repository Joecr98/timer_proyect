<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/globalEstilos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/listaEstaciones.css') ?>">
</head>

<body>
    <?php $this->load->view('barraNavegacion'); ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header text-center">
                <h4>Historial de Estaciones</h4>
            </div>

            <div class="card-body">
                <!-- Filtros -->
                <h5>Filtros</h5>
                <div class="form-inline mb-3">
                    <label for="minutosFilter" class="mr-2">Mostrar registros con más de: (minutos)</label>
                    <input type="number" id="minutosFilter" class="form-control mr-2" placeholder="Minutos" min="-1">
                    <label for="estacionFilter" class="mr-2">Filtrar por estación:</label>
                    <select id="estacionFilter" class="form-control mr-2">
                        <option value="">Todas las estaciones</option>
                        <?php foreach ($equipos as $equipo) : ?>
                            <option value="<?= strtolower($equipo->nombre) ?>"><?= $equipo->nombre ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary" onclick="aplicarFiltros()">Aplicar Filtros</button>
                    <button id="reset-filters" class="btn btn-secondary ml-2">
                        <i class="fa fa-sync"></i> <!-- Alternativa de ícono de actualización -->
                    </button>
                </div>
                <!-- Estadísticas -->
                <div class="alert alert-info text-center" role="alert">
                    <h5>Estadísticas</h5>
                    <p>Estación con más registros: <span id="estacionMasRegistros" class="font-weight-bold"></span></p>
                    <p>Estación menos usada: <span id="estacionMenosUsada" class="font-weight-bold"></span></p>
                </div>

                <!-- Tabla de Historial -->
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Inicio</th>
                            <th scope="col">Fin</th>
                            <th scope="col">Nombre de la estación</th>
                            <th scope="col">Minutos</th>
                        </tr>
                    </thead>
                    <tbody id="historialBody">
                        <?php
                        $contador = 0;
                        foreach ($historiales as $historial) {
                            // Convertir fechas a objetos DateTime
                            $inicio = new DateTime($historial->inicioEquipoHistorial);
                            $fin = new DateTime($historial->finEquipoHistorial);

                            // Calcular la diferencia en minutos
                            $interval = $inicio->diff($fin);
                            $diferenciaEnMinutos = ($interval->h * 60) + $interval->i; // Horas a minutos + minutos

                            echo '
                <tr class="text-center" data-equipo-id="' . $historial->idEquipoHistorial . '">
                    <td>' . ++$contador . '</td>
                    <td>' . $historial->inicioEquipoHistorial . '</td>
                    <td>' . $historial->finEquipoHistorial . '</td>
                    <td>' . $historial->nombreEquipo . '</td>
                    <td>' . $diferenciaEnMinutos . ' minutos</td>
                </tr>
            ';
                        }
                        ?>
                    </tbody>
                </table>
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
        const baseUrl = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/historial.js') ?>"></script>

</body>

</html>