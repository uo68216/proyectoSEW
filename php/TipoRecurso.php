<?php
declare(strict_types=1);
require_once 'Model.php';
require_once 'Validator.php';
require_once 'ModelValidationException.php';

class TipoRecurso extends Model
{
    protected string $nombre;

    public function __construct(?int $id, string $nombre)
    {
        if (!is_null($id)) {
            Validator::validate(['id' => $id], ['id' => ['int', 'positive']]);
        }

        Validator::validate(['nombre' => $nombre], static::getValidationRules());

        parent::__construct($id ?? 0);
        $this->nombre = $nombre;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            isset($data['id']) ? (int)$data['id'] : null,
            (string)$data['nombre']
        );
    }

    protected static function getTableName(): string
    {
        return 'tipoRecursos';
    }
    
    protected static function getValidationRules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50']
        ];
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
}