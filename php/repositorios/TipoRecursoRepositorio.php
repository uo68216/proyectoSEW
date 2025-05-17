<?php
declare(strict_types=1);
require_once __DIR__ . '/Repositorio.php';
require_once __DIR__ . '/../dtos/TipoRecursoDTO.php';

class TipoRecursoRepositorio extends Repositorio{
    protected static function getNombreTabla(): string{
        return "tiporecursos";
    }
    protected static function getClaseDTO(): string{
        return TipoRecursoDTO::class;
    }
}