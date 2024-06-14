<?php
// reservation-system/api/config.php

class Database {
    private $host = 'localhost';
    private $db_name = 'reservation_system_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    // DB Connect
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }

    // Get the database connection instance
    public static function getConnection() {
        $database = new Database();
        return $database->connect();
    }
}
?>
