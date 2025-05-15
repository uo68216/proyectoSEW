<?php
declare(strict_types=1);

class Disponibilidad
{

    private ?int $id;
    private int $recurso_id;
    private DateTime $fechaHoraInicio;
    private DateTime $fechaHoraFin;
    private int $totalPlazas;
    private int $plazasDisponibles;
    private float $precio;

    public function __construct(
        ?int $id,
        int $recurso_id,
        DateTime $fechaHoraInicio,
        DateTime $fechaHoraFin,
        int $totalPlazas,
        int $plazasDisponibles,
        float $precio
    ) {
        $this->id = $id;
        $this->recurso_id = $recurso_id;
        $this->fechaHoraInicio = $fechaHoraInicio;
        $this->fechaHoraFin = $fechaHoraFin;
        $this->totalPlazas = $totalPlazas;
        $this->plazasDisponibles = $plazasDisponibles;
        $this->precio = $precio;
    }

    public static function fromArray(array $data): self
    {

        return new self($data['id'] ?? null, $data['recurso_id'] ?? null, $data['fechaInicio'] ?? null, $data['horaInicio'] ?? null, $data['fechaFin'] ?? null, $data['horaFin'] ?? null, $data['totalPlazas'] ?? null, $data['plazasDisponibles'] ?? null, $data['precio'] ?? null);

    }

    public function toArray(): array
    {

        return [
            'id' => $this->id,
            'recurso_id' => $this->recurso_id,
            'fechaInicio' => $this->fechaInicio,
            'horaInicio' => $this->horaInicio,
            'fechaFin' => $this->fechaFin,
            'horaFin' => $this->horaFin,
            'totalPlazas' => $this->totalPlazas,
            'plazasDisponibles' => $this->plazasDisponibles,
            'precio' => $this->precio,
        ];
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecurso_id(): ?int
    {
        return $this->recurso_id;
    }

    public function getFechaInicio(): \DateTime
    {
        return $this->fechaHoraInicio->format('d-m-Y');
    }

    public function getHoraInicio(): \DateTime
    {
        return $this->fechaHoraInicio->format('H-i');
    }

    public function getFechaFin(): \DateTime
    {
        return $this->fechaHoraFin->format('d-m-Y');
    }

    public function getHoraFin(): \DateTime
    {
        return $this->fechaHoraFin->format('H:i');
    }

    public function getTotalPlazas(): ?int
    {
        return $this->totalPlazas;
    }

    public function getPlazasDisponibles(): ?int
    {
        return $this->plazasDisponibles;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }
}
