<?php
require_once 'Database.php';

class HorarioSala {
    private $db;
    private $table = 'horarios_salas';

    public function __construct() {
        $this->db = Database::getConnection(); // Obtiene la conexión singleton
    }

    // Obtener todos los horarios
    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener horario por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar disponibilidad de una sala en una fecha y hora específicas
    public function verificarDisponibilidad($idSala, $fecha, $hora) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE idSala = :idSala 
                  AND fecha = :fecha 
                  AND :hora BETWEEN horaInicio AND horaFin";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idSala', $idSala, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    } // Aquí se cierra correctamente el método verificarDisponibilidad

    // Crear nuevo horario de sala
    public function createHorario($data) {
        $query = "INSERT INTO " . $this->table . " (idSala, fecha, horaInicio, horaFin) 
                  VALUES (:idSala, :fecha, :horaInicio, :horaFin)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    // Actualizar horario de sala
    public function updateHorario($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET idSala = :idSala, fecha = :fecha, horaInicio = :horaInicio, horaFin = :horaFin 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Eliminar horario de sala
    public function deleteHorario($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
