<?php
    // reservation-system/api/controllers/ReservationController.php

    namespace App\Controllers;

    use App\Models\Reservation;
    
    class ReservationController {
        private $db;
    
        public function __construct($db) {
            $this->db = $db;
        }
    
        public function index() {
            $reservations = Reservation::getAll($this->db);
            return json_encode($reservations);
        }
    
        public function store($data) {
            $reservation = new Reservation($this->db);
            $user_id = $data['user_id'];
            $flight_id = $data['flight_id'];
            $booking_date = $data['booking_date'];
    
            // Appeler la méthode create avec les trois arguments attendus
            if ($reservation->create($user_id, $flight_id, $booking_date)) {
                return json_encode(['message' => 'Reservation made successfully']);
            } else {
                http_response_code(500);
                return json_encode(['message' => 'Failed to make reservation']);
            }
        }
    
        public function delete($id) {
            $reservation = new Reservation($this->db);
            $reservation->id = $id;
    
            if ($reservation->delete()) {
                return json_encode(['message' => 'Reservation deleted successfully']);
            } else {
                http_response_code(500);
                return json_encode(['message' => 'Failed to delete reservation']);
            }
        }
    }
    
?>
