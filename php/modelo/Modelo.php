<?php
declare(strict_types=1);

abstract class Modelo
{
    // Métodos abstractos que deben implementar las clases hijas
    abstract public static function fromArray(array $data): static;
    abstract public static function toArray(): array;
}