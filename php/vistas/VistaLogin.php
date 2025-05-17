<?php
class VistaLogin {
    public static function mostrar(string $mensaje = ''): void {
        if ($mensaje) echo "<p>$mensaje</p>";
        echo '<h2>Iniciar sesión</h2>
        <form method="post">
            <input type="hidden" name="accion" value="login">
            Email: <input type="email" name="email" required><br>
            Contraseña: <input type="password" name="password" required><br>
            <button type="submit">Iniciar sesión</button>
        </form>';
    }
}
