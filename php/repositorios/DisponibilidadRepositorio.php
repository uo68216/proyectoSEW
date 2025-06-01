<?php
declare(strict_types=1);
require_once __DIR__ . '/Repositorio.php';
require_once __DIR__ . '/../dtos/DisponibilidadDTO.php';

class DisponibilidadRepositorio extends Repositorio{
    protected static function getNombreTabla(): string{
        return "disponibilidades";
    }
    protected static function getClaseDTO(): string{
        return DisponibilidadDTO::class;
    }

    public static function buscarRecursosDisponibles(string $tipoReserva, string $fechaInicio, string $numeroPlazas): ?array
    {
        $sql = "SELECT recursos.id, 
                       tiporecursos.nombre AS tipo, recursos.nombre,
                       disponibilidades.fechaHoraInicio,
                       DATE_FORMAT(disponibilidades.fechaHoraInicio,'%H:%i') AS hora, 
                       disponibilidades.plazasDisponibles AS plazas, 
                       disponibilidades.precio
                FROM recursos
                INNER JOIN
                    tiporecursos ON recursos.tipoRecurso_id = tiporecursos.id
                INNER JOIN
                    disponibilidades ON disponibilidades.recurso_id = recursos.id
                WHERE disponibilidades.plazasDisponibles >= :numeroPlazas AND
                    DATE(disponibilidades.fechaHoraInicio) = :fechaInicio";
        if ($tipoReserva != "Todos"){
            $sql .=" AND tiporecursos.tipoReserva = :tipoReserva ";
        }
                    
        $fechaObjeto = DateTime::createFromFormat('d-m-Y', $fechaInicio);
        $fechaFormateada = $fechaObjeto->format('Ymd');

        try {
            $stmt = self::$db->prepare($sql);
            if ($tipoReserva != "Todos"){
                $stmt->execute(['numeroPlazas' => $numeroPlazas, 'fechaInicio' => $fechaFormateada, 'tipoReserva' => $tipoReserva]);
            }else{
                $stmt->execute(['numeroPlazas' => $numeroPlazas, 'fechaInicio' => $fechaFormateada]);
            }
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data ? $data : null;
        } catch (PDOException $e) {
            throw new DatabaseException("Error al buscar en disponibilidades con tipo de reserva = $tipoReserva, fechaInicio = $fechaInicio y numeroPlazas= $numeroPlazas ." . $e->getMessage());
        }
    }
}