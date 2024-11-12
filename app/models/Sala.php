<?php
require_once 'Database.php';

class Sala {
    // Obtener todas las salas
    public static function getAll() {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM salas";
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Verificar disponibilidad de la sala para una fecha y hora específica
    public static function verificarDisponibilidad($idSala, $fecha, $horaIngreso) {
        $diaSemana = date('N', strtotime($fecha)); // 1 (Lunes) a 7 (Domingo)
        $horaIngresoTime = strtotime($horaIngreso);

        if ($diaSemana >= 1 && $diaSemana <= 5) { // Lunes a Viernes
            $horaInicioPermitido = strtotime("07:00");
            $horaFinPermitido = strtotime("20:50");
        } elseif ($diaSemana == 6) { // Sábado
            $horaInicioPermitido = strtotime("07:00");
            $horaFinPermitido = strtotime("16:30");
        } else { // Domingo
            return false; // No se permiten ingresos
        }

        // Verificar si la hora de ingreso está dentro del horario permitido
        if ($horaIngresoTime < $horaInicioPermitido || $horaIngresoTime > $horaFinPermitido) {
            return false;
        }

        // Verificar si la sala está ocupada en el horario solicitado
        $db = Database::getConnection();
        $query = "SELECT COUNT(*) as total FROM ingresos 
                  WHERE idSala = :idSala 
                  AND fechaIngreso = :fecha 
                  AND horaIngreso <= :horaIngreso 
                  AND (horaSalida IS NULL OR horaSalida > :horaIngreso2)";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'idSala' => $idSala,
            'fecha' => $fecha,
            'horaIngreso' => $horaIngreso,
            'horaIngreso2' => $horaIngreso 
        ]);
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        return $resultado->total == 0;
    }

    // Obtener una sala por su ID
    public static function getSalaById($id) {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM salas WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Obtener salas por nombre (útil para filtrado o búsqueda)
    public static function getSalasByName($name) {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM salas WHERE nombre LIKE :name";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
