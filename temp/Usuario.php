<?php declare(strict_types=1);

class Usuario {
    private string $nombre;
    private int $edad;

    public function __construct(string $nombre, int $edad) {
        $this->nombre = $nombre;
        $this->edad = $edad;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setEdad(int $edad): void {
        $this->edad = $edad;
    }

    public function getEdad(): int {
        return $this->edad;
    }

    public function saludar(): string {
        return "Hola, mi nombre es $this->nombre y tengo $this->edad años.";
    }
}

?>