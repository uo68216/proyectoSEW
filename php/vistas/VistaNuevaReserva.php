<?php
class VistaNuevaReserva {
    public static function mostrar(array $tiposReservas, array $recursosDisponibles): void {
        echo '<p>Estás en: <a href="index.html">Inicio</a> >> <a href="reservas.php">Reservas</a> >> Nueva reserva</p>';
        echo '<main>'; //Migas de pan antes del main
        //Si estamos recargando el formulario recuperamos los datos de la sesión.
        $tipoReserva = isset($_SESSION['tipo_Reserva']) ? $_SESSION['tipo_Reserva'] :'Todos';
        $fechaInicio = isset($_SESSION['fecha_Inicio']) ? $_SESSION['fecha_Inicio'] : (new DateTime())->format('d-m-Y');
        $numeroPlazas = isset($_SESSION['numero_Plazas']) ? $_SESSION['numero_Plazas'] :'1';
        $correoElectronico = isset($_SESSION['usuario_email']) ? $_SESSION['usuario_email'] :'';

        $html = <<<HTML
            <h2>Nueva reserva</h2>
            <section>
                <form name="formularioAuxiliar" method='post'>
                    <p>Sesión iniciada como $correoElectronico. <button type='submit' name='accion' value='cerrarSesion'>Cerrar sesión</button></p>
                    <p>Para ver tus reservas pulsa sobre <button type='submit' name='accion' value='consultarReservas'>Consultar Reservas</button></p>
                </form>
            </section>
        HTML;
        echo $html;
        
        self::generarFormularioFiltro($tipoReserva,$tiposReservas, $fechaInicio, $numeroPlazas);
        self::generarSeccionResultados($recursosDisponibles);
        echo '</main>';
    }
    private static function generarFormularioFiltro(string $tipoReserva, array $tiposReservas, string $fechaInicio, string $numeroPlazas):void{
        $html = <<<HTML
            <form name="formularioFiltro" method="post">
                <input type="hidden" name="accion" value="filtrarRecursos">
                <fieldset>
                    <legend>Filtrar</legend>
        HTML;
        echo $html;
        
        self::generarSelectTipoReserva($tipoReserva, $tiposReservas);
        self::generarSelectFecha($fechaInicio);
        self::generarSelectPlazas($numeroPlazas);
        
        $html2 = <<<HTML
                    <button type="button" onclick="(function() {
                        document.getElementById('selectTipoReservas').selectedIndex = 0;
                        document.getElementById('selectFecha').selectedIndex = 0;
                        document.getElementById('selectPlazas').selectedIndex = 0;
                        document.forms['formularioFiltro'].submit();
                    })()">Limpiar</button>
                </fieldset>
            </form>
        HTML;
        echo $html2;
    }

    private static function generarSelectTipoReserva(string $tipoReserva, array $tiposReservas):void{
        $html = <<<HTML
            <label for="selectTipoReservas">Tipo: </label>
            <select name="tipoReserva" id="selectTipoReservas" onchange="this.form.submit()">
                <option value="Todos">Todos</option>";
        HTML;
        echo $html;
        foreach ($tiposReservas as $i) {
            echo "<option value=\"$i\" ";
            echo $i == $tipoReserva? "selected":'';
            echo ">$i</option>";
        }
        echo '</select>';
    }

    private static function generarSelectFecha(string $fechaInicio):void{
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
        echo '<select name="fechaInicio" id="selectFecha" onchange="this.form.submit()" >';
        // Crear las opciones del select
        foreach ($fechas as $fecha) {
            echo "<option value=\"$fecha\" ";
            echo $fecha == $fechaInicio ? "selected":'';
            echo ">$fecha</option>";
        }
        echo '</select>';
    }

    private static function generarSelectPlazas(string $numeroPlazas):void{
        // Crear el select
        echo '<label for="selectPlazas">Plazas: </label>';
        echo '<select name="plazas" id="selectPlazas" onchange="this.form.submit()">';
        // Crear las opciones del select
        for ($i = 1; $i < 10; $i++) {
            echo "<option value=\"$i\" ";
            echo $i == $numeroPlazas? "selected":'';
            echo ">$i</option>";
        }
        echo '</select>';
    }

    private static function generarSeccionResultados(array $recursosDisponibles){
        echo '<section>';
        if (!empty($recursosDisponibles)){
            echo '<p>Aquí pintaremos la tabla</p>';
        }else{
            echo '<p>No existen recursos turísticos disponibles para reservar con el filtro actual</p>';
        }
        echo '</section>';
    }
}
