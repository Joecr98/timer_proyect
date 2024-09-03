<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Estaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            background-color: #1e1e1e;
            position: relative;
            padding: 20px;
            margin: 20px 0;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            text-align: center;
        }

        .card-title,
        .card-text {
            color: #e0e0e0;
        }

        .timer-display {
            font-size: 2rem;
            font-weight: bold;
            margin: 20px 0;
            padding: 10px;
            border-radius: 8px;
            background: #333;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        .btn {
            border-radius: 20px;
            padding: 10px 20px;
            margin: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-primary:disabled {
            background-color: #007bff;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary:disabled {
            background-color: #6c757d;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .container {
            max-width: 1200px;
        }

        .inactiva {
            opacity: 0.6;
            pointer-events: none;
        }

        .estado-activa {
            color: #28a745;
        }

        .estado-inactiva {
            color: #dc3545;
        }

        .mode-toggle {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .mode-toggle .dropdown-menu {
            min-width: 150px;
        }

        .btn-start-time {
            margin-top: 50px;
        }

        .dropdown-toggle::after {
            display: none;
            /* Oculta el ícono de flecha por defecto */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Estaciones</h2>
        <div class="row">
            <?php foreach ($equipos as $equipo) : ?>
                <div class="col-md-4 mb-4 <?php echo $equipo->estado == 0 ? 'inactiva' : ''; ?>">
                    <div class="card">
                        <div class="mode-toggle">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bars"></i> <!-- Ícono de hamburguesa -->
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#" data-mode="timer">Temporizador</a>
                                    <a class="dropdown-item" href="#" data-mode="cronometro">Cronómetro</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $equipo->nombre; ?></h5>
                            <p class="card-text">Descripción: <?php echo $equipo->descripcion; ?></p>
                            <p class="card-text">Estado: <span class="<?php echo $equipo->estado == 1 ? 'estado-activa' : 'estado-inactiva'; ?>">
                                    <?php echo $equipo->estado == 1 ? 'activa' : 'inactiva'; ?>
                                </span></p>
                            <!-- Botón para iniciar el tiempo y la visualización -->
                            <button class="btn btn-primary start-time btn-start-time" <?php echo $equipo->estado == 0 ? 'disabled' : ''; ?>>Iniciar Tiempo</button>
                            <div class="timer-display mt-3">00:00:00</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-item').click(function() {
                const mode = $(this).data('mode');
                const card = $(this).closest('.card');
                const startTimeButton = card.find('.start-time');

                // Actualizar texto del botón de inicio basado en la selección
                if (mode === 'timer') {
                    startTimeButton.text('Iniciar Temporizador');
                } else if (mode === 'cronometro') {
                    startTimeButton.text('Iniciar Cronómetro');
                }
            });

            $('.start-time').click(function() {
                const button = $(this);
                const card = $(this).closest('.card');
                const timerDisplay = card.find('.timer-display');

                if (button.text().includes('Temporizador')) {
                    // Lógica para iniciar el temporizador
                } else if (button.text().includes('Cronómetro')) {
                    // Lógica para iniciar el cronómetro
                }
            });
        });
    </script>
</body>

</html>