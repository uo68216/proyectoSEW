<?php
declare(strict_types=1);
require_once 'DB.php';
require_once 'Model.php';
require_once 'Validator.php';
require_once 'ModelValidationException.php';
require_once 'Usuario.php';

// Conectar a la base de datos
Model::setDb(DB::getConnection());

echo "<h2>CRUD de Usuarios</h2>";

// -------------------- CREAR --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    try {
        $usuario = new Usuario(
            null,
            $_POST['nombre'],
            $_POST['apellidos'],
            $_POST['correoElectronico'],
            $_POST['clave']
        );
        $id = Usuario::create($usuario);
        echo "<p>✅ Usuario creado con ID: $id</p>";
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    }
}

// -------------------- VER --------------------
if (isset($_GET['ver'])) {
    $usuario = Usuario::find((int)$_GET['ver']);
    if ($usuario) {
        echo "<pre>" . print_r($usuario, true) . "</pre>";
    } else {
        echo "<p>⚠ Usuario no encontrado.</p>";
    }
}

// -------------------- ACTUALIZAR --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
    try {
        $usuario = new Usuario(
            (int)$_POST['id'],
            $_POST['nombre'],
            $_POST['apellidos'],
            $_POST['correoElectronico'],
            $_POST['clave']
        );
        Usuario::update($usuario);
        echo "<p>✅ Usuario actualizado.</p>";
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    }
}

// -------------------- ELIMINAR --------------------
if (isset($_GET['eliminar'])) {
    try {
        Usuario::delete((int)$_GET['eliminar']);
        echo "<p>🗑 Usuario eliminado.</p>";
    } catch (Exception $e) {
        echo "<p>❌ Error: " . $e->getMessage() . "</p>";
    }
}
?>

<!-- Formulario para crear usuario -->
<h3>Crear usuario</h3>
<form method="POST">
    <input name="nombre" placeholder="Nombre" required><br>
    <input name="apellidos" placeholder="Apellidos" required><br>
    <input name="correoElectronico" placeholder="Correo electrónico" required><br>
    <input name="clave" placeholder="Clave" type="password" required><br>
    <button name="crear">Crear</button>
</form>

<!-- Formulario para actualizar usuario -->
<h3>Actualizar usuario</h3>
<form method="POST">
    <input name="id" placeholder="ID del usuario" required><br>
    <input name="nombre" placeholder="Nombre" required><br>
    <input name="apellidos" placeholder="Apellidos" required><br>
    <input name="correoElectronico" placeholder="Correo electrónico" required><br>
    <input name="clave" placeholder="Clave" type="password" required><br>
    <button name="actualizar">Actualizar</button>
</form>

<!-- Ver usuario -->
<h3>Ver usuario</h3>
<form method="GET">
    <input name="ver" placeholder="ID del usuario">
    <button type="submit">Ver</button>
</form>

<!-- Eliminar usuario -->
<h3>Eliminar usuario</h3>
<form method="GET">
    <input name="eliminar" placeholder="ID del usuario">
    <button type="submit">Eliminar</button>
</form>
