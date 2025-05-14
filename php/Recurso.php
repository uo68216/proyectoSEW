<?php
declare(strict_types=1);
require_once 'Model.php';
require_once 'Validator.php';
require_once 'ModelValidationException.php';

class Recurso extends Model
{
    protected string $nombre;
    protected string $descripcion;
    protected int $tipoRecurso_id;

    public function __construct(?int $id, string $nombre, string $descripcion, int $tipoRecurso_id)
    {
        if (!is_null($id)) {
            Validator::validate(['id' => $id], ['id' => ['int', 'positive']]);
        }

        Validator::validate([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'tipoRecurso_id' => $tipoRecurso_id
        ], static::getValidationRules());

        parent::__construct($id ?? 0);
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->tipoRecurso_id = $tipoRecurso_id;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            isset($data['id']) ? (int)$data['id'] : null,
            (string)$data['nombre'],
            (string)$data['descripcion'],
            (int)$data['tipoRecurso_id']
        );
    }

    protected static function getTableName(): string
    {
        return 'recursos';
    }

    protected static function getValidationRules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'tipoRecurso_id' => ['required', 'int', 'positive']
        ];
    }

    // Getters
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getTipoRecursoId(): int
    {
        return $this->tipoRecurso_id;
    }
}