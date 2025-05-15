<?php
declare(strict_types=1);

require_once 'Modelo.php';
class Recurso extends Modelo
{

    private ?int $id;
    private string $nombre;
    private string $descripcion;
    private ?int $tipoRecurso_id;

    public function __construct(
        ?int $id,
        string $nombre,
        string $descripcion,
        ?int $tipoRecurso_id
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->tipoRecurso_id = $tipoRecurso_id;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'] ?? null, $data['nombre'] ?? null, $data['descripcion'] ?? null, $data['tipoRecurso_id'] ?? null);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipoRecurso_id' => $this->tipoRecurso_id,
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

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getTipoRecurso_id(): ?int
    {
        return $this->tipoRecurso_id;
    }

    //Setters
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }
}
