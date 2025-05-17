<?php
declare(strict_types=1);
require_once 'Model.php';
require_once 'Validator.php';
require_once 'ModelValidationException.php';

class Disponibilidad extends Model
{
    protected int $recurso_id;
    protected string $fechaInicio;
    protected string $horaInicio;
    protected string $fechaFin;
    protected string $horaFin;
    protected int $totalPlazas;
    protected int $plazasDisponibles;
    protected float $precio;

    public function __construct(
        ?int $id,
        int $recurso_id,
        string $fechaInicio,
        string $horaInicio,
        string $fechaFin,
        string $horaFin,
        int $totalPlazas,
        int $plazasDisponibles,
        float $precio
    ) {
        if (!is_null($id)) {
            Validator::validate(['id' => $id], ['id' => ['int', 'positive']]);
        }

        Validator::validate([
            'recurso_id' => $recurso_id,
            'fechaInicio' => $fechaInicio,
            'horaInicio' => $horaInicio,
            'fechaFin' => $fechaFin,
            'horaFin' => $horaFin,
            'totalPlazas' => $totalPlazas,
            'plazasDisponibles' => $plazasDisponibles,
            'precio' => $precio
        ], static::getValidationRules());

        parent::__construct($id ?? 0);
        $this->recurso_id = $recurso_id;
        $this->fechaInicio = $fechaInicio;
        $this->horaInicio = $horaInicio;
        $this->fechaFin = $fechaFin;
        $this->horaFin = $horaFin;
        $this->totalPlazas = $totalPlazas;
        $this->plazasDisponibles = $plazasDisponibles;
        $this->precio = $precio;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            isset($data['id']) ? (int)$data['id'] : null,
            (int)$data['recurso_id'],
            (string)$data['fechaInicio'],
            (string)$data['horaInicio'],
            (string)$data['fechaFin'],
            (string)$data['horaFin'],
            (int)$data['totalPlazas'],
            (int)$data['plazasDisponibles'],
            (float)$data['precio']
        );
    }

    protected static function getTableName(): string
    {
        return 'disponibilidades';
    }

    protected static function getValidationRules(): array
    {
        return [
            'recurso_id' => ['required', 'int', 'positive'],
            'fechaInicio' => ['required', 'date'],
            'horaInicio' => ['required', 'time'],
            'fechaFin' => ['required', 'date'],
            'horaFin' => ['required', 'time'],
            'totalPlazas' => ['required', 'int', 'positive'],
            'plazasDisponibles' => ['required', 'int', 'positive'],
            'precio' => ['required', 'decimal', 'positive']
        ];
    }

    // Getters
    public function getFechaInicio(): string
    {
        return $this->fechaInicio;
    }

    public function getHoraInicio(): string
    {
        return $this->horaInicio;
    }

    public function getFechaFin(): string
    {
        return $this->fechaFin;
    }

    public function getHoraFin(): string
    {
        return $this->horaFin;
    }

    public function getTotalPlazas(): int
    {
        return $this->totalPlazas;
    }

    public function getPlazasDisponibles(): int
    {
        return $this->plazasDisponibles;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }
}