<?php
declare(strict_types=1);

require_once 'DTO.php';

class TipoRecursoDTO extends DTO
{
    private ?int $id;
    private string $nombre;
    private string $tipoReserva;

    public function __construct(
        ?int $id,
        string $nombre,
        string $tipoReserva
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipoReserva = $tipoReserva;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            id: isset($data['id']) ? (int) $data['id'] : null,
            nombre: (string) $data['nombre'],
            tipoReserva: (string) $data['tipoReserva']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'tipoReserva' => $this->tipoReserva
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

    public function getTipoReserva(): string
    {
        return $this->tipoReserva;
    }
    
    //Setters
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setTipoReserva($tipoReserva): void
    {
        $this->tipoReserva = $tipoReserva;
    }
}
