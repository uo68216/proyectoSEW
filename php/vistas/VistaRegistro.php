<?php
class VistaRegistro {
    public static function mostrar(string $mensaje = '', array $errores): void {
        $html = <<<HTML
            <h2>Registro</h2>
            <form method='post'>
                <input type='hidden' name='accion' value='registro'>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type='text' name='nombre' required>
                
                Apellidos: <input type='text' name='apellidos' required><br>
                Correo electrónico: <input type='email' name='correo electronico' required><br>
                Contraseña: <input type='password' name='contraseña' required><br>
                Repetir contraseña: <input type='password' name='repetirContraseña' required><br>
                <button type='submit'>Registrarse</button>
            </form>
            HTML;

        echo $html;
        if ($mensaje){
            echo "<p>$mensaje</p>";
        }
    }
}
