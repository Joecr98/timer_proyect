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

                // Inicializar Sortable.js en el contenedor de estaciones
    const estacionesContainer = document.getElementById('sortable-estaciones');
    
    // Recuperar el orden de las estaciones del localStorage al cargar la página
    const savedOrder = JSON.parse(localStorage.getItem('estacionOrder')) || [];

    if (savedOrder.length > 0) {
        savedOrder.forEach(function(id) {
            const station = $(`.station[data-id="${id}"]`);
            $('#sortable-estaciones').append(station);
        });
    }

    // Aplicar Sortable.js
    const sortable = Sortable.create(estacionesContainer, {
        animation: 150,
        onEnd: function() {
            const order = [];
            $('.station').each(function() {
                order.push($(this).data('id'));
            });
            localStorage.setItem('estacionOrder', JSON.stringify(order));
        }
    });
        });