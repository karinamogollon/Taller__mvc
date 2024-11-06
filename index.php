<?php

// Incluir el controlador
require_once 'app/controllers/IngresoController.php';

// Obtener la acción desde la URL
$action = $_GET['action'] ?? 'index';

// Crear una instancia del controlador
$controller = new IngresoController();

// Ruta basada en la acción
switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    // case 'filter':
    //     $controller->filter();
    //     break;
    // case 'registrarSalida':
    //     $controller->registrarSalida();
    //     break;
    default:
        $controller->index();
        break;
}
?>
