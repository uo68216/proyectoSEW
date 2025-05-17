<?php
require_once __DIR__ . '/../repositorios/RecursoRepositorio.php';

function mostrarRecursosDisponibles($pdo) {
    $repo = new RecursoRepositorio($pdo);
    $recursos = $repo->obtenerTodos();

    echo '<h2>Recursos disponibles</h2>';
    foreach ($recursos as $recurso) {
        echo '<div>' . htmlspecialchars($recurso->getNombre()) . '</div>';
    }
}

