<?php
declare(strict_types=1);
require_once __DIR__ . '/../dtos/DTO.php';
require_once __DIR__ . '/../baseDatos/DatabaseException.php';

abstract class Repositorio
{
    protected static PDO $db;

    public function __construct(PDO $pdo) {
        self::$db = $pdo;
    }
  
    public static function crear(DTO $dto): int
    {
        // Extrae propiedades del objeto con toArray
        $data = $dto->toArray();
        // Elimina 'id', debe ser autogenerado por la BD
        unset($data['id']);

        $table = static::getNombreTabla();
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute($data);
            return (int) self::$db->lastInsertId();
        } catch (PDOException $e) {
            throw new DatabaseException("Error al crear el registro en '$table': " . $e->getMessage());
        }
    }

    public static function buscar(int $id): ?DTO  // Buscar por ID, retorna objeto de clase hija
    {
        $table = static::getNombreTabla();
        $sql = "SELECT * FROM $table WHERE id = :id";
        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $dtoClass = static::getClaseDTO(); // <- aquí se obtiene dinámicamente la clase DTO.
            return $data ? $dtoClass::fromArray($data) : null;
        } catch (PDOException $e) {
            throw new DatabaseException("Error al buscar en '$table' con ID $id: " . $e->getMessage());
        }
    }

    public static function buscarTodos(): array
    {
        $table = static::getNombreTabla();
        $sql = "SELECT * FROM $table";
        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dtoClass = static::getClaseDTO(); // Obtén dinámicamente la clase DTO.
            // Convertimos cada fila de datos a un objeto DTO y lo devolvemos como un array
            return array_map(fn($item) => $dtoClass::fromArray($item), $data);
        } catch (PDOException $e) {
            throw new DatabaseException("Error al buscar todos los registros en '$table': " . $e->getMessage());
        }
    }

    public static function actualizar(DTO $dto): bool
    {
        // Extrae propiedades del objeto con toArray
        $data = $dto->toArray();
        $campos = $dto->toArray();
        unset($campos['id']);// Eliminamos 'id' de los camnpos
        $id = $data['id'];

        if ($id === null || $id <= 0) {// Comprobamos si el 'id' es válido
            throw new InvalidArgumentException('El ID es obligatorio y debe ser mayor que cero.');
        }
        
        $table = static::getNombreTabla();
        $fields = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($campos)));
        $sql = "UPDATE $table SET $fields WHERE id = :id";
        try {
            $stmt = self::$db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new DatabaseException("Error al actualizar el registro en '$table' con ID $id: " . $e->getMessage());
        }
    }

    public static function borrar(int|DTO $dto): bool // Acepta un ID o un dto
    {
        // Si se recibe un objeto, obtenemos el ID del propio dto.
        if ($dto instanceof DTO){
            $data = $dto->toArray();
            $id = $data['id'];
        } else {
            $id= $dto;
        }
        if ($id === null || $id <= 0) { // Comprobamos si el 'id' es válido
            throw new InvalidArgumentException('ID inválido para eliminar el registro.');
        }

        $table = static::getNombreTabla();
        $sql = "DELETE FROM $table WHERE id = :id";
        try {
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new DatabaseException("Error al eliminar de '$table' con ID $id: " . $e->getMessage());
        }
    }

    /**
     * Permite ejecutar varias operaciones como una sola transacción
     * @param callable $operaciones
     * @throws DatabaseException
     * @return mixed
     */
    public static function ejecutarTransaccion(callable $operaciones): mixed
    {
        try {
            self::$db->beginTransaction();
            $resultado = $operaciones(); // Ejecuta las operaciones definidas
            self::$db->commit();
            return $resultado;
        } catch (Throwable $e) {
            self::$db->rollBack();
            throw new DatabaseException("Error en la transacción: " . $e->getMessage(), 0, $e);
        }
    }

    // Métodos abstractos que deben implementar las clases hijas
    abstract protected static function getNombreTabla(): string;
    abstract protected static function getClaseDTO(): string;
}