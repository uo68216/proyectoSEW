<?php
require_once __DIR__ . '/../vistas/VistaNuevaReserva.php';
require_once __DIR__ . '/../repositorios/TipoRecursoRepositorio.php';
require_once __DIR__ . '/../repositorios/DisponibilidadRepositorio.php';

class ServicioReservas {
    private static $tiposReservas = [];
    public static function verRecursos(PDO $pdo): void {
        if (isset($_POST['tipoReserva'])){
            $_SESSION['tipo_Reserva'] = $_POST['tipoReserva'];
        }
        if (isset($_POST['fechaInicio'])){
            $_SESSION['fecha_Inicio'] = $_POST['fechaInicio'];
        }
        if (isset($_POST['plazas'])){
            $_SESSION['numero_Plazas'] = $_POST['plazas'];
        }

        $tiposReservas = self::getTiposReservas($pdo);
        $recursosDisponibles = self::getRecursosDisponibles($pdo);
        VistaNuevaReserva::mostrar($tiposReservas, $recursosDisponibles);
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

    private static function getTiposReservas(PDO $pdo):array{
        if (self::$tiposReservas == []){            
            $repo = new TipoRecursoRepositorio($pdo);
            self::$tiposReservas = $repo->buscarTiposReservas();
        }
        return self::$tiposReservas;
    }

    private static function getRecursosDisponibles(Pdo $pdo) : array{
        $tipoReserva = isset($_SESSION['tipo_Reserva']) ? $_SESSION['tipo_Reserva'] :'Todos';
        $fechaInicio = isset($_SESSION['fecha_Inicio']) ? $_SESSION['fecha_Inicio'] : (new DateTime())->format('d-m-Y');
        $numeroPlazas = isset($_SESSION['numero_Plazas']) ? $_SESSION['numero_Plazas'] :'1';
              
        $repo = new DisponibilidadRepositorio($pdo);
        return $repo->buscarRecursosDisponibles($tipoReserva, $fechaInicio, $numeroPlazas); 
    }
}
