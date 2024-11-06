<?php

require_once 'Database.php';

class Responsable {
    public static function getAll() {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM responsables";
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
