<?php

require_once 'Database.php';

class Programa {
    // Obtener todos los programas
    public static function getAll() {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM programas";
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener un programa por su ID
    public static function getProgramById($id) {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM programas WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Obtener un programa por su nombre (para búsquedas o filtros)
    public static function getProgramByName($name) {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM programas WHERE nombre LIKE :name";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
