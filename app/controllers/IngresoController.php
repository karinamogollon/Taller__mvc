<?php
require_once __DIR__ . '/../models/Ingreso.php';
require_once __DIR__ . '/../models/Programa.php';
require_once __DIR__ . '/../models/Responsable.php';
require_once __DIR__ . '/../models/Sala.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/horarios_salas.php';

class IngresoController {

    // Método principal para manejar las acciones
    public function handleRequest() {
        $action = $_GET['action'] ?? 'index';

        if ($action === 'index') {
            $this->index();
        } elseif ($action === 'create') {
            $this->create();
        } elseif ($action === 'edit') {
            $this->edit();
        } elseif ($action === 'consultar') {
            $this->consultarIngresos();
        }
    }

    // Método para mostrar el listado de ingresos
    public function index() {
        // Obtener la conexión correctamente
        $pdo = Database::getConnection();

        // Verificar si la conexión fue exitosa
        if (!$pdo) {
            echo "Error: No se pudo establecer la conexión con la base de datos.";
            exit();
        }

        // Obtener los parámetros de los filtros
        $fechaInicio = $_GET['fechaInicio'] ?? null;
        $fechaFin = $_GET['fechaFin'] ?? null;
        $codigoEstudianteFiltro = $_GET['codigoEstudianteFiltro'] ?? null;
        $idProgramaFiltro = $_GET['idProgramaFiltro'] ?? null;
        $idResponsableFiltro = $_GET['idResponsableFiltro'] ?? null;

        // Consulta SQL con los filtros
        $query = "SELECT i.codigoEstudiante, i.nombreEstudiante, p.nombre AS programa_nombre,
                         i.fechaIngreso, i.horaIngreso, s.nombre AS sala_nombre, 
                         r.nombre AS responsable_nombre, i.fechaCreacion, i.fechaModificacion, i.id
                  FROM ingresos i
                  JOIN programas p ON i.idPrograma = p.id
                  JOIN salas s ON i.idSala = s.id
                  JOIN responsables r ON i.idResponsable = r.id
                  WHERE 1=1"; // Para evitar tener que escribir WHERE al inicio de la consulta

        // Aplicar filtros si están presentes
        if ($fechaInicio && $fechaFin) {
            $query .= " AND i.fechaIngreso BETWEEN :fechaInicio AND :fechaFin";
        }
        if ($codigoEstudianteFiltro) {
            $query .= " AND i.codigoEstudiante LIKE :codigoEstudianteFiltro";
        }
        if ($idProgramaFiltro) {
            $query .= " AND i.idPrograma = :idProgramaFiltro";
        }
        if ($idResponsableFiltro) {
            $query .= " AND i.idResponsable = :idResponsableFiltro";
        }

        // Preparar y ejecutar la consulta
        $statement = $pdo->prepare($query);

        // Crear variables intermedias para evitar el error de referencia en bindParam
        if ($fechaInicio && $fechaFin) {
            $statement->bindParam(':fechaInicio', $fechaInicio);
            $statement->bindParam(':fechaFin', $fechaFin);
        }
        if ($codigoEstudianteFiltro) {
            $codigoEstudianteFiltroLike = "%$codigoEstudianteFiltro%";
            $statement->bindParam(':codigoEstudianteFiltro', $codigoEstudianteFiltroLike);
        }
        if ($idProgramaFiltro) {
            $statement->bindParam(':idProgramaFiltro', $idProgramaFiltro);
        }
        if ($idResponsableFiltro) {
            $statement->bindParam(':idResponsableFiltro', $idResponsableFiltro);
        }

        // Ejecutar la consulta
        $statement->execute();
        $ingresos = $statement->fetchAll(PDO::FETCH_OBJ);

        // Obtener programas y responsables para los filtros
        $programas = Programa::getAll();
        $responsables = Responsable::getAll();

        // Pasar los datos a la vista
        require_once __DIR__ . '/../views/ingresos/index.php';
    }

    // Método para consultar los ingresos con los filtros
    public function consultarIngresos() {
        $fechaInicio = $_GET['fechaInicio'] ?? null;
        $fechaFin = $_GET['fechaFin'] ?? null;
        $codigoEstudianteFiltro = $_GET['codigoEstudianteFiltro'] ?? null;
        $idProgramaFiltro = $_GET['idProgramaFiltro'] ?? null;
        $idResponsableFiltro = $_GET['idResponsableFiltro'] ?? null;

        // Llamada al modelo para obtener los ingresos filtrados
        $ingresos = Ingreso::getIngresosFiltrados($fechaInicio, $fechaFin, $codigoEstudianteFiltro, $idProgramaFiltro, $idResponsableFiltro);

        // Obtener los programas y responsables para los filtros
        $programas = Programa::getAll();
        $responsables = Responsable::getAll();

        // Pasar los datos a la vista
        require __DIR__ . '/../views/ingresos/index.php';
    }

    // Método para crear un nuevo ingreso
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger los datos del formulario
            $codigoEstudiante = htmlspecialchars(trim($_POST['codigoEstudiante']));
            $nombreEstudiante = htmlspecialchars(trim($_POST['nombreEstudiante']));
            $idPrograma = intval($_POST['idPrograma']);
            $fechaIngreso = $_POST['fechaIngreso'];
            $horaIngreso = $_POST['horaIngreso'];
            $idResponsable = intval($_POST['idResponsable']);
            $idSala = intval($_POST['idSala']);
    
            // Verificar disponibilidad de la sala
            $salaDisponible = Sala::verificarDisponibilidad($idSala, $fechaIngreso, $horaIngreso);
    
            if ($salaDisponible) {
                // Preparar los datos para la creación
                $data = [
                    'codigoEstudiante' => $codigoEstudiante,
                    'nombreEstudiante' => $nombreEstudiante,
                    'idPrograma' => $idPrograma,
                    'fechaIngreso' => $fechaIngreso,
                    'horaIngreso' => $horaIngreso,
                    'idResponsable' => $idResponsable,
                    'idSala' => $idSala
                ];
    
                // Crear el ingreso
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
    
        // Obtener programas, responsables y salas
        $programas = Programa::getAll();
        $responsables = Responsable::getAll();
        $salas = Sala::getAll();
    
        // Pasar los datos a la vista de creación
        require __DIR__ . '/../views/ingresos/create.php';
    }
    
    // Método para editar un ingreso
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Verificar si se recibe el ID
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
            // Recoger datos del formulario
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                header('Location: index.php?action=index');
                exit();
            }

            $id = intval($_POST['id']);
            $codigoEstudiante = htmlspecialchars(trim($_POST['codigoEstudiante']));
            $nombreEstudiante = htmlspecialchars(trim($_POST['nombreEstudiante']));
            $fechaModificacion = date('Y-m-d H:i:s'); // Fecha de modificación actual
    
            // Datos a actualizar
            $data = [
                'codigoEstudiante' => $codigoEstudiante,
                'nombreEstudiante' => $nombreEstudiante,
                'fechaModificacion' => $fechaModificacion
            ];
    
            // Llamada al modelo para actualizar el ingreso
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

    // Método para registrar salida de un ingreso
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
