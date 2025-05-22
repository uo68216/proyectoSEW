<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';
require_once __DIR__ . '/../dtos/UsuarioDTO.php';
require_once __DIR__ . '/../util/Validator.php';

class ServicioLogin {
    public static function procesarLogin(PDO $pdo): void {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $repo = new UsuarioRepositorio($pdo);
        $usuarioDTO = $repo->buscarPorEmail($email);
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

    public static function procesarRegistro(PDO $pdo): void {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correoElectronico = $_POST['correo electronico'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        $repetirContraseña = $_POST['repetirContraseña'] ?? '';

        $errores = [];

        // Validaciones
        Validador::validarNoNulo($nombre, 'nombre', $errores);
        Validador::validarNoNulo($apellidos, 'apellidos', $errores);
        Validador::validarNoNulo($correoElectronico, 'nombre', $errores);
        Validador::validarEmail($correoElectronico,'Correo electrónico', $errores);
        Validador::validarNoNulo($contraseña, 'contraseña', $errores);
        Validador::validarNoNulo($repetirContraseña, 'repetirContraseña', $errores);
        
        if (!empty($errores)) {
            VistaRegistro::mostrar("Error: " . $e->getMessage());
        }

        $claveCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
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
