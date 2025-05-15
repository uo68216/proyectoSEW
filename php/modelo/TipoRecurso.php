<?php
declare(strict_types=1);

require_once 'Modelo.php';

class TipoRecurso extends Modelo
{
    private ?int $id;
    private string $nombre;

    public function __construct(
        ?int $id,
        string $nombre
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'] ?? null, $data['nombre'] ?? null);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
        ];
    }

    //Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    
    //Setters
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }
}
