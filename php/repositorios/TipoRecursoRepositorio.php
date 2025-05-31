<?php
declare(strict_types=1);
require_once __DIR__ . '/Repositorio.php';
require_once __DIR__ . '/../dtos/TipoRecursoDTO.php';

class TipoRecursoRepositorio extends Repositorio{
    protected static function getNombreTabla(): string{
        return "tiporecursos";
    }
    protected static function getClaseDTO(): string{
        return TipoRecursoDTO::class;
    }

    public static function buscarTiposReservas():array{
        $table = static::getNombreTabla();
        $sql = "SELECT DISTINCT tipoReserva FROM $table";

        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            return $data ? $data : null;
        } catch (PDOException $e) {
            throw new DatabaseException("Error al buscar en '$table' los tipos de reservas" . $e->getMessage());
        }
    }
}