<?php
    // reservation-system/api/models/Reservation.php

    namespace App\Models;

    use PDO;
    
    class Reservation {
        private $conn;
        protected static $table = 'reservations';
    
        public $id;
        public $user_id;
        public $flight_id;
        public $booking_date;
    
        public function __construct($db) {
            $this->conn = $db;
        }
    
        public static function getAll($db) {
            $query = 'SELECT * FROM ' . self::$table;
            $stmt = $db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        public function create($user_id, $flight_id, $booking_date) {
            $query = 'INSERT INTO ' . self::$table . ' SET user_id = :user_id, flight_id = :flight_id, booking_date = :booking_date';
            $stmt = $this->conn->prepare($query);
        
            // Ajout de journaux de débogage
            error_log("Creating reservation with user_id: $user_id, flight_id: $flight_id, booking_date: $booking_date");
        
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':flight_id', $flight_id);
            $stmt->bindParam(':booking_date', $booking_date);
        
            if ($stmt->execute()) {
                return true;
            }
        
            printf("Error: %s.\n", $stmt->error);
            return false;
        }        
    
        public function save() {
            return $this->create($this->user_id, $this->flight_id, $this->booking_date);
        }
    
        public function delete() {
            $query = 'DELETE FROM ' . self::$table . ' WHERE id = :id';
            $stmt = $this->conn->prepare($query);
    
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            $stmt->bindParam(':id', $this->id);
    
            if ($stmt->execute()) {
                return true;
            }
    
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
?>
