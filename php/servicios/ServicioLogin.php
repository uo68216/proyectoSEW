<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';
require_once __DIR__ . '/../dtos/UsuarioDTO.php';

class ServicioLogin {
    public static function procesarLogin(PDO $pdo): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        try{
            $repo = new UsuarioRepositorio($pdo);
            $usuarioDTO = $repo->buscarPorEmail($email);
        } catch (DatabaseException $e) {
            VistaRegistro::mostrar("Error: " . $e->getMessage());
        }
        if ($usuarioDTO instanceof UsuarioDTO) {
            if ($usuarioDTO && password_verify($password, $usuarioDTO->getClave())) {
                $_SESSION['usuario_email'] = $usuarioDTO->getCorreoElectronico();
                $_SESSION['usuario_Id'] = $usuarioDTO->getId();
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
}
