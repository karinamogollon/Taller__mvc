<?php

require_once 'Database.php';

class Responsable {
    // Obtener todos los responsables
    public static function getAll() {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM responsables";
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener un responsable por su ID
    public static function getResponsableById($id) {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM responsables WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Obtener responsables por nombre (útil para filtrado o búsqueda)
    public static function getResponsablesByName($name) {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM responsables WHERE nombre LIKE :name";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
