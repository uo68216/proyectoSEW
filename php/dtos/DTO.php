<?php
declare(strict_types=1);

abstract class DTO
{
    /**
     * Normaliza un precio ingresado como string.
     * - Elimina separadores de miles (.)
     * - Convierte comas a puntos
     * - Valida que sea numérico
     * - Devuelve un string con exactamente 2 decimales (usando punto)
     * @param string $valor
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function formatearPrecioParaMySQL(string $valor): string {
        $valor = trim($valor);
        $formato = self::detectarFormatoPrecio($valor);

        if ($formato === 'europeo') {
            // Eliminar puntos (miles) y convertir coma decimal a punto
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        } elseif ($formato === 'americano') {
            // Eliminar comas (miles)
            $valor = str_replace(',', '', $valor);
        }

        if (!is_numeric($valor)) {
            throw new InvalidArgumentException("El valor '$valor' no es un número válido.");
        }

        // Devolver con 2 decimales, como string
        return number_format((float)$valor, 2, '.', '');
    }
    
    /**
     * Detecta el formato de un número como string:
     * - Europeo: 1.234,56
     * - Americano: 1,234.56
     * - Entero sin separadores: asumido como americano
     *
     * @param string $valor
     * @return string 'europeo', 'americano'
     */
    public static function detectarFormatoPrecio(string $valor): string {
        $valor = trim($valor);

        // Contiene tanto ',' como '.' ⇒ decidir por orden
        if (strpos($valor, ',') !== false && strpos($valor, '.') !== false) {
            $ultimaComa = strrpos($valor, ',');
            $ultimoPunto = strrpos($valor, '.');
    
            // Si la coma está después del punto ⇒ europeo
            if ($ultimaComa > $ultimoPunto) {
                return 'europeo';
            } else {
                return 'americano';
            }
        }
    
        // Solo coma ⇒ europeo
        if (strpos($valor, ',') !== false) {
            return 'europeo';
        }
    
        // Solo punto ⇒ americano
        if (strpos($valor, '.') !== false) {
            return 'americano';
        }
    
        // Sin separadores ⇒ asumimos americano (ej. "1000")
        return 'americano';
    }

    /**
     * Formatea un precio para mostrar al usuario con formato europeo.
     * @param mixed $precio Recibe el número como float o string en formato americano
     * @return string Devuelve el número con 2 decimales y coma (formato europeo)
     */
    public static function formatearPrecioParaUsuario(float|string $precio): string {
        return number_format((float)$precio, decimals: 2, decimal_separator: ',', thousands_separator: '.');
    }

    /**
     * Convierte un string a un objeto dateTime
     * @param string $cadenaFechaHora Se espera el formato 'd-m-Y H:i'
     * @throws \InvalidArgumentException
     * @return bool|DateTime
     */
    public static function convertirStringADatetime(string $cadenaFechaHora): DateTime
    {
        $fecha = DateTime::createFromFormat('d-m-Y H:i', $cadenaFechaHora);
        if (!$fecha) {
            throw new InvalidArgumentException("Formato inválido de fecha: $cadenaFechaHora");
        }
        return $fecha;
    }

    /**
     * Obtiene una cadena desde un objeto DateTime en el formato compatible con MySQL
     * @param DateTime $fecha Objeto Datetime
     * @return string Cadena con el formato 'Y-m-d H:i:s'
     */
    public static function convertirDateTimeAStringSQL(DateTime $fecha): string{
        return $fecha->format('Y-m-d H:i:s');
    }

    // Métodos abstractos que deben implementar las clases hijas
    abstract public static function fromArray(array $data): static;
    abstract public static function toArray(): array;
    
}