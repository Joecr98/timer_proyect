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
            font-size: 3rem;
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
            font-size: 0.9rem;
        }

        .btn-add-time {
            background-color: #4caf50;
            /* Verde vibrante */
            border-color: #4caf50;
            color: #fff;
        }

        .btn-free-time {
            background-color: #673ab7;
            /* Púrpura vibrante */
            border-color: #673ab7;
            color: #fff;
        }

        .btn-pause {
            background-color: #ff9800;
            /* Naranja vibrante */
            border-color: #ff9800;
            color: #fff;
        }

        .btn-reset {
            background-color: #f44336;
            /* Rojo vibrante */
            border-color: #f44336;
            color: #fff;
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

        .time-controls {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .time-controls button {
            background-color: #555;
            color: #fff;
            border-radius: 50%;
            border: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
        }

        .time-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .time-inputs input {
            background-color: #555;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-align: center;
            padding: 5px;
            width: 70px;
        }

        .time-inputs .time-labels {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 5px;
            font-size: 0.8rem;
            color: #fff;
        }

        .time-inputs .btn-load-time {
            border: none;
            background: none;
            color: #007bff;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .time-inputs .btn-load-time i {
            font-size: 1.5rem;
        }

        .time-inputs .btn-load-time:hover {
            color: #0056b3;
        }

        /* Añadir o modificar el estilo del placeholder */
        input::placeholder {
            color: #e0e0e0;
            /* Ajusta el color a un tono más visible */
            opacity: 1;
            /* Asegúrate de que la opacidad esté al 100% */
        }
    </style>
</head>

<body>
    <?php $this->load->view('barraNavegacion'); ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Estaciones</h2>
        <div class="row">
            <?php foreach ($equipos as $index => $equipo) : ?>
                <div class="col-md-4 mb-4 <?php echo $equipo->estado == 0 ? 'inactiva' : ''; ?>" data-index="<?php echo $index; ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $equipo->nombre; ?></h5>
                            <p class="card-text">Descripción: <?php echo $equipo->descripcion; ?></p>
                            <p class="card-text">Estado: <span class="<?php echo $equipo->estado == 1 ? 'estado-activa' : 'estado-inactiva'; ?>">
                                    <?php echo $equipo->estado == 1 ? 'activa' : 'inactiva'; ?>
                                </span></p>

                            <div class="btn-group d-flex justify-content-center">
                                <button class="btn btn-add-time btn-sm" data-action="add-time" data-index="<?php echo $index; ?>">Iniciar tiempo añadido</button>
                                <button class="btn btn-free-time btn-sm" data-action="free-time" data-index="<?php echo $index; ?>">Iniciar tiempo libre</button>
                            </div>
                            <div class="timer-display mt-3" data-index="<?php echo $index; ?>">
                                <span class="horas">00</span>:<span class="minutos">00</span>:<span class="segundos">00</span>
                            </div>

                            <!-- Inputs numéricos para horas y minutos -->
                            <div class="time-inputs">
                                <input type="number" class="hours-input" placeholder="Horas:" min="0" max="99" data-index="<?php echo $index; ?>">
                                <input type="number" class="minutes-input" placeholder="Mins:" min="0" max="59" data-index="<?php echo $index; ?>">
                                <button class="btn-load-time" data-index="<?php echo $index; ?>"><i class="fas fa-check"></i></button>
                            </div>

                            <!-- Controles para añadir minutos -->
                            <div class="time-controls">
                                <button data-time="900" data-index="<?php echo $index; ?>">+15</button>
                                <button data-time="1800" data-index="<?php echo $index; ?>">+30</button>
                                <button data-time="3600" data-index="<?php echo $index; ?>">+60</button>
                            </div>

                            <!-- Botones de pausar y reiniciar -->
                            <div class="btn-group d-flex justify-content-center mt-3">
                                <button class="btn btn-pause btn-sm" data-action="pause" data-index="<?php echo $index; ?>">Pausar</button>
                                <button class="btn btn-reset btn-sm" data-action="reset" data-index="<?php echo $index; ?>">Reiniciar</button>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            let estations = {};

            function initEstation(index) {
                let hour = 0,
                    min = 0,
                    sec = 0,
                    totalTime = 0;
                let interval;
                let running = false;
                let paused = false; // Nueva variable para rastrear si está en pausa
                let modeFlag = null; // 'addedTime' para tiempo añadido, 'freeTime' para tiempo libre
                const timerKey = `timer_${index}`;

                function updateDisplay() {
                    $(`.timer-display[data-index="${index}"] .horas`).text(hour < 10 ? "0" + hour : hour);
                    $(`.timer-display[data-index="${index}"] .minutos`).text(min < 10 ? "0" + min : min);
                    $(`.timer-display[data-index="${index}"] .segundos`).text(sec < 10 ? "0" + sec : sec);
                }

                function resetTimer() {
                    clearInterval(interval);
                    hour = min = sec = totalTime = 0;
                    running = false;
                    paused = false; // Reiniciar estado de pausa
                    modeFlag = null;
                    updateDisplay();
                    localStorage.removeItem(timerKey); // Eliminar del localStorage
                    $(`.btn-add-time[data-index="${index}"], .btn-free-time[data-index="${index}"]`).prop('disabled', false);
                    $(`.hours-input[data-index="${index}"], .minutes-input[data-index="${index}"], .time-controls button[data-index="${index}"], .btn-load-time[data-index="${index}"]`).prop('disabled', false).removeClass('inactiva');
                    $(`.timer-display[data-index="${index}"]`).css('background-color', ''); // Restaurar color original
                }

                function saveTimer() {
                    localStorage.setItem(timerKey, JSON.stringify({
                        hour: hour,
                        min: min,
                        sec: sec,
                        running: running,
                        paused: paused, // Guardar estado de pausa
                        modeFlag: modeFlag,
                        totalTime: totalTime
                    }));
                }

                function startCountdown() {
                    modeFlag = 'addedTime';
                    paused = false;
                    interval = setInterval(function() {
                        if (totalTime <= 0) {
                            clearInterval(interval);
                            running = false;
                            modeFlag = null;
                            Swal.fire({
                                title: `¡Tiempo finalizado en la estación ${index + 1}!`,
                                text: 'El temporizador ha llegado a 0.',
                                icon: 'warning',
                                confirmButtonText: 'Aceptar'
                            });
                            // Cambiar color de fondo a rojo para indicar visualmente
                            $(`.timer-display[data-index="${index}"]`).css('background-color', 'red');
                            $(`.hours-input[data-index="${index}"], .minutes-input[data-index="${index}"], .time-controls button[data-index="${index}"], .btn-load-time[data-index="${index}"]`).prop('disabled', false).addClass('inactiva');
                            localStorage.removeItem(timerKey); // Eliminar del localStorage
                            return;
                        }
                        totalTime--;
                        hour = Math.floor(totalTime / 3600);
                        min = Math.floor((totalTime % 3600) / 60);
                        sec = totalTime % 60;
                        updateDisplay();
                        saveTimer();
                    }, 1000);
                    running = true;
                    saveTimer();
                }

                function startCountUp() {
                    if ($(`.timer-display[data-index="${index}"]`).css('background-color') === 'rgb(255, 0, 0)') {
                        $(`.timer-display[data-index="${index}"]`).css('background-color', '');
                    }
                    // Si es la primera vez que empieza y no está en pausa
                    if (!running && !paused) {
                        hour = min = sec = 0; // Reiniciar a 0 solo cuando empieza por primera vez
                        updateDisplay();
                    }

                    paused = false; // Desactivar estado de pausa
                    modeFlag = 'freeTime';
                    interval = setInterval(function() {
                        if (sec < 59) {
                            sec += 1;
                        } else {
                            sec = 0;
                            if (min < 59) {
                                min += 1;
                            } else {
                                min = 0;
                                hour += 1;
                            }
                        }
                        updateDisplay();
                        saveTimer();
                    }, 1000);
                    running = true;
                    saveTimer();
                }

                function loadTimer() {
                    let savedTimer = JSON.parse(localStorage.getItem(timerKey));
                    if (savedTimer) {
                        hour = savedTimer.hour;
                        min = savedTimer.min;
                        sec = savedTimer.sec;
                        running = savedTimer.running;
                        paused = savedTimer.paused; // Recuperar estado de pausa
                        modeFlag = savedTimer.modeFlag;
                        updateDisplay();

                        if (running) {
                            totalTime = (hour * 3600) + (min * 60) + sec;
                            if (modeFlag === 'addedTime' && !paused) {
                                startCountdown();
                                inhabilitarBotonesTemporizador();
                            } else if (modeFlag === 'freeTime' && !paused) {
                                startCountUp();
                                inhabilitarBotonesCronometro();
                            }
                        }
                    }
                }

                function inhabilitarBotonesTemporizador() {
                    $(`.btn-add-time[data-index="${index}"]`).prop('disabled', true);
                    $(`.btn-free-time[data-index="${index}"]`).prop('disabled', true);
                }

                function inhabilitarBotonesCronometro() {
                    $(`.btn-add-time[data-index="${index}"]`).prop('disabled', true);
                    $(`.btn-free-time[data-index="${index}"]`).prop('disabled', true);
                    $(`.hours-input[data-index="${index}"], .minutes-input[data-index="${index}"], .time-controls button[data-index="${index}"], .btn-load-time[data-index="${index}"]`).prop('disabled', true).addClass('inactiva');
                }

                $(`.btn-add-time[data-index="${index}"]`).on('click', function() {
                    if (!running) {
                        startCountdown();
                        inhabilitarBotonesTemporizador();
                    }
                });

                $(`.btn-free-time[data-index="${index}"]`).on('click', function() {
                    if (!running) {
                        startCountUp();
                        inhabilitarBotonesCronometro();
                    }
                });

                $(`.btn-pause[data-index="${index}"]`).on('click', function() {
                    clearInterval(interval);
                    running = false;
                    paused = true; // Marcar que está en pausa
                    if (modeFlag === 'addedTime' && running == false) {
                        $(`.btn-add-time[data-index="${index}"]`).prop('disabled', false);
                    } else if (modeFlag === 'freeTime') {
                        $(`.btn-free-time[data-index="${index}"]`).prop('disabled', false);
                    }
                    saveTimer();
                });

                $(`.btn-reset[data-index="${index}"]`).on('click', function() {
                    resetTimer();
                });

                $(`.time-controls button[data-index="${index}"]`).on('click', function() {
                    let addedTime = parseInt($(this).data('time'));
                    Swal.fire({
                        title: '¿Añadir tiempo?',
                        text: `¿Seguro que deseas añadir ${addedTime / 60} minutos?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, añadir!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            totalTime += addedTime;
                            hour = Math.floor(totalTime / 3600);
                            min = Math.floor((totalTime % 3600) / 60);
                            sec = totalTime % 60;
                            updateDisplay();
                            saveTimer();
                            Swal.fire('Añadido', 'El tiempo ha sido añadido correctamente.', 'success');
                        }
                    });
                });


                $(`.btn-load-time[data-index="${index}"]`).on('click', function() {
                    let addedHours = parseInt($(`.hours-input[data-index="${index}"]`).val()) || 0;
                    let addedMinutes = parseInt($(`.minutes-input[data-index="${index}"]`).val()) || 0;
                    let addedSeconds = (addedHours * 3600) + (addedMinutes * 60);
                    Swal.fire({
                        title: '¿Añadir tiempo personalizado?',
                        text: `¿Seguro que deseas añadir ${addedHours} horas y ${addedMinutes} minutos?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, añadir!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            totalTime += addedSeconds;
                            hour = Math.floor(totalTime / 3600);
                            min = Math.floor((totalTime % 3600) / 60);
                            sec = totalTime % 60;
                            updateDisplay();
                            saveTimer();

                            // Borrar el contenido de los inputs
                            $(`.hours-input[data-index="${index}"]`).val('');
                            $(`.minutes-input[data-index="${index}"]`).val('');

                            Swal.fire('Añadido', 'El tiempo ha sido añadido correctamente.', 'success');
                        }
                    });
                });


                loadTimer(); // Cargar el temporizador al inicializar el módulo
            }

            $('.btn-free-time').each(function() {
                let index = $(this).data('index');
                estations[index] = initEstation(index);
            });
        });
    </script>
</body>

</html>