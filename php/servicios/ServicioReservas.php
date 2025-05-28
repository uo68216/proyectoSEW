<?php
require_once __DIR__ . '/../vistas/VistaNuevaReserva.php';

class ServicioReservas {
    public static function verRecursos(PDO $pdo): void {
        $_SESSION['fecha_Inicio'] = $_POST['fechaInicio'];
        $_SESSION['numero_Plazas'] = $_POST['plazas'];
        VistaNuevaReserva::mostrar();
    }

    public static function iniciarReserva(PDO $pdo, array $datos): void {
        // TODO: Iniciar el proceso de reserva con los datos recibidos
    }

    public static function confirmarReserva(PDO $pdo, array $datos): void {
        // TODO: Confirmar y registrar la reserva en base de datos
    }

    public static function obtenerReservasUsuario(PDO $pdo, int $usuarioId): array {
        // TODO: Devolver reservas asociadas al usuario
        return [];
    }

    public static function verDetalleReserva(PDO $pdo, int $reservaId): array {
        // TODO: Devolver detalles de una reserva específica
        return [];
    }

    public static function cancelarReserva(PDO $pdo, int $reservaId): void {
        // TODO: Cancelar la reserva especificada
    }
}
