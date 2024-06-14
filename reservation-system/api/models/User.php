<?php
    // reservation-system/api/models/User.php

namespace App\Models;
use PDO;

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET username = :username, email = :email, password = :password';
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function login() {
        $query = 'SELECT id, username, password FROM ' . $this->table . ' WHERE username = :username';
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));

        $stmt->bindParam(':username', $this->username);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->password = $row['password'];

            return true;
        }

        return false;
    }

    // Méthode save pour sauvegarder un utilisateur
    public function save() {
        if(isset($this->id)) {
            // Update existing user
            $query = 'UPDATE ' . $this->table . ' 
                      SET username = :username, email = :email, password = :password 
                      WHERE id = :id';
            $stmt = $this->conn->prepare($query);

            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
        } else {
            // Insert new user
            $query = 'INSERT INTO ' . $this->table . ' 
                      SET username = :username, email = :email, password = :password';
            $stmt = $this->conn->prepare($query);

            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
        }

        if ($stmt->execute()) {
            if (!isset($this->id)) {
                $this->id = $this->conn->lastInsertId();
            }
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }


    public function getProfile($id) {
        $query = 'SELECT username, email FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    // Méthode findByUsername pour rechercher un utilisateur par nom d'utilisateur
    public static function findByUsername($db, $username) {
        $query = 'SELECT id, username, email, password FROM users WHERE username = :username';
        $stmt = $db->prepare($query);

        $username = htmlspecialchars(strip_tags($username));

        $stmt->bindParam(':username', $username);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $user = new self($db);
            $user->id = $row['id'];
            $user->username = $row['username'];
            $user->email = $row['email'];
            $user->password = $row['password'];

            return $user;
        }

        return null;
    }
}
?>
