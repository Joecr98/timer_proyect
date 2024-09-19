<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Estaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/globalEstilos.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/verEstaciones.css') ?>">
</head>

<body>
    <?php $this->load->view('barraNavegacion'); ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Estaciones</h2>
        <div class="row" id="sortable-estaciones">
            <?php foreach ($equipos as $index => $equipo) : ?>
                <div class="col-md-4 mb-4 <?php echo $equipo->estado == 0 ? 'inactiva' : ''; ?> station" data-id="<?php echo $equipo->idEquipo; ?>" data-index="<?php echo $index; ?>">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $equipo->nombre; ?></h5>
                            <p class="card-text">Descripción: <?php echo $equipo->descripcion; ?></p>
                            <p class="card-text">Estado: <span class="<?php echo $equipo->estado == 1 ? 'estado-activa' : 'estado-inactiva'; ?>">
                                    <?php echo $equipo->estado == 1 ? 'activa' : 'inactiva'; ?>
                                </span></p>

                            <!-- Mostrar el clima -->
                            <?php if (isset($weather)): ?>
                                <div>
                                    <h3>Clima actual</h3>
                                    <p>Temperatura: <?php echo $weather['main']['temp']; ?>°C</p>
                                    <p>Condiciones: <?php echo $weather['weather'][0]['description']; ?></p>
                                </div>
                            <?php endif; ?>

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

    <audio id="alert-sound" src="<?= base_url('assets/audio/sound_alert.mp3') ?>"></audio>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/js/verEstaciones.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>


</body>

</html>