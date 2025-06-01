<?php
require_once __DIR__ . '/../vistas/VistaLogin.php';
require_once __DIR__ . '/../vistas/VistaRegistro.php';
require_once __DIR__ . '/../vistas/VistaNuevaReserva.php';
require_once __DIR__ . '/../servicios/ServicioLogin.php';
require_once __DIR__ . '/../servicios/ServicioRegistro.php';
require_once __DIR__ . '/../servicios/ServicioReservas.php';

class ControladorPaginaPrincipalReservas {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function ejecutar(): void {
        $this->gestionarAccionDiferida();
        $accion = $_POST['accion'] ?? 'inicio';

        switch ($accion) {
            case 'login':
                isset($_POST['correoElectronico'], $_POST['contraseña'])
                    ? ServicioLogin::procesarLogin($this->pdo)
                    : VistaLogin::mostrar();
                break;

            case 'registro':
                isset($_POST['nombre'], $_POST['apellidos'], $_POST['correoElectronico'], $_POST['contraseña'], $_POST['repetirContraseña'])
                    ? ServicioRegistro::procesarRegistro($this->pdo)
                    : VistaRegistro::mostrar();
                break;

            case 'cerrarSesion':
                session_destroy();
                header("Location: reservas.php");
                exit;
            
            case 'filtrarRecursos':
                $this->verRecursos();
                break;

            case 'iniciarReserva':
                $this->iniciarReserva();
                break;

            case 'confirmar_reserva':
                $this->confirmarReserva();
                break;

            case 'consultarReservas':
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

    private function gestionarAccionDiferida(): void {
        //Se trata la acción diferida solo si ya iniciamos sesión
        if (isset($_SESSION['usuario_email'])) {
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
    }

    private function mostrarInicio(): void {
        self::verRecursos();
        /*/PTE VER SI ES NECESARIA O SI VALE SOLO CON verRecursos
        if (isset($_SESSION['usuario_email'])) {
            VistaNuevaReserva::mostrar();
        } else {
            VistaLogin::mostrar();
        }*/
    }

    private function verRecursos(): void {
        if (isset($_SESSION['usuario_email'])) {
            ServicioReservas::verRecursos($this->pdo);
        } else {
            $_SESSION['accion_diferida'] = 'filtrarRecursos';
            $_SESSION['datos_diferidos'] = $_POST;
            VistaLogin::mostrar();
        }
    }

    private function iniciarReserva(): void {
        if (isset($_SESSION['usuario_email'])) {
           //Todo
        } else {
            $_SESSION['accion_diferida'] = 'filtrarRecursos';
            $_SESSION['datos_diferidos'] = $_POST;
            VistaLogin::mostrar();
        }
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
