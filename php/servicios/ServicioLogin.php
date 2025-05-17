<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';

class ServicioLogin {
    public static function procesarLogin(PDO $pdo): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $repo = new UsuarioRepositorio($pdo);
        $usuario = $repo->buscarPorEmail($email);
        
        if ($usuario && password_verify($password, $usuario->getClave())) {
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_email'] = $usuario->getEmail();
            $_SESSION['accion_diferida'] = $_SESSION['accion_diferida'] ?? 'inicio';
            header("Location: reservas.php");
            exit;
        } else {
            VistaLogin::mostrar("Credenciales incorrectas.");
        }
    }

    public static function procesarRegistro(PDO $pdo): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            VistaRegistro::mostrar("Email inválido");
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $repo = new UsuarioRepositorio($pdo);
        try {
            $usuario = $repo->crear($email, $hash);
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_email'] = $usuario->getEmail();
            $_SESSION['accion_diferida'] = 'ver_recursos';
            header("Location: reservas.php");
            exit;
        } catch (Exception $e) {
            VistaRegistro::mostrar("Error: " . $e->getMessage());
        }
    }
}
