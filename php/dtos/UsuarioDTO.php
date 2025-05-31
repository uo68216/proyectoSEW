<?php
declare(strict_types=1);

require_once 'DTO.php';

class UsuarioDTO extends DTO
{
    private ?int $id;
    private string $nombre;
    private string $apellidos;
    private string $correoElectronico;
    private string $clave;

    public function __construct(
        ?int $id,
        string $nombre,
        string $apellidos,
        string $correoElectronico,
        string $clave
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correoElectronico = $correoElectronico;
        $this->clave = $clave;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            id: isset($data['id']) ? (int) $data['id'] : null,
            nombre:(string) $data['nombre'],
            apellidos:(string) $data['apellidos'],
            correoElectronico: (string) $data['correoElectronico'],
            clave:(string) $data['clave']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'correoElectronico' => $this->correoElectronico,
            'clave' => $this->clave
        ];
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
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
    public function getClave(): string
    {
        return $this->clave;
    }

    // Setters
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }
    public function setCorreoElectronico(string $correo): void
    {
        $this->correoElectronico = $correo;
    }
    public function setClave(string $clave): void
    {
        $this->clave = $clave;
    }
}