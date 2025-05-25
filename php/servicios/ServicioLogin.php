<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';
require_once __DIR__ . '/../dtos/UsuarioDTO.php';

class ServicioLogin {
    public static function procesarLogin(PDO $pdo): void {
        $correoElectronico = $_POST['correoElectronico'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        try{
            $repo = new UsuarioRepositorio($pdo);
            $usuarioDTO = $repo->buscarPorEmail($correoElectronico);
        } catch (DatabaseException $e) {
            VistaLogin::mostrar("Error: " . $e->getMessage());
        }
        if ($usuarioDTO instanceof UsuarioDTO) {
            if ($usuarioDTO && password_verify($contraseña, $usuarioDTO->getClave())) {
                $_SESSION['usuario_email'] = $usuarioDTO->getCorreoElectronico();
                $_SESSION['usuario_Id'] = $usuarioDTO->getId();
                $_SESSION['accion_diferida'] = $_SESSION['accion_diferida'] ?? 'inicio';
                header("Location: reservas.php");
                exit;
            } else {
                VistaLogin::mostrar("Contraseña incorrecta.");
            }
        } else{
            VistaLogin::mostrar("El usuario " . $correoElectronico . "no está registrado");
        }
    }
}
