<?php
    // reservation-system/api/models/PromoCode.php

namespace App\Models;
require_once '../api/config.php';

use PDO;

class PromoCode {
    public $id;
    public $code;
    public $valeur;
    public $actif;

    public function __construct($db) {
        $this->conn = $db;
    }

    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM codes_promo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM codes_promo WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save() {
        $db = Database::getConnection();
        if ($this->id) {
            $stmt = $db->prepare("UPDATE codes_promo SET code = ?, valeur = ?, actif = ? WHERE id = ?");
            return $stmt->execute([$this->code, $this->valeur, $this->actif, $this->id]);
        } else {
            $stmt = $db->prepare("INSERT INTO codes_promo (code, valeur, actif) VALUES (?, ?, ?)");
            return $stmt->execute([$this->code, $this->valeur, $this->actif]);
        }
    }

    public function delete() {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM codes_promo WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
?>
