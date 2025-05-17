<?php
declare(strict_types=1);
require_once __DIR__ . '/Repositorio.php';
require_once __DIR__ . '/../dtos/UsuarioDTO .php';
require_once __DIR__ . '/../baseDatos/DatabaseException.php';

class UsuarioRepositorio extends Repositorio{
    protected static function getNombreTabla(): string{
        return "usuarios";
    }

    protected static function getClaseDTO(): string{
        return UsuarioDTO::class;
    }

    public static function buscarPorEmail(string $email): ?static
    {
        $table = static::getNombreTabla();
        $sql = "SELECT * FROM $table WHERE correoElectronico = :email";

        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute(['email' => $email]);
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            $dtoClass = static::getClaseDTO(); // <- aquí se obtiene dinámicamente la clase DTO.
            return $data ? $dtoClass::fromArray($data) : null;
        } catch (PDOException $e) {
            throw new DatabaseException("Error al buscar en '$table' el correo $email: " . $e->getMessage());
        }
    }
}