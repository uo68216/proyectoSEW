<?php
class VistaRegistro {
    public static function mostrar(string $mensaje = ''): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> <a href="reservas.php">Reservas</a> >> Registro</p>';    
        echo '<main>'; //Migas de pan antes del main
        
        //Si estamos recargando el formulario recuperamos los datos ya introducidos
        $nombre = isset($_POST['nombre']) ?  htmlspecialchars($_POST['nombre']) : '';
        $apellidos = isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : '';
        $correoElectronico = isset($_POST['correoElectronico']) ? htmlspecialchars($_POST['correoElectronico']) :'';
        $contraseña = isset($_POST['contraseña']) ? htmlspecialchars($_POST['contraseña']) :'';
        $repetirContraseña = isset($_POST['repetirContraseña']) ? htmlspecialchars($_POST['repetirContraseña']) :'';

        $html = <<<HTML
            <h2>Reservas</h2>
            
            <form name="formularioAuxiliar" method='post'>
                <p>Si ya estás registrado puedes iniciar sesión pulsando sobre  
                    <button type='submit' name='accion' value='login'>Iniciar sesión</button></p>
            </form>

            <form name="formularioRegistro" method='post'>
                <fieldset>
                    <legend>Formulario de registro</legend>
                    <label for="nombre">Nombre:</label>
                    <input id="nombre" type='text' name='nombre'  required maxlength="50" value=$nombre>
                    
                    <label for="apellidos">Apellidos:</label>
                    <input id="apellidos" type='text' name='apellidos' required maxlength="100" value=$apellidos >
                    
                    <label for="correoElectronico">Correo electrónico:</label>
                    <input id="correoElectronico" type='email' name='correoElectronico' required maxlength="150" value=$correoElectronico>
                    
                    <label for="contraseña">Contraseña:</label>
                    <input id="contraseña" type='password' name='contraseña' required minlength="7" value=$contraseña>
                    
                    <label for="repetirCotraseña">Repetir contraseña:</label>
                    <input id="repetirContraseña" type='password' name='repetirContraseña' required value=$repetirContraseña>
                    
                    <button type='submit' name='accion' value='registro'>Registrarse</button>
                </fieldset>
            </form>
            HTML;

        echo $html;

        if ($mensaje){
            echo "<p>$mensaje</p>";
        }

        echo '</main>';
        // Validaciones de los campos en el cliente utilizando JavaScript antes de enviar el formulario.
        $script = <<<HTML
            <script>
                "use strict";
                class ValidadorFormulario{
                    validar(){
                        const nombre = document.getElementById('nombre');
                        const apellidos = document.getElementById('apellidos');
                        const correoElectronico = document.getElementById('correoElectronico');
                        const contraseña = document.getElementById('contraseña');
                        const repetirContraseña = document.getElementById('repetirContraseña');
                        const formularioRegistro = document.forms['formularioRegistro'];

                        nombre.addEventListener('input', () => {
                            nombre.setCustomValidity('');
                            if (nombre.value.trim() === ''){
                                nombre.setCustomValidity('El nombre es obligatorio.');
                            }
                            if (nombre.value.length > 50) {
                                nombre.setCustomValidity('El nombre puede tener como máximo una longitud de 50 caracteres.');
                            }
                        });

                        apellidos.addEventListener('input', () => {
                            apellidos.setCustomValidity('');
                            if (apellidos.value.trim() === ''){
                                apellidos.setCustomValidity('Los apellidos son obligatorios.');
                            }
                            if (apellidos.value.length > 100) {
                                apellidos.setCustomValidity('Los apellidos pueden tener como máximo una longitud de 100 caracteres.');
                            }
                        });

                        correoElectronico.addEventListener('input', () => {
                            correoElectronico.setCustomValidity('');
                            if (correoElectronico.validity.typeMismatch) {
                                correoElectronico.setCustomValidity('El correo electrónico introducido no es válido.');
                            }
                            if (correoElectronico.value.trim() === ''){
                                correoElectronico.setCustomValidity('El correo electrónico es obligatorio.');
                            }
                            if (correoElectronico.value.length > 150) {
                                correoElectronico.setCustomValidity('El correo electrónico puede tener como máximo una longitud de 150 caracteres.');
                            }
                        });
                        
                        contraseña.addEventListener('input', () => {
                            contraseña.setCustomValidity('');
                            let mensajeError = '';  // Variable para acumular los errores
                            if (contraseña.value.trim() === ''){
                                mensajeError += 'La contraseña es obligatoria.\\n';
                            }
                            if (contraseña.value.length < 7) {
                            mensajeError +='La contraseña debe tener al menos una longitud de 7 caracteres.\\n';
                            }
                            if (!/[A-Z]/.test(contraseña.value) || !/[a-z]/.test(contraseña.value) || !/\d/.test(contraseña.value)){
                                mensajeError +='La contraseña debe incluir mayúsculas, minúsculas y números.\\n';
                            }
                            // Si hay mensajes de error acumulados, asignarlos
                            if (mensajeError) {
                                contraseña.setCustomValidity(mensajeError.trim());
                            }
                        });
                        
                        repetirContraseña.addEventListener('input', () => {
                            repetirContraseña.setCustomValidity('');
                            if (repetirContraseña.value.trim() === ''){
                                repetirContraseña.setCustomValidity('Por favor, repita la contraseña.');
                            }
                            if (repetirContraseña.value !== contraseña.value){
                                repetirrepetirContraseña.setCustomValidity('Las contraseñas no coinciden.');
                            }
                        });

                        formularioRegistro.addEventListener('submit', (e) =>{
                            // Forzar la validación de todos los campos
                            if (!formularioRegistro.checkValidity()){
                                e.preventDefault(); // Detener el envío
                            }
                        });
                    }
                }
                var validador = new ValidadorFormulario();
                validador.validar();
            </script>
        HTML;
        echo $script;
     }
}
