<?php
class VistaNuevaReserva {
    public static function mostrar(): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> <a href="reservas.php">Reservas</a> >> Nueva reserva</p>';
        echo '<main>'; //Migas de pan antes del main
        //Si estamos recargando el formulario recuperamos los datos de la sesión.
        $tipoRecurso = isset($_SESSION['tipo_Recurso']) ? $_SESSION['tipo_Recurso'] :'Todos';
        $fechaInicio = isset($_SESSION['fecha_Inicio']) ? $_SESSION['fecha_Inicio'] : (new DateTime())->format('d-m-Y');
        $numeroPlazas = isset($_SESSION['numero_Plazas']) ? $_SESSION['numero_Plazas'] :'1';
        $correoElectronico = isset($_SESSION['usuario_email']) ? $_SESSION['usuario_email'] :'';

        $html = <<<HTML
        <h2>Reservas</h2>
        <section>
            <form name="formularioAuxiliar" method='post'>
                <p>Sesión iniciada como $correoElectronico. <button type='submit' name='accion' value='cerrarSesion'>Cerrar sesión</button></p>
                <p>Para ver tus reservas pulsa sobre <button type='submit' name='accion' value='consultarReservas'>Consultar Reservas</button></p>
            </form>
        </section>
        HTML;

        echo $html;
        echo '<section>';
        self::generarFormularioFiltro($fechaInicio, $numeroPlazas);
        echo '</section>';
        echo '</main>';
    }
    private static function generarFormularioFiltro($fechaInicio,$numeroPlazas):void{
        echo '<form name="formularioFiltro" method="post">';
        echo '<input type="hidden" name="accion" value="filtrarRecursos">';
        echo '<fieldset>';
        echo '<legend>Filtrar</legend>';
        self::generarSelectTipoRecurso();
        self::generarSelectFecha($fechaInicio);
        self::generarSelectPlazas($numeroPlazas);
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
        echo '<select name="fechaInicio" id="selectFecha" onchange="this.form.submit()" value="' . $fechaInicio .'">';
        // Crear las opciones del select
        foreach ($fechas as $fecha) {
            echo "<option value=\"$fecha\" ";
            echo $fecha == $fechaInicio ? "selected":'';
            echo ">$fecha</option>";
        }
        echo '</select>';
    }

    private static function generarSelectPlazas($numeroPlazas):void{
        // Crear el select
        echo '<label for="selectPlazas">Plazas: </label>';
        echo '<select name="plazas" id="selectPlazas" onchange="this.form.submit()" value="' . $numeroPlazas .'">';
        // Crear las opciones del select
        for ($i = 1; $i < 10; $i++) {
            echo "<option value=\"$i\" ";
            echo $i == $numeroPlazas? "selected":'';
            echo ">$i</option>";
        }
        echo '</select>';
    }
}
