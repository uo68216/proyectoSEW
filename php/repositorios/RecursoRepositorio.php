<?php
declare(strict_types=1);
require_once __DIR__ . '/Repositorio.php';
require_once __DIR__ . '/../dtos/RecursoDTO.php';

class RecursoRepositorio extends Repositorio{
    protected static function getNombreTabla(): string{
        return "recursos";
    }
    protected static function getClaseDTO(): string{
        return RecursoDTO::class;
    }
}