<?php
// reservation-system/api/models/Flight.php

namespace App\Models;
use PDO;

class Flight {
    private $conn;
    private $table = 'flights';

    public $id;
    public $airline;
    public $flight_number;
    public $departure;
    public $arrival;
    public $date;
    public $departure_time;
    public $arrival_time;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET airline = :airline, flight_number = :flight_number, departure = :departure, arrival = :arrival, date = :date, departure_time = :departure_time, arrival_time = :arrival_time, price = :price';
        $stmt = $this->conn->prepare($query);

        $this->airline = htmlspecialchars(strip_tags($this->airline));
        $this->flight_number = htmlspecialchars(strip_tags($this->flight_number));
        $this->departure = htmlspecialchars(strip_tags($this->departure));
        $this->arrival = htmlspecialchars(strip_tags($this->arrival));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->departure_time = htmlspecialchars(strip_tags($this->departure_time));
        $this->arrival_time = htmlspecialchars(strip_tags($this->arrival_time));
        $this->price = htmlspecialchars(strip_tags($this->price));

        $stmt->bindParam(':airline', $this->airline);
        $stmt->bindParam(':flight_number', $this->flight_number);
        $stmt->bindParam(':departure', $this->departure);
        $stmt->bindParam(':arrival', $this->arrival);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':departure_time', $this->departure_time);
        $stmt->bindParam(':arrival_time', $this->arrival_time);
        $stmt->bindParam(':price', $this->price);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET airline = :airline, flight_number = :flight_number, departure = :departure, arrival = :arrival, date = :date, departure_time = :departure_time, arrival_time = :arrival_time, price = :price WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->airline = htmlspecialchars(strip_tags($this->airline));
        $this->flight_number = htmlspecialchars(strip_tags($this->flight_number));
        $this->departure = htmlspecialchars(strip_tags($this->departure));
        $this->arrival = htmlspecialchars(strip_tags($this->arrival));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->departure_time = htmlspecialchars(strip_tags($this->departure_time));
        $this->arrival_time = htmlspecialchars(strip_tags($this->arrival_time));
        $this->price = htmlspecialchars(strip_tags($this->price));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':airline', $this->airline);
        $stmt->bindParam(':flight_number', $this->flight_number);
        $stmt->bindParam(':departure', $this->departure);
        $stmt->bindParam(':arrival', $this->arrival);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':departure_time', $this->departure_time);
        $stmt->bindParam(':arrival_time', $this->arrival_time);
        $stmt->bindParam(':price', $this->price);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
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
