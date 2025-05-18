<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';
require_once __DIR__ . '/../dtos/UsuarioDTO.php';

class ServicioLogin {
    public static function procesarLogin(PDO $pdo): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $repo = new UsuarioRepositorio($pdo);
        $usuarioDTO = $repo->buscarPorEmail($email);
        if ($usuarioDTO instanceof UsuarioDTO) {
            if ($usuarioDTO && password_verify($password, $usuarioDTO->getClave())) {
                $_SESSION['usuario_email'] = $usuarioDTO->getCorreoElectronico();
                $_SESSION['accion_diferida'] = $_SESSION['accion_diferida'] ?? 'inicio';
                header("Location: reservas.php");
                exit;
            } else {
                VistaLogin::mostrar("Credenciales incorrectas.");
            }
        } else{
            VistaLogin::mostrar("No está dado de alta el usuario " . $email);
        }
    }

    public static function procesarRegistro(PDO $pdo): void {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correoElectronico = $_POST['email'] ?? '';
        $clave = $_POST['password'] ?? '';
        
        if (!filter_var($correoElectronico, FILTER_VALIDATE_EMAIL)) {
            VistaRegistro::mostrar("Email no válido");
            return;
        }

        $claveCifrada = password_hash($clave, PASSWORD_DEFAULT);
        $usuarioDTO = new UsuarioDTO(null,$nombre,$apellidos,$correoElectronico,$claveCifrada);
        
        $repo = new UsuarioRepositorio($pdo);
        try {
            $repo->crear($usuarioDTO);
        } catch (DatabaseException $e) {
            VistaRegistro::mostrar("Error: " . $e->getMessage());
        }

        $_SESSION['usuario_email'] = $usuarioDTO->getCorreoElectronico();
        $_SESSION['accion_diferida'] = 'inicio';
        header("Location: reservas.php");
        exit;
    }
}
