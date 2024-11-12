<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'ingresos_salas_db');
define('DB_USER', 'root');
define('DB_PASS', '');

function connectDB() {
    try {
        return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        die("Error al conectar a la base de datos: " . $e->getMessage());
    }
}
