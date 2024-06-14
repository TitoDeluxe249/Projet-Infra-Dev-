<?php

namespace App\Controllers;

use PDO; // Importation correcte de la classe PDO

class AdController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $query = 'SELECT * FROM publicites';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($ads);
    }

    public function store($data) {
        $query = 'INSERT INTO publicites (type, url, position) VALUES (:type, :url, :position)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':url', $data['url']);
        $stmt->bindParam(':position', $data['position']);
        if ($stmt->execute()) {
            return json_encode(['message' => 'Publicite created successfully']);
        } else {
            return json_encode(['message' => 'Failed to create publicite']);
        }
    }

    public function update($id, $data) {
        $query = 'UPDATE publicites SET type = :type, url = :url, position = :position WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':url', $data['url']);
        $stmt->bindParam(':position', $data['position']);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return json_encode(['message' => 'Publicite updated successfully']);
        } else {
            return json_encode(['message' => 'Failed to update publicite']);
        }
    }

    public function delete($id) {
        $query = 'DELETE FROM publicites WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return json_encode(['message' => 'Publicite deleted successfully']);
        } else {
            return json_encode(['message' => 'Failed to delete publicite']);
        }
    }
}
?>
