<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Curso PHP - CHAT GPT</title>
    <meta charset="utf-8"/>
</head>
<body> 
    <h1>Primeros pasos</h1>
    <section>
        <?php
        require_once 'Usuario.php';
        $usuario = new Usuario("Laura", 32);
        ?>
        <p> <?php echo $usuario->saludar(); ?> </p>
        <?php
            /* Prueba gets y sets*/
            $usuario->setNombre("Pedro");
            $usuario->setEdad(45);
        ?>
        <p> Hola, me llamo <?php echo $usuario->getNombre(); ?> y tengo  <?php echo $usuario->getEdad(); ?> años.</p>
    </section>
</body>
</html>
