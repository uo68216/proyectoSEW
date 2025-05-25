<?php
class VistaNuevaReserva {
    public static function mostrar(): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> <a href="reservas.php">Reservas</a> >> Nueva reserva</p>';
        echo '<main>'; //Migas de pan antes del main
        //Si estamos recargando el formulario recuperamos los datos de la sesión.
        $correoElectronico = isset($_SESSION['usuario_email']) ? htmlspecialchars($_SESSION['usuario_email']) :'';
        $fechaInicio = isset($_SESSION['fecha_Inicio']) ? htmlspecialchars($_SESSION['fecha_Inicio']) : (new DateTime())->format('d-m-Y');
        // Pendiente otros valores.

        $html = <<<HTML
        <h2>Reservas</h2>
        <form name="formularioAuxiliar" method='post'>
            <p>Sesión iniciada como $correoElectronico. <button type='submit' name='accion' value='cerrarSesion'>Cerrar sesión</button></p>
            <p>Para ver tus reservas pulsa sobre <button type='submit' name='accion' value='consultarReservas'>Consultar Reservas</button></p>
        </form>
        HTML;

        echo $html;
        echo '<section>';
        self::generarFormularioFiltro($fechaInicio);
        echo '</section>';
        echo '</main>';
        self::generarScript();
    }
    private static function generarFormularioFiltro($fechaInicio):void{
        echo '<form name="formularioFiltro" method="post">';
        echo '<input type="hidden" name="accion" value="filtrarRecursos">';
        echo '<fieldset>';
        echo '<legend>Filtrar</legend>';
        self::generarSelectTipoRecurso();
        self::generarSelectFecha($fechaInicio);
        self::generarSelectPlazas();
        echo '</fieldset>';
        echo '</form>';
    }

    private static function generarSelectTipoRecurso():void{
        //Hacerlo con consulta a la bbdd?

    }


    private static function generarSelectFecha($fechaInicio):void{
        $fecha_actual = new DateTime();
        // Generar el rango de fechas [Hoy - +2 meses(62 días)]
        $fechas = [];
        for ($i = 0; $i <= 62; $i++) {
            $fecha = clone $fecha_actual;
            $fecha->modify("+$i days");
            
            // Formateamos la fecha al formato dd-mm-yyyy
            $fechas[$i] = $fecha->format('d-m-Y');
        }
        // Crear el select
        echo '<label for="selectFecha">Fecha: </label>';
        echo '<select name="fecha" id="selectFecha" value='.$fechaInicio.'>';
        // Crear las opciones del select
        foreach ($fechas as $fecha) {
            echo "<option value=\"$fecha\">$fecha</option>";
        }
        echo '</select>';
    }

    private static function generarSelectPlazas():void{
        //TO DO
    }

    private static function generarScript():void{
    $script = <<<HTML
            <script>
                "use strict";
                class Filtro{
                   constructor(){
                        const formularioFiltro = document.forms['formularioFiltro'];
                        const fecha = document.getElementById('selectFecha');
                        const apellidos = document.getElementById('apellidos');
                        
                        fecha.addEventListener('change', () => {
                             $_SESSION['fecha_Inicio'] = fecha.value;
                        });
                    }
                }
                var filtro = new Filtro();
                
            </script>
        HTML;
        echo $script;
    }
}