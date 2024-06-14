<?php
// reservation-system/api/controllers/AuthController.php

namespace App\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PDO;

class AuthController {
    private $key = "YOUR_SECRET_KEY";
    private $db;

    // Constructeur prenant l'objet de connexion à la base de données en paramètre
    public function __construct($db) {
        $this->db = $db;
    }

    public function register($data) {
        if(isset($data['username']) && isset($data['email']) && isset($data['password'])) {
            $user = new User($this->db);
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_BCRYPT);
            if ($user->save()) {
                return json_encode(['message' => 'User registered successfully']);
            } else {
                http_response_code(500);
                return json_encode(['message' => 'User registration failed']);
            }
        } else {
            http_response_code(400);
            return json_encode(['message' => 'Missing data for user registration']);
        }
    }

    public function login($data) {
        $user = User::findByUsername($this->db, $data['username']);
        if ($user && password_verify($data['password'], $user->password)) {
            // Commencer la session
            session_start();
            // Stocker l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $user->id;
            // Générer le token JWT
            $payload = [
                'iss' => 'localhost',
                'aud' => 'localhost',
                'iat' => time(),
                'exp' => time() + (60*60),
                'userId' => $user->id
            ];
            $jwt = JWT::encode($payload, $this->key, 'HS256');
            return json_encode(['token' => $jwt]);
        } else {
            http_response_code(401);
            return json_encode(['message' => 'Login failed']);
        }
    }        
    
    public function getProfile($userId) {
        $user = new User($this->db);
        $profile = $user->getProfile($userId);

        if ($profile) {
            // Ajouter les codes promos de l'utilisateur
            $promoCodeController = new PromoCodeController($this->db);
            $profile['promoCodes'] = $promoCodeController->getUserPromoCodes($userId);

            return json_encode($profile);
        } else {
            return json_encode(['message' => 'Utilisateur non trouvé']);
        }
    }

    public function authenticate() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $matches = [];
            if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
                try {
                    $decoded = JWT::decode($matches[1], $this->key, ['HS256']);
                    return $decoded->userId;
                } catch (\Exception $e) {
                    return null;
                }
            }
        }
        return null;
    }    
}
?>
