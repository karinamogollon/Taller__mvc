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

    public static function getAllIngresos($date = null) {
        $db = Database::getConnection();
        $query = "SELECT * FROM ingresos WHERE DATE(fechaIngreso) = :date";
        $stmt = $db->prepare($query);
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function createIngreso($data) {
        $db = Database::getConnection();
        $query = "INSERT INTO ingresos (codigoEstudiante, nombreEstudiante, idPrograma, fechaIngreso, horaIngreso, idResponsable, idSala, created_at) VALUES (:codigoEstudiante, :nombreEstudiante, :idPrograma, :fechaIngreso, :horaIngreso, :idResponsable, :idSala, NOW())";
        $stmt = $db->prepare($query);
        return $stmt->execute($data);
    }

    public static function updateIngreso($id, $data) {
        $db = Database::getConnection();
        $query = "UPDATE ingresos SET codigoEstudiante = :codigoEstudiante, nombreEstudiante = :nombreEstudiante, updated_at = NOW() WHERE id = :id";
        $stmt = $db->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }
}
