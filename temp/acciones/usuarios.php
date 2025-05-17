<?php
require_once __DIR__ . '/../repositorios/ReservaRepositorio.php';

function mostrarReservasUsuario($pdo) {
    $repo = new ReservaRepositorio($pdo);
    $reservas = $repo->buscarPorUsuario($_SESSION['usuario_id']);
    echo '<h2>Mis reservas</h2>';
    foreach ($reservas as $reserva) {
        echo '<div>Reserva #' . $reserva->getId() . '</div>';
    }
}

function verDetalleReserva($pdo) {
    echo '<p>Detalles de la reserva (pendiente)</p>';
}
