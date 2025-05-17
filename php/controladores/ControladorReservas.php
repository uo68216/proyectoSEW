<?php
require_once __DIR__ . '/../vistas/VistaInicio.php';
require_once __DIR__ . '/../vistas/VistaLogin.php';
require_once __DIR__ . '/../vistas/VistaRegistro.php';
require_once __DIR__ . '/../servicios/ServicioLogin.php';

class ControladorReservas {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function ejecutar(): void {
        $this->gestionarSesionDiferida();
        $accion = $_POST['accion'] ?? 'inicio';

        switch ($accion) {
            case 'login':
                isset($_POST['email'], $_POST['password'])
                    ? ServicioLogin::procesarLogin($this->pdo)
                    : VistaLogin::mostrar();
                break;

            case 'registro':
                isset($_POST['email'], $_POST['password'])
                    ? ServicioLogin::procesarRegistro($this->pdo)
                    : VistaRegistro::mostrar();
                break;

            case 'logout':
                session_destroy();
                header("Location: reservas.php");
                exit;

            case 'ver_recursos':
                $this->verRecursos();
                break;

            case 'iniciar_reserva':
                $this->iniciarReserva();
                break;

            case 'confirmar_reserva':
                $this->confirmarReserva();
                break;

            case 'mis_reservas':
                $this->mostrarReservasUsuario();
                break;

            case 'detalle_reserva':
                $this->verDetalleReserva();
                break;

            case 'cancelar_reserva':
                $this->cancelarReserva();
                break;

            case 'inicio':
                $this->mostrarInicio();
                break;

            default:
                echo "<p>Acción no reconocida.</p>";
        }
    }

    private function gestionarSesionDiferida(): void {
        if (isset($_SESSION['accion_diferida'])) {
            $_POST['accion'] = $_SESSION['accion_diferida'];
            unset($_SESSION['accion_diferida']);
        }
        if (isset($_SESSION['datos_diferidos'])) {
            foreach ($_SESSION['datos_diferidos'] as $clave => $valor) {
                $_POST[$clave] = $valor;
            }
            unset($_SESSION['datos_diferidos']);
        }
    }

    private function mostrarInicio(): void {
        if (isset($_SESSION['usuario_id'])) {
            VistaInicio::mostrar($_SESSION['usuario_email']);
        } else {
            VistaInicio::mostrar(null);
        }
    }

    private function verRecursos(): void {
        // TODO: implementar lógica para ver recursos turísticos disponibles
    }

    private function iniciarReserva(): void {
        // TODO: implementar lógica para iniciar una reserva
    }

    private function confirmarReserva(): void {
        // TODO: implementar lógica para confirmar una reserva
    }

    private function mostrarReservasUsuario(): void {
        // TODO: implementar lógica para listar las reservas del usuario
    }

    private function verDetalleReserva(): void {
        // TODO: implementar lógica para ver detalles de una reserva
    }

    private function cancelarReserva(): void {
        // TODO: implementar lógica para cancelar una reserva
    }
}
