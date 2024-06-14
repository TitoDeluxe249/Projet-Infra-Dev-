<?php
    // reservation-system/api/models/Contact.php

namespace App\Models;

use PDO;

class Contact {
    public $id;
    public $email;
    public $sujet;
    public $message;

    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM demandes_contact");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save() {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO demandes_contact (email, sujet, message) VALUES (?, ?, ?)");
        return $stmt->execute([$this->email, $this->sujet, $this->message]);
    }
}
?>
