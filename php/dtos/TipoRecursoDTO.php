<?php
declare(strict_types=1);

require_once 'DTO';

class TipoRecursoDTO extends DTO
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
        return new self(
            isset($data['id']) ? (int) $data['id'] : null,
            (string) $data['nombre']
        );
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
