<?php
declare(strict_types=1);

require_once 'DTO.php';
class DisponibilidadDTO extends DTO
{
    private ?int $id;
    private int $recurso_id;
    private DateTime $fechaHoraInicio;
    private DateTime $fechaHoraFin;
    private int $totalPlazas;
    private int $plazasDisponibles;
    private string $precio;

    public function __construct(
        ?int $id,
        int $recurso_id,
        string|DateTime $fechaHoraInicio,
        string|DateTime $fechaHoraFin,
        int $totalPlazas,
        int $plazasDisponibles,
        string $precio
    ) {
        $this->id = $id;
        $this->recurso_id = $recurso_id;
        $this->fechaHoraInicio =  $fechaHoraInicio instanceof DateTime
            ? $fechaHoraInicio
            : self::convertirStringADatetime($fechaHoraInicio);
        $this->fechaHoraFin = $fechaHoraFin instanceof DateTime
            ? $fechaHoraFin
            : self::convertirStringADatetime($fechaHoraFin);
        $this->totalPlazas = $totalPlazas;
        $this->plazasDisponibles = $plazasDisponibles;
        $this->precio = self::formatearPrecioParaMySQL($precio);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (int) $data['id'] : null,
            (int) $data['recurso_id'],
            new DateTime ($data['fechaHoraInicio']),
            new DateTime ($data['fechaHoraFin']) ,
            (int) $data['totalPlazas'],
            (int) $data['plazasDisponibles'],
            (string) $data['precio']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'recurso_id' => $this->recurso_id,
            'fechaHoraInicio' => self::convertirDateTimeAStringSQL($this->fechaHoraInicio),
            'fechaHoraFin' => self::convertirDateTimeAStringSQL($this->fechaHoraFin),
            'totalPlazas' => $this->totalPlazas,
            'plazasDisponibles' => $this->plazasDisponibles,
            'precio' => $this->precio,
        ];
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecurso_id(): int
    {
        return $this->recurso_id;
    }

    public function getFechaHoraInicio(): string
    {
        return $this->fechaHoraInicio->format('d-m-Y H:i');
    }
    public function getFechaInicio(): string
    {
        return $this->fechaHoraInicio->format('d-m-Y');
    }

    public function getHoraInicio(): string
    {
        return $this->fechaHoraInicio->format('H-i');
    }

    public function getFechaHoraFin(): string
    {
        return $this->fechaHoraFin->format('d-m-Y H:i');
    }
    public function getFechaFin(): string
    {
        return $this->fechaHoraFin->format('d-m-Y');
    }

    public function getHoraFin(): string
    {
        return $this->fechaHoraFin->format('H:i');
    }

    public function getTotalPlazas(): int
    {
        return $this->totalPlazas;
    }

    public function getPlazasDisponibles(): int
    {
        return $this->plazasDisponibles;
    }

    public function getPrecio(): string
    {
        return self::formatearPrecioParaUsuario($this->precio);
    }
}
