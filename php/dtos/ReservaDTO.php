<?php
declare(strict_types=1);

require_once 'DTO.php';

class ReservaDTO extends DTO
{
    private ?int $id;
    private int $usuario_id;
    private int $recurso_id;
    private DateTime $fechaHoraInicio;
    private DateTime $fechaHoraFin;
    private int $numeroPlazas;
    private string $precioPlaza;
    
    public function __construct(
        ?int $id,
        int $usuario_id,
        int $recurso_id,
        string|DateTime $fechaHoraInicio,
        string|DateTime $fechaHoraFin,
        int $numeroPlazas,
        string $precioPlaza,
        ) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->recurso_id = $recurso_id;
        $this->fechaHoraInicio =  $fechaHoraInicio instanceof DateTime
            ? $fechaHoraInicio
            : self::convertirStringADatetime($fechaHoraInicio);
        $this->fechaHoraFin = $fechaHoraFin instanceof DateTime
            ? $fechaHoraFin
            : self::convertirStringADatetime($fechaHoraFin);
        $this->numeroPlazas = $numeroPlazas;
        $this->precioPlaza = self::formatearPrecioParaMySQL($precioPlaza);

    }

    public static function fromArray(array $data): static
    {
        return new self(
            id: isset($data['id']) ? (int) $data['id'] : null,
            usuario_id: (int) $data['usuario_id'] ,
            recurso_id: (int) $data['recurso_id'] ,
            fechaHoraInicio: new DateTime ($data['fechaHoraInicio']) ,
            fechaHoraFin: new DateTime ($data['fechaHoraFin']),
            numeroPlazas: (int) $data['numeroPlazas'] ?? null,
            precioPlaza: (string) $data['precioPlaza'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'recurso_id' => $this->recurso_id,
            'fechaHoraInicio' => self::convertirDateTimeAStringSQL($this->fechaHoraInicio),
            'fechaHoraFin' => self::convertirDateTimeAStringSQL($this->fechaHoraFin),
            'numeroPlazas' => $this->numeroPlazas,
            'precioPlaza' => $this->precioPlaza
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

    public function getNumeroPlazas(): ?int
    {
        return $this->numeroPlazas;
    }

    public function getPrecioPlaza(): string
    {
        return self::formatearPrecioParaUsuario($this->precioPlaza);
    }

    public function getPrecioTotal(): string
    {
        $precioTotal = bcmul($this->precioPlaza, strval($this->numeroPlazas), 2);
        return self::formatearPrecioParaUsuario($precioTotal);
    }
}