<?php
declare(strict_types=1);
require_once 'Validator.php';
require_once 'DatabaseException.php';

abstract class Model
{
    protected int $id;
    protected static PDO $db;

    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function create(array|Model $data): int // Permite array o objeto de clase hija
    {
        if ($data instanceof self) {
            // Extrae propiedades del objeto (públicas y protegidas)
            $data = get_object_vars($data);
            // Elimina 'id' si lo tienes como null o 0 para evitar insertar manualmente
            unset($data['id']); // ID debe ser autogenerado por la BD
        }

        Validator::validate($data, static::getValidationRules());
        
        $table = static::getTableName();
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute($data);
            return (int)self::$db->lastInsertId();
        } catch (\PDOException $e) {
            throw new DatabaseException("Error al crear el registro en '$table': " . $e->getMessage());
        }
    }

    public static function find(int $id): ?static  // Buscar por ID, retorna objeto de clase hija
    {
        $table = static::getTableName();
        $sql = "SELECT * FROM $table WHERE id = :id";
        try {
            $stmt = self::$db->prepare($sql);
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? static::fromArray($data) : null;
        } catch (\PDOException $e) {
            throw new DatabaseException("Error al buscar en '$table' con ID $id: " . $e->getMessage());
        }
    }
    
    public static function update(array|Model $data, ?int $id = null): bool // También permite array o objeto con detección de ID
    {
        if ($data instanceof self) {
            // Extrae datos y recupera el ID del objeto
            $id = $data->getId();
            $data = get_object_vars($data);
        }

        if ($id === null || $id <= 0){
            throw new InvalidArgumentException('El ID es obligatorio y debe ser mayor que cero.');
        }
        Validator::validate($data, static::getValidationRules());

        $table = static::getTableName();
        $fields = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($data)));
        $sql = "UPDATE $table SET $fields WHERE id = :id";
        try {
            $stmt = self::$db->prepare($sql);
            return $stmt->execute($data);
        } catch (\PDOException $e) {
            throw new DatabaseException("Error al actualizar el registro en '$table' con ID $id: " . $e->getMessage());
        }
    }

    public static function delete(int|Model $target): bool // Acepta un ID o una instancia del modelo
    {
        // Si se recibe un objeto, obtenemos el ID
        $id = $target instanceof self ? $target->getId() : $target;

        if ($id <= 0) {
            throw new InvalidArgumentException('ID inválido para eliminar el registro.');
        }

        $table = static::getTableName();
        $sql = "DELETE FROM $table WHERE id = :id";
        try {
            $stmt = self::$db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (\PDOException $e) {
            throw new DatabaseException("Error al eliminar de '$table' con ID $id: " . $e->getMessage());
        }
    }
    
    // Métodos abstractos que deben implementar las clases hijas
    abstract public static function fromArray(array $data): static;
    abstract protected static function getTableName(): string;
    abstract protected static function getValidationRules(): array;
}