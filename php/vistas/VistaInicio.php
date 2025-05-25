<?php
class VistaInicio {
    public static function mostrar(?string $email): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> Reservas</p>';
        echo '<main>'; //Migas de pan antes del main
        echo '<form method="post">';
        if ($email) {
            echo "<h2>Bienvenido, " . htmlspecialchars($email) . "</h2>";
            echo "<button type='submit' name='accion' value='ver_recursos'>Ver recursos</button>
                  <button type='submit' name='accion' value='mis_reservas'>Mis reservas</button>
                  <button type='submit' name='accion' value='logout'>Cerrar sesión</button>";
        } else {
            echo "<p>No has iniciado sesión.</p>
                  <button type='submit' name='accion' value='login'>Iniciar sesión</button>
                  <button type='submit' name='accion' value='registro'>Registrarse</button>";
        }
        echo "</form>";
        echo '</main>';
    }
}
