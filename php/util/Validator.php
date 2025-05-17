<?php
declare(strict_types=1);
class Validator
{
    public static function validate(array $data, array $rules): void
    {
        foreach ($rules as $field => $validators) {
            $value = $data[$field] ?? null;

            foreach ($validators as $rule) {
                if (str_starts_with($rule, 'min:')) {
                    $min = (int)explode(':', $rule)[1];
                    self::min($field, $value, $min);
                } elseif (str_starts_with($rule, 'max:')) {
                    $max = (int)explode(':', $rule)[1];
                    self::max($field, $value, $max);
                } else {
                    self::applyRule($rule, $field, $value, $data);
                }
            }
        }
    }

    protected static function applyRule(string $rule, string $field, $value, array $data): void
    {
        match ($rule) {
            'required' => self::required($field, $data),
            'int'      => self::int($field, $value),
            'positive' => self::positive($field, $value),
            'email'    => self::email($field, $value),
            'string'   => self::string($field, $value),
            'date'     => self::date($field, $value),
            'time'     => self::time($field, $value),
            'decimal'  => self::decimal($field, $value),
            default    => throw new InvalidArgumentException("Regla de validación desconocida: $rule"),
        };
    }

    protected static function required(string $field, array $data): void
    {
        if (!array_key_exists($field, $data)) {
            throw new ModelValidationException("Falta el campo obligatorio: $field");
        }
    }

    protected static function int(string $field, $value): void
    {
        if (isset($value) && !is_numeric($value)) {
            throw new ModelValidationException("El campo '$field' debe ser numérico.");
        }
    }

    protected static function positive(string $field, $value): void
    {
        if (isset($value) && (int)$value <= 0) {
            throw new ModelValidationException("El campo '$field' debe ser mayor que cero.");
        }
    }

    protected static function email(string $field, $value): void
    {
        if (isset($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ModelValidationException("Email inválido en '$field': $value");
        }
    }

    protected static function string(string $field, $value): void
    {
        if (isset($value) && !is_string($value)) {
            throw new ModelValidationException("El campo '$field' debe ser una cadena.");
        }
    }

    protected static function min(string $field, $value, int $min): void
    {
        if (isset($value) && strlen((string)$value) < $min) {
            throw new ModelValidationException("El campo '$field' debe tener al menos $min caracteres.");
        }
    }

    protected static function max(string $field, $value, int $max): void
    {
        if (isset($value) && strlen((string)$value) > $max) {
            throw new ModelValidationException("El campo '$field' no debe superar los $max caracteres.");
        }
    }

    protected static function date(string $field, $value): void
    {
        if (isset($value) && !strtotime($value)) {
            throw new ModelValidationException("El campo '$field' debe ser una fecha válida.");
        }
    }

    protected static function time(string $field, $value): void
    {
        if (isset($value) && !preg_match('/^([01]?[0-9]|2[0-3]):([0-5]?[0-9])$/', $value)) {
            throw new ModelValidationException("El campo '$field' debe ser una hora válida.");
        }
    }

    protected static function decimal(string $field, $value): void
    {
        if (isset($value) && !is_numeric($value)) {
            throw new ModelValidationException("El campo '$field' debe ser un número decimal.");
        }
    }
}
