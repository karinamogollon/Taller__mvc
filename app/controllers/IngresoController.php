<?php
require_once __DIR__ . '/../models/Ingreso.php';
require_once __DIR__ . '/../models/Programa.php';
require_once __DIR__ . '/../models/Responsable.php';
require_once __DIR__ . '/../models/Sala.php';

class IngresoController {
    
    public function index() {
        $fechaActual = date('Y-m-d');
        
        $ingresos = Ingreso::getAllIngresos($fechaActual);
        
        require __DIR__ . '/../views/ingresos/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $codigoEstudiante = htmlspecialchars(trim($_POST['codigoEstudiante']));
            $nombreEstudiante = htmlspecialchars(trim($_POST['nombreEstudiante']));
            $idPrograma = intval($_POST['idPrograma']);
            $fechaIngreso = $_POST['fechaIngreso'];
            $horaIngreso = $_POST['horaIngreso'];
            $idResponsable = intval($_POST['idResponsable']);
            $idSala = intval($_POST['idSala']);
            
            $salaDisponible = Sala::verificarDisponibilidad($idSala, $fechaIngreso, $horaIngreso);
            
            if ($salaDisponible) {
                $data = [
                    'codigoEstudiante' => $codigoEstudiante,
                    'nombreEstudiante' => $nombreEstudiante,
                    'idPrograma' => $idPrograma,
                    'fechaIngreso' => $fechaIngreso,
                    'horaIngreso' => $horaIngreso,
                    'idResponsable' => $idResponsable,
                    'idSala' => $idSala
                ];
                
                $resultado = Ingreso::createIngreso($data);
                
                if ($resultado) {
                    header('Location: index.php?action=index');
                    exit();
                } else {
                    $error = "Error al registrar el ingreso. Inténtalo de nuevo.";
                }
            } else {
                $error = "La sala seleccionada no está disponible en el horario solicitado.";
            }
        }
        
        $programas = Programa::getAll();
        $responsables = Responsable::getAll();
        $salas = Sala::getAll();
        
        require __DIR__ . '/../views/ingresos/create.php';
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                header('Location: index.php?action=index');
                exit();
            }
            $id = intval($_GET['id']);
            $ingreso = Ingreso::getIngresoById($id);
            
            if (!$ingreso) {
                header('Location: index.php?action=index');
                exit();
            }
            
            require __DIR__ . '/../views/ingresos/edit.php';
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                header('Location: index.php?action=index');
                exit();
            }
            $id = intval($_POST['id']);
            
            $codigoEstudiante = htmlspecialchars(trim($_POST['codigoEstudiante']));
            $nombreEstudiante = htmlspecialchars(trim($_POST['nombreEstudiante']));
            
            $data = [
                'codigoEstudiante' => $codigoEstudiante,
                'nombreEstudiante' => $nombreEstudiante
            ];
            
            $resultado = Ingreso::updateIngreso($id, $data);
            
            if ($resultado) {
                header('Location: index.php?action=index');
                exit();
            } else {
                $error = "Error al actualizar el ingreso. Inténtalo de nuevo.";
                $ingreso = Ingreso::getIngresoById($id);
                require __DIR__ . '/../views/ingresos/edit.php';
            }
        }
    }
    
    public function filter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fechaInicio = $_POST['fechaInicio'] ?? null;
            $fechaFin = $_POST['fechaFin'] ?? null;
            $codigoEstudiante = htmlspecialchars(trim($_POST['codigoEstudiante'])) ?? null;
            $idPrograma = intval($_POST['idPrograma']) ?? null;
            $idResponsable = intval($_POST['idResponsable']) ?? null;
            
            $ingresos = Ingreso::getIngresosByFilters($fechaInicio, $fechaFin, $codigoEstudiante, $idPrograma, $idResponsable);
            
            $programas = Programa::getAll();
            $responsables = Responsable::getAll();
            $salas = Sala::getAll();
            
            require __DIR__ . '/../views/ingresos/index.php';
        } else {
            header('Location: index.php?action=index');
            exit();
        }
    }
    
    public function registrarSalida() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                header('Location: index.php?action=index');
                exit();
            }
            $id = intval($_POST['id']);
            
            $resultado = Ingreso::registrarSalida($id);
            
            if ($resultado) {
                header('Location: index.php?action=index');
                exit();
            } else {
                $error = "Error al registrar la salida. Inténtalo de nuevo.";
                $ingreso = Ingreso::getIngresoById($id);
                require __DIR__ . '/../views/ingresos/edit.php';
            }
        } else {
            header('Location: index.php?action=index');
            exit();
        }
    }
}
