        $(document).ready(function() {
            let estations = {};
            let totalTimeEstaciones = {};
        // Función para obtener notificaciones del backend
        function obtenerNotificaciones() {
                // console.log('Obteniendo notificaciones...'); // Verifica si la función se llama
                return axios.get('EquiposController/obtenerNotificaciones')
                    .then(response => {
                        // console.log('Notificaciones obtenidas:', response.data); // Verifica la respuesta
                        return response.data;
                    })
                    .catch(error => {
                        // console.error('Error al obtener notificaciones:', error);
                        return [];
                    });
            }
            // Convertir el tiempo configurado a segundos
            function convertirATotalSegundos(tiempo) {
                if (!tiempo) {
                    // console.warn('Tiempo inválido:', tiempo);
                    return null; // O algún valor por defecto
                }
                    const totalSegundos = tiempo * 60;
                    // console.log(`Tiempo en minutos "${tiempo}" convertido a segundos:`, totalSegundos);
                    return totalSegundos;
            }

            function verificarNotificaciones(totalTime, index) {
                // console.log('Verificando notificaciones...');
                obtenerNotificaciones().then(notificaciones => {
                    // console.log('Procesando notificaciones:', notificaciones);
                    notificaciones.forEach(notificacion => {
                        const tiempoConfiguradoSegundos = convertirATotalSegundos(notificacion.tiempoConfiguradoNotificacion);
                        if (tiempoConfiguradoSegundos === null) {
                            // console.warn('No se pudo procesar el tiempo para esta notificación:', notificacion);
                            return; // Saltar esta notificación si no se pudo convertir el tiempo
                        }
                        const idEstacionNotificacion = notificacion.idEquipoNotificacion; // Puede ser null
                        const idEquipo = $(`.station[data-index="${index}"]`).data('id'); // Obtener el idEquipo asociado a este índice
                        if (totalTime === tiempoConfiguradoSegundos) {
                            // console.log(idEquipo);
                            // console.log(idEstacionNotificacion);
                            // console.log(`Coincidencia de tiempo en estación ${index + 1}.`);
                            if (idEstacionNotificacion === null) {
                                // console.log(`Notificación para la estación ${index + 1} disparada.`);
                                mostrarAlerta(notificacion);
                            } else if (parseInt(idEstacionNotificacion) === parseInt(idEquipo)) {
                                // console.log(`Notificación para la estación ${index + 1} disparada.`);
                                mostrarAlerta(notificacion);
                                // console.log(`Notificación no aplica para la estación ${index + 1}.`);
                            }
                        } else {
                            // console.log(`No hay coincidencia de tiempo en estación ${index + 1}.`);
                        }
                    });
                });
            }

        
            // Función para mostrar la alerta
            function mostrarAlerta(notificacion) {
                let configAlerta = {
                    showConfirmButton: true
                };

                if (notificacion.tituloNotificacion && notificacion.tituloNotificacion !== 'null') {
                    configAlerta.title = notificacion.tituloNotificacion;
                }

                if (notificacion.textoNotificacion && notificacion.textoNotificacion !== 'null') {
                    configAlerta.text = notificacion.textoNotificacion;
                }

                if (notificacion.iconoNotificacion && notificacion.iconoNotificacion !== 'null') {
                    configAlerta.icon = notificacion.iconoNotificacion;
                }

                if (notificacion.imagenUrlNotificacion && notificacion.imagenUrlNotificacion !== 'null') {
                    configAlerta.imageUrl = notificacion.imagenUrlNotificacion;
                }

                if (notificacion.anchoImagenNotificacion && notificacion.anchoImagenNotificacion !== 'null') {
                    configAlerta.imageWidth = notificacion.anchoImagenNotificacion;
                }

                if (notificacion.largoImagenNotificacion && notificacion.largoImagenNotificacion !== 'null') {
                    configAlerta.imageHeight = notificacion.largoImagenNotificacion;
                }

                if (notificacion.nombreAlternoImagenNotificacion && notificacion.nombreAlternoImagenNotificacion !== 'null') {
                    configAlerta.imageAlt = notificacion.nombreAlternoImagenNotificacion;
                }

                if (notificacion.colorBackgroundNotificacion && notificacion.colorBackgroundNotificacion !== 'null') {
                    configAlerta.background = notificacion.colorBackgroundNotificacion;
                }

                if (notificacion.imagenUrlBackgroundNotificacion && notificacion.imagenUrlBackgroundNotificacion !== 'null') {
                    configAlerta.background = `
                    url(${notificacion.imagenUrlBackgroundNotificacion}) no-repeat center center / cover
                `;
                }

                if (notificacion.colorBackdropNotificacion && notificacion.colorBackdropNotificacion !== 'null') {
                    configAlerta.backdrop = hexToRgb(notificacion.colorBackdropNotificacion);
                }

                if (notificacion.colorBotonNotificacion && notificacion.colorBotonNotificacion !== 'null') {
                    configAlerta.confirmButtonColor = notificacion.colorBotonNotificacion;
                }

                Swal.fire(configAlerta);
                const alertSound = document.getElementById('alert-sound');
                alertSound.play();
            }

            function hexToRgb(hex) {
                // Elimina el código de color '#' si existe
                hex = hex.replace(/^#/, '');
    
                // Convierte los valores hexadecimales a números decimales
                if (hex.length === 3) {
                    hex = hex.split('');
                    hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                }
    
                // Convierte a RGB
                const r = parseInt(hex.substring(0, 2), 16);
                const g = parseInt(hex.substring(2, 4), 16);
                const b = parseInt(hex.substring(4, 6), 16);
    
                // Retorna el color en formato rgba con opacidad por defecto de 0.4
                return `rgba(${r}, ${g}, ${b}, 0.4)`;
            }
        
                function initEstation(index) {
                let hour = 0,
                    min = 0,
                    sec = 0,
                    totalTime = 0;
                    totalTimeEstaciones[index] = { totalTime };
                let interval;
                let running = false;
                let paused = false;
                let modeFlag = null; // 'addedTime' para tiempo añadido, 'freeTime' para tiempo libre
                let idHistorial = null; // Nueva variable para el ID del historial
                const timerKey = `timer_${index}`;

                function updateDisplay() {
                    $(`.timer-display[data-index="${index}"] .horas`).text(hour < 10 ? "0" + hour : hour);
                    $(`.timer-display[data-index="${index}"] .minutos`).text(min < 10 ? "0" + min : min);
                    $(`.timer-display[data-index="${index}"] .segundos`).text(sec < 10 ? "0" + sec : sec);
                }

                function resetTimer() {
                    // Si no existe el ID del historial, ejecutar el comportamiento por defecto
                    if (!idHistorial) {
                        console.warn('No se ha iniciado el tiempo. ID del historial no disponible, ejecutando reset por defecto.');
                        
                        clearInterval(interval);
                        hour = min = sec = totalTime = 0;
                        running = false;
                        paused = false;
                        modeFlag = null;
                        idHistorial = null;
                        updateDisplay();
                        localStorage.removeItem(timerKey);
                        $(`.btn-add-time[data-index="${index}"], .btn-free-time[data-index="${index}"]`).prop('disabled', false);
                        $(`.hours-input[data-index="${index}"], .minutes-input[data-index="${index}"], .time-controls button[data-index="${index}"], .btn-load-time[data-index="${index}"]`).prop('disabled', false).removeClass('inactiva');
                        $(`.timer-display[data-index="${index}"]`).css('background-color', ''); // Restaurar color original
                        
                        console.log('Temporizador reiniciado (sin ID de historial)');
                        return; // Terminar ejecución ya que no hay más que hacer
                    }
                
                    // Si existe el ID del historial, detener el tiempo a través de una solicitud POST
                    axios.post('detenerTiempo', {
                        idHistorial: idHistorial
                    })
                    .then(response => {
                        const data = response.data;
                        if (data.status === 'success') {
                            console.log('Tiempo detenido exitosamente.');
                            localStorage.removeItem('idHistorial'); // Limpiar el ID del historial de localStorage si ya no es necesario
                        } else {
                            console.error('Error al detener el tiempo:', data.message);
                        }
                    })
                    .catch(error => console.error('Error al detener el tiempo:', error));
                
                    clearInterval(interval);
                    hour = min = sec = totalTime = 0;
                    running = false;
                    paused = false;
                    modeFlag = null;
                    idHistorial = null;
                    updateDisplay();
                    localStorage.removeItem(timerKey);
                    $(`.btn-add-time[data-index="${index}"], .btn-free-time[data-index="${index}"]`).prop('disabled', false);
                    $(`.hours-input[data-index="${index}"], .minutes-input[data-index="${index}"], .time-controls button[data-index="${index}"], .btn-load-time[data-index="${index}"]`).prop('disabled', false).removeClass('inactiva');
                    $(`.timer-display[data-index="${index}"]`).css('background-color', ''); // Restaurar color original
                    
                    console.log('Temporizador reiniciado (con ID de historial)');
                }
                

                function saveTimer() {
                    localStorage.setItem(timerKey, JSON.stringify({
                        hour: hour,
                        min: min,
                        sec: sec,
                        running: running,
                        paused: paused,
                        modeFlag: modeFlag,
                        totalTime: totalTime,
                        idHistorial: idHistorial // Guardar idHistorial
                    }));
                }

                function startCountdown(idEquipo) {
                    if (totalTime <= 0) {
                        console.error('No hay tiempo para iniciar el temporizador.');
                        Swal.fire({
                            title: 'Error',
                            text: 'No hay tiempo disponible para iniciar el temporizador.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                        return; // Salir de la función si no hay tiempo
                    }
                
                    if (!running && !paused) {
                        axios.post('iniciarTiempo', {
                            idEquipo: idEquipo
                        })
                        .then(response => {
                            const data = response.data;
                            if (data.idHistorial) {
                                idHistorial = data.idHistorial; // Guardar el ID del historial en la variable
                                saveTimer(); // Llamar a saveTimer para guardar el estado en localStorage
                                console.log('Tiempo iniciado. ID del historial guardado en localStorage:', data.idHistorial);
                            } else {
                                console.error('No se recibió el ID del historial.');
                            }
                        })
                        .catch(error => console.error('Error al iniciar el tiempo:', error));
                    }
                
                    modeFlag = 'addedTime';
                    paused = false; // Desactivar estado de pausa
                    let finalized = false; // Nueva bandera para controlar la finalización
                
                    interval = setInterval(function() {
                        if (totalTime <= 0) {
                            clearInterval(interval);
                            running = false;
                            modeFlag = null;
                
                            // Reproducir sonido de alerta
                            const alertSound = document.getElementById('alert-sound');
                            alertSound.play();
                
                            Swal.fire({
                                title: `¡Tiempo finalizado en la estación ${index + 1}!`,
                                text: 'El temporizador ha llegado a 0.',
                                icon: 'warning',
                                confirmButtonText: 'Aceptar'
                            });
                
                            // Cambiar color de fondo a rojo para indicar visualmente
                            $(`.timer-display[data-index="${index}"]`).css('background-color', 'red');
                            $(`.hours-input[data-index="${index}"], .minutes-input[data-index="${index}"], .time-controls button[data-index="${index}"], .btn-load-time[data-index="${index}"]`).prop('disabled', false).addClass('inactiva');
                
                            // Enviar información de finalización solo si no se ha hecho antes
                            if (!finalized) {
                                axios.post('detenerTiempo', {
                                    idHistorial: idHistorial
                                })
                                .then(response => {
                                    const data = response.data;
                                    if (data.status === 'success') {
                                        console.log('Tiempo detenido exitosamente.');
                                        finalized = true; // Marcar como finalizado
                                        localStorage.removeItem('idHistorial'); // Limpiar el ID del historial de localStorage si ya no es necesario
                                    } else {
                                        console.error('Error al detener el tiempo:', data.message);
                                    }
                                })
                                .catch(error => console.error('Error al detener el tiempo:', error));
                            }
                
                            idHistorial = null;
                            localStorage.removeItem(timerKey);
                            return;
                        }
                
                        totalTime--;
                        hour = Math.floor(totalTime / 3600);
                        min = Math.floor((totalTime % 3600) / 60);
                        sec = totalTime % 60;
                        updateDisplay();
                        saveTimer();
                        verificarNotificaciones(totalTime, index);
                    }, 1000);
                
                    running = true;
                    saveTimer();
                }
                
                            

                function startCountUp(idEquipo) {
                    if ($(`.timer-display[data-index="${index}"]`).css('background-color') === 'rgb(255, 0, 0)') {
                        $(`.timer-display[data-index="${index}"]`).css('background-color', '');
                    }
                    // Si es la primera vez que empieza y no está en pausa
                    if (!running && !paused) {
                        hour = min = sec = 0; // Reiniciar a 0 solo cuando empieza por primera vez
                        updateDisplay();
                        axios.post('iniciarTiempo', {
                            idEquipo: idEquipo
                        })
                        .then(response => {
                            const data = response.data;
                            if (data.idHistorial) {
                                idHistorial = data.idHistorial; // Guardar el ID del historial en la variable
                                saveTimer(); // Llamar a saveTimer para guardar el estado en localStorage
                                console.log('Tiempo iniciado. ID del historial guardado en localStorage:', data.idHistorial);
                            } else {
                                console.error('No se recibió el ID del historial.');
                            }
                        })
                        .catch(error => console.error('Error al iniciar el tiempo:', error));
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
                        totalTime++;
                        updateDisplay();
                        saveTimer();
                        verificarNotificaciones(totalTime, index);
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
                        paused = savedTimer.paused;
                        modeFlag = savedTimer.modeFlag;
                        idHistorial = savedTimer.idHistorial;
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
                    const index = $(this).data('index'); // Obtener el índice del botón clickeado
                    const idEquipo = $(`.station[data-index="${index}"]`).data('id'); // Obtener el idEquipo asociado a este índice
                    if (!running) {
                        startCountdown(idEquipo);
                        inhabilitarBotonesTemporizador();
                    }
                });

                $(`.btn-free-time[data-index="${index}"]`).on('click', function() {
                    const index = $(this).data('index'); // Obtener el índice del botón clickeado
                    const idEquipo = $(`.station[data-index="${index}"]`).data('id'); // Obtener el idEquipo asociado a este índice
                    if (!running) {
                        startCountUp(idEquipo);
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