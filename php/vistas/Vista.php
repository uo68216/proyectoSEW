<?php
declare(strict_types=1);

abstract class Vista{
    abstract public static function mostrar(?string $mensaje): void;
}
