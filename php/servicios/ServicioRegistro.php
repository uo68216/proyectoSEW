<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';
require_once __DIR__ . '/../dtos/UsuarioDTO.php';

class ServicioRegistro {
 public static function procesarRegistro(PDO $pdo): void {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correoElectronico = $_POST['correoElectronico'] ;
        $contraseña = $_POST['contraseña'];
        $repetirContraseña = $_POST['repetirContraseña'] ;

        // Comprobamos si ya está dado de alta un usuario con este correo en la base de datos
        try{
            $repo = new UsuarioRepositorio($pdo);
            $usuarioDTO = $repo->buscarPorEmail($correoElectronico);
            if ($usuarioDTO instanceof UsuarioDTO) {
                // Ya existe un usuario dado de alta con este correo electrónico
                VistaRegistro::mostrar("Ya existe un usuario asociado a este correo electrónico");
                exit;
            }
            $claveCifrada = password_hash($contraseña, PASSWORD_DEFAULT);
            $usuarioDTO = new UsuarioDTO(null,$nombre,$apellidos,$correoElectronico,$claveCifrada);
            $repo->crear($usuarioDTO);
        } catch (DatabaseException $e) {
            VistaRegistro::mostrar("Error: " . $e->getMessage());
        }
        // Una vez completado el registro hacemos login automáticamente
        $_SESSION['usuario_email'] = $usuarioDTO->getCorreoElectronico();
        $_SESSION['accion_diferida'] = 'inicio';
        header("Location: reservas.php");
        exit;
    }
}
    