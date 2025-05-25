<?php
class VistaLogin {
    public static function mostrar(string $mensaje = ''): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> <a href="reservas.php">Reservas</a> >> Inicio</p>';    
        echo '<main>'; //Migas de pan antes del main
        
        //Si estamos recargando el formulario recuperamos los datos ya introducidos
        $correoElectronico = isset($_POST['correoElectronico']) ? htmlspecialchars($_POST['correoElectronico']) :'';
        $contraseña = isset($_POST['contraseña']) ? htmlspecialchars($_POST['contraseña']) :'';

        $html = <<<HTML
        <h2>Reservas</h2>
        
        <form name="formularioAuxiliar" method='post'>
            <p>Para reservar es necesario registrarse. Si no estas registrado puedes hacerlo pulsando sobre 
            <button type='submit' name='accion' value='registro'>Registrar</button></p>
        </form>
        
        <p>Si ya estás registrado puedes iniciar sesión facilitando tu correo electrónico y contraseña.</p>
        <form name="formularioLogin" method="post">
            <fieldset>
                <legend>Iniciar sesión</legend>
                <label for="correoElectronico">Correo electrónico:</label>
                <input id="correoElectronico" type="email" name="correoElectronico" required value=$correoElectronico>

                <label for="contraseña">Contraseña:</label>
                <input id="contraseña" type="password" name="contraseña" required value=$contraseña>
                
                <button type="submit" name="accion" value="login">Iniciar sesión</button>
            </fieldset>
        </form>
        HTML;

        echo $html;
        if ($mensaje){
            echo "<p>$mensaje</p>";
        }
        echo '</main>';
    }
}
