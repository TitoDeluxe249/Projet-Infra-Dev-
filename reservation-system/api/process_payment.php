<?php
// process_payment.php

require_once 'config.php';
require_once 'models/Reservation.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['flights']) || !isset($data['user_id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid input']);
    exit();
}

$user_id = $data['user_id'];
$flights = $data['flights'];

$db = Database::getConnection();
$reservationModel = new App\Models\Reservation($db);

$errors = [];

foreach ($flights as $flight_id) {
    $reservationModel->user_id = $user_id;
    $reservationModel->flight_id = $flight_id;
    
    if (!$reservationModel->create()) {
        $errors[] = "Failed to reserve flight ID $flight_id";
    }
}

if (empty($errors)) {
    echo json_encode(['message' => 'Reservations made successfully']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Some reservations failed', 'errors' => $errors]);
}
?>
