<?php
// reservation-system/api/routes/api.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


require_once '../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\FlightController;
use App\Controllers\ReservationController;
use App\Controllers\PromoCodeController;
use App\Controllers\ContactController;
use App\Controllers\AdController; // Ajout du contrôleur des publicités

// Inclusion du fichier contenant la définition de la classe Database
require_once '../api/config.php';

// Obtention de l'objet de connexion à la base de données
$db = Database::getConnection();

$authController = new AuthController($db);
$flightController = new FlightController($db);
$reservationController = new ReservationController($db);
$promoCodeController = new PromoCodeController($db);
$contactController = new ContactController($db);
$adController = new AdController($db);

header('Content-Type: application/json');
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

switch (true) {
    case $requestUri === '/api/register' && $requestMethod === 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo $authController->register($data);
        break;
    case $requestUri === '/api/login' && $requestMethod === 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo $authController->login($data);
        break;
        case $requestUri === '/api/user/profile' && $requestMethod === 'GET':
            $userId = $authController->authenticate();
            if ($userId) {
                echo $authController->getProfile($userId);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
            }
            break;
    case $requestUri === '/api/check-login-status' && $requestMethod === 'GET':
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['loggedIn' => true]);
        } else {
            echo json_encode(['loggedIn' => false]);
        }
        break;
    case $requestUri === '/api/flights' && $requestMethod === 'GET':
        echo $flightController->index();
        break;
    case $requestUri === '/api/flights' && $requestMethod === 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo $flightController->store($data);
        break;
    case preg_match('/\/api\/flights\/(\d+)/', $requestUri, $matches):
        $flightId = $matches[1];
        if ($requestMethod === 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            echo $flightController->update($flightId, $data);
        } elseif ($requestMethod === 'DELETE') {
            echo $flightController->delete($flightId);
        }
        break;
    case $requestUri === '/api/reservations' && $requestMethod === 'GET':
        echo $reservationController->index();
        break;
    case $requestUri === '/api/reservations' && $requestMethod === 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo $reservationController->store($data);
        break;
    case preg_match('/\/api\/reservations\/(\d+)/', $requestUri, $matches):
        $reservationId = $matches[1];
        if ($requestMethod === 'DELETE') {
            echo $reservationController->delete($reservationId);
        }
        break;
    case $requestUri === '/api/promocodes' && $requestMethod === 'GET':
        echo $promoCodeController->index();
        break;
    case $requestUri === '/api/promocodes' && $requestMethod === 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo $promoCodeController->store($data);
        break;
    case preg_match('/\/api\/promocodes\/(\d+)/', $requestUri, $matches):
        $promoCodeId = $matches[1];
        if ($requestMethod === 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            echo $promoCodeController->update($promoCodeId, $data);
        } elseif ($requestMethod === 'DELETE') {
            echo $promoCodeController->delete($promoCodeId);
        }
        break;
    case $requestUri === '/api/contact' && $requestMethod === 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo $contactController->store($data);
        break;
    case $requestUri === '/api/publicites' && $requestMethod === 'GET': // Route pour récupérer les publicités
        echo $adController->index();
        break;
    case $requestUri === '/api/publicites' && $requestMethod === 'POST': // Route pour créer une publicité
        $data = json_decode(file_get_contents("php://input"), true);
        echo $adController->store($data);
        break;
    case preg_match('/\/api\/publicites\/(\d+)/', $requestUri, $matches): // Route pour mettre à jour ou supprimer une publicité
        $adId = $matches[1];
        if ($requestMethod === 'PUT') {
            $data = json_decode(file_get_contents("php://input"), true);
            echo $adController->update($adId, $data);
        } elseif ($requestMethod === 'DELETE') {
            echo $adController->delete($adId);
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
        break;
}
?>
