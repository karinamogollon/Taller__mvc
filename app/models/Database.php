<?php

class Database {
    private static $instance = null;

    // Método para obtener la instancia de conexión
    public static function getConnection() {
        if (self::$instance === null) {
            $host = 'localhost'; 
            $db = 'ingresos_salas_db'; 
            $user = 'root'; 
            $pass = ''; 
            $charset = 'utf8mb4';

            // Crear el DSN para PDO
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                // Intentar crear una nueva instancia de PDO y almacenarla en $instance
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Si falla la conexión, lanzar una excepción con el mensaje de error
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$instance;
    }

    // Evitar la clonación de la instancia
    private function __clone() {}

    // Constructor privado para evitar instancias múltiples
    private function __construct() {}
}
?>
