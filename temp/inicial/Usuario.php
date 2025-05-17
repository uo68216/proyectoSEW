<?php 
declare(strict_types=1);
require_once 'Model.php';
require_once 'Validator.php';
require_once 'ModelValidationException.php';

class Usuario extends Model
{
    protected string $nombre;
    protected string $apellidos;
    protected string $correoElectronico;
    protected string $clave;

    public function __construct(?int $id, string $nombre, string $apellidos, string $correoElectronico, string $clave)
    {
        if (!is_null($id)) {
            Validator::validate(['id' => $id], ['id' => ['int', 'positive']]);
        }
        
        Validator::validate([
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'correoElectronico' => $correoElectronico,
            'clave' => $clave
        ], static::getValidationRules());

        parent::__construct($id ?? 0);
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correoElectronico = $correoElectronico;
        $this->clave = $clave;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            isset($data['id']) ? (int)$data['id'] : null,
            (string)$data['nombre'],
            (string)$data['apellidos'],
            (string)$data['correoElectronico'],
            (string)$data['clave']
        );
    }

    protected static function getTableName(): string
    {
        return 'usuarios';
    }

    protected static function getValidationRules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:50'],
            'apellidos' => ['required', 'string', 'max:100'],
            'correoElectronico' => ['required', 'email', 'max:150'],
            'clave' => ['required', 'string', 'min:6']
        ];
    }

    // Getters 
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }
    
    public function getCorreoElectronico(): string
    {
        return $this->correoElectronico;
    }

}