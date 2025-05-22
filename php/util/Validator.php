<?php
declare(strict_types=1);
class Validador
{
    public static function validarNoNulo($valor, $campo, &$errores)
    {
        if (empty(trim($valor))) {
            $errores[$campo] = "El campo $campo no puede estar vacío.";
        }
    }

    public static function validarLongitudMinima($valor, $campo, $longitud, &$errores)
    {
        if (strlen($valor) < $longitud) {
            $errores[$campo] = "El campo $campo debe tener una longitud de al menos $longitud caracteres.";
        }
    }

    public static function validarEmail($valor, $campo, &$errores)
    {
        if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
            $errores[$campo] = "El correo electrónico no es válido.";
        }
    }
}