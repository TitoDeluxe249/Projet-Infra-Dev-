<?php
// reservation-system/api/flights/read.php


// Allow CORS for all requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight (OPTIONS) requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../config.php';
include_once '../models/Flight.php';

$database = new Database();
$db = $database->connect();

$flight = new Flight($db);

$result = $flight->read();
$num = $result->rowCount();

if ($num > 0) {
    $flights_arr = array();
    $flights_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $flight_item = array(
            'id' => $id,
            'airline' => $airline,
            'flight_number' => $flight_number,
            'departure' => $departure,
            'arrival' => $arrival,
            'date' => $date,
            'departure_time' => $departure_time,
            'arrival_time' => $arrival_time,
            'price' => $price
        );
        array_push($flights_arr['data'], $flight_item);
    }

    echo json_encode($flights_arr);
} else {
    echo json_encode(
        array('message' => 'No flights found.')
    );
}
?>
