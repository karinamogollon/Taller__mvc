<?php

require_once 'Database.php';

class Ingreso {
    public $id;
    public $codigoEstudiante;
    public $nombreEstudiante;
    public $idPrograma;
    public $fechaIngreso;
    public $horaIngreso;
    public $horaSalida;
    public $idResponsable;
    public $idSala;
    public $created_at;
    public $updated_at;

    // Obtener todos los ingresos para una fecha específica
    public static function getAllIngresos($date = null) {
        $db = Database::getConnection();
        $query = "SELECT * FROM ingresos WHERE DATE(fechaIngreso) = :date";
        $stmt = $db->prepare($query);
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Crear un nuevo registro de ingreso
    public static function createIngreso($data) {
        $pdo = Database::getConnection();
    
        if (!$pdo) {
            return false;
        }
    
        $query = "INSERT INTO ingresos (codigoEstudiante, nombreEstudiante, idPrograma, fechaIngreso, horaIngreso, idResponsable, idSala, fechaCreacion) 
                  VALUES (:codigoEstudiante, :nombreEstudiante, :idPrograma, :fechaIngreso, :horaIngreso, :idResponsable, :idSala, :fechaCreacion)";
    
        $statement = $pdo->prepare($query);
        $statement->bindParam(':codigoEstudiante', $data['codigoEstudiante']);
        $statement->bindParam(':nombreEstudiante', $data['nombreEstudiante']);
        $statement->bindParam(':idPrograma', $data['idPrograma']);
        $statement->bindParam(':fechaIngreso', $data['fechaIngreso']);
        $statement->bindParam(':horaIngreso', $data['horaIngreso']);
        $statement->bindParam(':idResponsable', $data['idResponsable']);
        $statement->bindParam(':idSala', $data['idSala']);
        $statement->bindParam(':fechaCreacion', date('Y-m-d H:i:s')); // Fecha actual como fecha de creación
    
        return $statement->execute();
    }
    
    

    // Actualizar información del ingreso (nombre y código de estudiante)
    public static function updateIngreso($id, $data) {
        $pdo = Database::getConnection();
    
        if (!$pdo) {
            return false;
        }
    
        $query = "UPDATE ingresos SET codigoEstudiante = :codigoEstudiante, nombreEstudiante = :nombreEstudiante, 
                  fechaModificacion = :fechaModificacion WHERE id = :id";
    
        $statement = $pdo->prepare($query);
        $statement->bindParam(':codigoEstudiante', $data['codigoEstudiante']);
        $statement->bindParam(':nombreEstudiante', $data['nombreEstudiante']);
        $statement->bindParam(':fechaModificacion', date('Y-m-d H:i:s')); // Fecha actual como fecha de modificación
        $statement->bindParam(':id', $id);
    
        return $statement->execute();
    }
    

    // Registrar la salida del estudiante actualizando la hora de salida
    public static function registrarSalida($id) {
        $db = Database::getConnection();
        $query = "UPDATE ingresos SET horaSalida = NOW(), updated_at = NOW() WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Filtrar ingresos según criterios específicos
    public static function getIngresosFiltrados($fechaInicio = null, $fechaFin = null, $codigoEstudiante = null, $idPrograma = null, $idResponsable = null) {
        $db = Database::getConnection();
        $query = "SELECT * FROM ingresos WHERE 1=1";
        
        if ($fechaInicio) $query .= " AND DATE(fechaIngreso) >= :fechaInicio";
        if ($fechaFin) $query .= " AND DATE(fechaIngreso) <= :fechaFin";
        if ($codigoEstudiante) $query .= " AND codigoEstudiante = :codigoEstudiante";
        if ($idPrograma) $query .= " AND idPrograma = :idPrograma";
        if ($idResponsable) $query .= " AND idResponsable = :idResponsable";
        
        $stmt = $db->prepare($query);
        
        if ($fechaInicio) $stmt->bindParam(':fechaInicio', $fechaInicio);
        if ($fechaFin) $stmt->bindParam(':fechaFin', $fechaFin);
        if ($codigoEstudiante) $stmt->bindParam(':codigoEstudiante', $codigoEstudiante);
        if ($idPrograma) $stmt->bindParam(':idPrograma', $idPrograma, PDO::PARAM_INT);
        if ($idResponsable) $stmt->bindParam(':idResponsable', $idResponsable, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Verificar si una sala está disponible en un horario específico
    public static function verificarDisponibilidad($idSala, $fechaIngreso, $horaIngreso) {
        $db = Database::getConnection();
        $query = "SELECT COUNT(*) FROM ingresos 
                  WHERE idSala = :idSala AND fechaIngreso = :fechaIngreso 
                  AND (horaSalida IS NULL OR :horaIngreso BETWEEN horaIngreso AND horaSalida)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':idSala', $idSala, PDO::PARAM_INT);
        $stmt->bindParam(':fechaIngreso', $fechaIngreso);
        $stmt->bindParam(':horaIngreso', $horaIngreso);
        
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        return $count == 0;  // Retorna verdadero si no hay registros en el mismo horario
    }

    // Obtener ingreso por ID
    public static function getIngresoById($id) {
    $pdo = Database::getConnection();

    if (!$pdo) {
        return null;
    }

    $query = "SELECT i.*, p.nombre AS programa_nombre, s.nombre AS sala_nombre, r.nombre AS responsable_nombre
              FROM ingresos i
              JOIN programas p ON i.idPrograma = p.id
              JOIN salas s ON i.idSala = s.id
              JOIN responsables r ON i.idResponsable = r.id
              WHERE i.id = :id";
    
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_OBJ);
}

    // Mostrar el listado de ingresos del día actual
    public static function mostrarIngresosDelDia() {
        $fechaActual = date('Y-m-d');
        return self::getAllIngresos($fechaActual);
    }

    // Registrar un nuevo ingreso
    public static function registrarNuevoIngreso($data) {
        // Verificar disponibilidad de la sala
        $salaDisponible = self::verificarDisponibilidad($data['idSala'], $data['fechaIngreso'], $data['horaIngreso']);
        
        if ($salaDisponible) {
            // Si la sala está disponible, registrar el ingreso
            return self::createIngreso($data);
        }
        return false; // Si la sala no está disponible
    }

    // Filtrar ingresos según los parámetros
    public static function filtrarIngresos($fechaInicio, $fechaFin, $codigoEstudiante, $idPrograma, $idResponsable) {
        return self::getIngresosFiltrados($fechaInicio, $fechaFin, $codigoEstudiante, $idPrograma, $idResponsable);
    }

    // Actualizar ingreso
    public static function actualizarIngreso($id, $data) {
        return self::updateIngreso($id, $data);
    }

    // Registrar la salida
    public static function registrarSalidaDeEstudiante($id) {
        return self::registrarSalida($id);
    }
}
