<?php
require_once __DIR__ . '/../repositorios/ReservaRepositorio.php';

function iniciarReserva($pdo) {
    echo '<p>Formulario para iniciar reserva. (Pendiente de implementación)</p>';
}

function confirmarReserva($pdo) {
    $repo = new ReservaRepositorio($pdo);
    echo '<p>Reserva confirmada. (Lógica pendiente)</p>';
}

function cancelarReserva($pdo) {
    $repo = new ReservaRepositorio($pdo);
    echo '<p>Reserva cancelada. (Lógica pendiente)</p>';
}

