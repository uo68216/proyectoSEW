<?php
require_once __DIR__ . '/../repositorios/UsuarioRepositorio.php';

function mostrarFormularioLogin($mensaje = '') {
    if ($mensaje) echo "<p>$mensaje</p>";
    echo '<h2>Iniciar sesión</h2>
    <form method="post">
        <input type="hidden" name="accion" value="login">
        Email: <input type="email" name="email" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit">Iniciar sesión</button>
    </form>';
}

function mostrarFormularioRegistro() {
    echo '<h2>Registro</h2>
    <form method="post">
        <input type="hidden" name="accion" value="registro">
        Email: <input type="email" name="email" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <button type="submit">Registrarse</button>
    </form>';
}

function procesarLogin($pdo) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $repo = new UsuarioRepositorio($pdo);
    $usuario = $repo->buscarPorEmail($email);

    if ($usuario && password_verify($password, $usuario->getPassword())) {
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['usuario_email'] = $usuario->getEmail();
        $_SESSION['accion_diferida'] = $_SESSION['accion_diferida'] ?? 'inicio';
        header("Location: reservas.php");
        exit;
    } else {
        mostrarFormularioLogin("Credenciales incorrectas.");
    }
}

function procesarRegistro($pdo) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p>Email inválido</p>';
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
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}

