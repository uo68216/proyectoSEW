<?php
declare(strict_types=1);
require_once __DIR__ . '/Repositorio.php';
require_once __DIR__ . '/../dtos/ReservaDTO.php';

class ReservaRepositorio extends Repositorio{
    protected static function getNombreTabla(): string{
        return "reservas";
    }
    protected static function getClaseDTO(): string{
        return ReservaDTO::class;
    }
}