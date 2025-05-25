<?php
class VistaInicio {
    public static function mostrar(): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> Reservas</p>';
        echo '<main>'; //Migas de pan antes del main
        echo "<h2>Reservas</h2>";
        echo '<form method="post">';
        if (isset($_SESSION['usuario_email'])) { //Sesión iniciada
            echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['usuario_email']) . "</h2>";
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
