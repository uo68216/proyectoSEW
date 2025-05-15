<?php
declare(strict_types=1);

require_once 'Modelo.php';

class Reserva extends Modelo
{

    private ?int $id;
    private ?int $usuario_id;
    private ?int $recurso_id;
    private DateTime $fechaHoraInicio;
    private DateTime $fechaHoraFin;
    private ?int $numeroPlazas;
    private float $precioPlaza;
    private float $precioTotal;

    public function __construct(
        ?int $id,
        ?int $usuario_id,
        ?int $recurso_id,
        DateTime $fechaHoraInicio,
        DateTime $fechaHoraFin,
        ?int $numeroPlazas,
        float $precioPlaza,
        float $precioTotal
    ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->recurso_id = $recurso_id;
        $this->fechaHoraInicio = $fechaHoraInicio;
        $this->fechaHoraFin = $fechaHoraFin;
        $this->numeroPlazas = $numeroPlazas;
        $this->precioPlaza = $precioPlaza;
        $this->precioTotal = $precioTotal;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            usuario_id: $data['usuario_id'] ?? null,
            recurso_id: $data['recurso_id'] ?? null,
            fechaHoraInicio: $data['fechaHoraInicio'] ?? null,
            fechaHoraFin: $data['fechaHoraFin'] ?? null,
            numeroPlazas: $data['numeroPlazas'] ?? null,
            precioPlaza: $data['precioPlaza'] ?? null,
            precioTotal: $data['precioTotal'] ?? null);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'recurso_id' => $this->recurso_id,
            'fechaHoraInicio' => $this->fechaHoraInicio,
            'fechaHoraFin' => $this->fechaHoraFin,
            'numeroPlazas' => $this->numeroPlazas,
            'precioPlaza' => $this->precioPlaza,
            'precioTotal' => $this->precioTotal,
        ];
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario_id(): ?int
    {
        return $this->usuario_id;
    }

    public function getRecurso_id(): ?int
    {
        return $this->recurso_id;
    }

    public function getFechaInicio(): string
    {
        return $this->fechaHoraInicio->format('d-m-Y');
    }

    public function getHoraInicio(): string
    {
        return $this->fechaHoraInicio->format('H-i');
    }

    public function getFechaFin(): string
    {
        return $this->fechaHoraFin->format('d-m-Y');
    }

    public function getHoraFin(): string
    {
        return $this->fechaHoraFin->format('H:i');
    }

    public function getNumeroPlazas(): ?int
    {
        return $this->numeroPlazas;
    }

    public function getPrecioPlaza(): float
    {
        return $this->precioPlaza;
    }

    public function getPrecioTotal(): float
    {
        return $this->precioTotal;
    }
}