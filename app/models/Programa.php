<?php

require_once 'Database.php';

class Programa {
    public static function getAll() {
        $db = Database::getConnection();
        $query = "SELECT id, nombre FROM programas";
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
