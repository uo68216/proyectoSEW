<?php
class VistaRegistro {
    public static function mostrar(string $mensaje = ''): void {
        if ($mensaje){
            echo "<p>$mensaje</p>";
        }
        echo "<h2>Registro</h2>
        <form method='post'>
            <input type='hidden' name='accion' value='registro'>
            Nombre: <input type='text' name='nombre' required><br>
            Apellidos: <input type='text' name='apellidos' required><br>
            Email: <input type='email' name='email' required><br>
            Contraseña: <input type='password' name='password' required><br>
            <button type='submit'>Registrarse</button>
        </form>";
    }
}
