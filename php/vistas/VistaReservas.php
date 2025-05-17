<?php
class VistaReservas {
    public static function mostrarListado(array $reservas): void {
        echo '<h2>Mis Reservas</h2>';
        foreach ($reservas as $reserva) {
            echo '<div>Reserva #' . htmlspecialchars($reserva['id']) . '</div>';
        }
    }

    public static function mostrarRecursos(array $recursos): void {
        echo '<h2>Recursos Disponibles</h2>';
        foreach ($recursos as $recurso) {
            echo '<div>' . htmlspecialchars($recurso['nombre']) . '</div>';
        }
    }

    public static function mostrarFormularioReserva(): void {
        echo '<h2>Reservar un Recurso</h2>';
        echo '<form method="post">
            <input type="hidden" name="accion" value="confirmar_reserva">
            <!-- campos de reserva -->
            <button type="submit">Confirmar reserva</button>
        </form>';
    }

    public static function mostrarDetalle(array $detalle): void {
        echo '<h2>Detalle de la Reserva</h2>';
        // TODO: mostrar los detalles del array $detalle
    }

    public static function mostrarMensaje(string $mensaje): void {
        echo '<p>' . htmlspecialchars($mensaje) . '</p>';
    }
}
