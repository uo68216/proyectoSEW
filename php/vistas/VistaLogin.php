<?php
class VistaLogin {
    public static function mostrar(string $mensaje = ''): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> <a href="reservas.php">Reservas</a> >> Iniciar sesión</p>';    
        echo '<main>'; //Migas de pan antes del main
        $html = <<<HTML
        <h2>Iniciar sesión</h2>
        <form name="formularioLogin" method="post">
            <fieldset>
                <label for="email">Email:</label>
                <input id="email" type="email" name="email" required>

                <label for="password">Contraseña:</label>
                <input id="password" type="password" name="password" required>
                
                <button type="submit" name="accion" value="login">Iniciar sesión</button>
            </fieldset>
        </form>
        HTML;

        echo $html;
        if ($mensaje){
            echo "<p>$mensaje</p>";
        }
        
        $html2 = <<<HTML
            <form name="formularioAuxiliar" method='post'>
                <p>Si no estas registrado puedes hacerlo pulsando sobre 
                    <button type='submit' name='accion' value='registro'>Registrar</button></p>
                <p>Puedes volver a la página inicial pulsando sobre 
                    <button type='submit' name='accion' value='cancelarLogin'>Cancelar</button>
            </form>
            HTML;
        echo $html2;
        echo '</main>';
    }
}
