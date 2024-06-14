<?php
// reservation-system/api/controllers/FlightController.php

namespace App\Controllers;

// Allow CORS for all requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

use App\Models\Flight;
use Database;

require_once __DIR__ . '/../config.php';

class FlightController {
    public function index() {
        $db = Database::getConnection(); // Obtenez l'objet de connexion à la base de données
        $flightModel = new Flight($db); // Passez l'objet de connexion à la base de données au constructeur de Flight
        $flights = $flightModel->getAll(); // Appel de la méthode getAll() pour obtenir tous les vols
        return json_encode($flights); // Retourne les vols encodés en JSON
    }

    public function store($data) {
        $flight = new Flight();
        $flight->airline = $data['airline'];
        $flight->flight_number = $data['flight_number'];
        $flight->departure = $data['departure'];
        $flight->arrival = $data['arrival'];
        $flight->date = $data['date'];
        $flight->departure_time = $data['departure_time'];
        $flight->arrival_time = $data['arrival_time'];
        $flight->price = $data['price'];
        if ($flight->save()) {
            return json_encode(['message' => 'Flight added successfully']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Failed to add flight']);
        }
    }

    public function update($id, $data) {
        $db = Database::getConnection(); // Obtenez l'objet de connexion à la base de données
        $flight = new Flight($db);
        $flight = $flight->findById($id);
        if ($flight) {
            $flight->airline = $data['airline'];
            $flight->flight_number = $data['flight_number'];
            $flight->departure = $data['departure'];
            $flight->arrival = $data['arrival'];
            $flight->date = $data['date'];
            $flight->departure_time = $data['departure_time'];
            $flight->arrival_time = $data['arrival_time'];
            $flight->price = $data['price'];
            if ($flight->save()) {
                return json_encode(['message' => 'Flight updated successfully']);
            } else {
                http_response_code(500);
                return json_encode(['message' => 'Failed to update flight']);
            }
        } else {
            http_response_code(404);
            return json_encode(['message' => 'Flight not found']);
        }
    }

    public function delete($id) {
        $db = Database::getConnection(); // Obtenez l'objet de connexion à la base de données
        $flight = new Flight($db);
        $flight = $flight->findById($id);
        if ($flight && $flight->delete()) {
            return json_encode(['message' => 'Flight deleted successfully']);
        } else {
            http_response_code(500);
            return json_encode(['message' => 'Failed to delete flight']);
        }
    }
}
?>
