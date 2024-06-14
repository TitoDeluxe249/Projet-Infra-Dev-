<?php
// reservation-system/api/flights/create.php


// En-têtes HTTP pour permettre l'accès à partir de n'importe quelle origine (CORS)
// Allow CORS for all requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}


// Inclure le fichier de configuration de la base de données et la classe Flight
include_once '../config.php';
include_once '../models/Flight.php';

// Instancier la base de données et créer une connexion
$database = new Database();
$db = $database->connect();

// Instancier l'objet Flight
$flight = new Flight($db);

// Obtenir les données envoyées en JSON
$data = json_decode(file_get_contents("php://input"));

// Vérifier si les données ont été envoyées
if (
    !empty($data->airline) &&
    !empty($data->flight_number) &&
    !empty($data->departure) &&
    !empty($data->arrival) &&
    !empty($data->date) &&
    !empty($data->departure_time) &&
    !empty($data->arrival_time) &&
    !empty($data->price)
) {
    // Affecter les valeurs des propriétés de l'objet Flight
    $flight->airline = $data->airline;
    $flight->flight_number = $data->flight_number;
    $flight->departure = $data->departure;
    $flight->arrival = $data->arrival;
    $flight->date = $data->date;
    $flight->departure_time = $data->departure_time;
    $flight->arrival_time = $data->arrival_time;
    $flight->price = $data->price;

    // Créer le vol
    if ($flight->create()) {
        // Répondre avec un code 201 - Créé
        http_response_code(201);
        echo json_encode(array("message" => "Flight created successfully."));
    } else {
        // Répondre avec un code 503 - Service indisponible
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create flight."));
    }
} else {
    // Répondre avec un code 400 - Mauvaise demande
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create flight. Incomplete data."));
}
?>
