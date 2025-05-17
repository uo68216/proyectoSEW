<?php
declare(strict_types=1);
require_once 'Model.php';
require_once 'Validator.php';
require_once 'ModelValidationException.php';

class Reserva extends Model
{
    protected int $usuario_id;
    protected int $recurso_id;
    protected string $fechaHoraInicio;
    protected string $horaInicio;
    protected string $fechaHoraFin;
    protected string $horaFin;
    protected int $numeroPlazas;
    protected float $precioPlaza;
    protected float $precioTotal;

    public function __construct(
        ?int $id,
        int $usuario_id,
        int $recurso_id,
        string $fechaInicio,
        string $horaInicio,
        string $fechaFin,
        string $horaFin,
        int $numeroPlazas,
        float $precioPlaza,
        float $precioTotal
    ) {
        if (!is_null($id)) {
            Validator::validate(['id' => $id], ['id' => ['int', 'positive']]);
        }
        
        Validator::validate([
            'usuario_id' => $usuario_id,
            'recurso_id' => $recurso_id,
            'fechaInicio' => $fechaInicio,
            'horaInicio' => $horaInicio,
            'fechaFin' => $fechaFin,
            'horaFin' => $horaFin,
            'numeroPlazas' => $numeroPlazas,
            'precioPlaza' => $precioPlaza,
            'precioTotal' => $precioTotal
        ], static::getValidationRules());

        parent::__construct($id ?? 0);
        $this->usuario_id = $usuario_id;
        $this->recurso_id = $recurso_id;
        $this->fechaHoraInicio = $fechaInicio;
        $this->horaInicio = $horaInicio;
        $this->fechaHoraFin = $fechaFin;
        $this->horaFin = $horaFin;
        $this->numeroPlazas = $numeroPlazas;
        $this->precioPlaza = $precioPlaza;
        $this->precioTotal = $precioTotal;
    }
    public static function fromArray(array $data): static
    {
        {
            return new static(
                isset($data['id']) ? (int)$data['id'] : null,
                (int)$data['usuario_id'],
                (int)$data['recurso_id'],
                (string)$data['fechaInicio'],
                (string)$data['horaInicio'],
                (string)$data['fechaFin'],
                (string)$data['horaFin'],
                (int)$data['numeroPlazas'],
                (float)$data['precioPlaza'],
                (float)$data['precioTotal']
            );
        }
    }

    protected static function getTableName(): string
    {
        return 'reservas';
    }
    
    protected static function getValidationRules(): array
    {
        return [
            'usuario_id' => ['required', 'int', 'positive'],
            'recurso_id' => ['required', 'int', 'positive'],
            'fechaInicio' => ['required', 'date'],
            'horaInicio' => ['required', 'time'],
            'fechaFin' => ['required', 'date'],
            'horaFin' => ['required', 'time'],
            'numeroPlazas' => ['required', 'int', 'positive'],
            'precioPlaza' => ['required', 'decimal', 'positive'],
            'precioTotal' => ['required', 'decimal', 'positive']
        ];
    }

    // Getters
    public function getFechaInicio(): string
    {
        return $this->fechaHoraInicio;
    }

    public function getHoraInicio(): string
    {
        return $this->horaInicio;
    }

    public function getFechaFin(): string
    {
        return $this->fechaHoraFin;
    }

    public function getHoraFin(): string
    {
        return $this->horaFin;
    }

    public function getNumeroPlazas(): int
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