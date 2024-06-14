<?php
session_start();

if (!isset($_SESSION['token'])) {
    echo json_encode(['error' => 'User not authenticated']);
    exit;
}

$token = $_SESSION['token'];
$url = 'http://localhost:8000/api/user'; // L'URL de votre API pour obtenir les détails de l'utilisateur
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
));

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error:' . curl_error($ch)]);
} else {
    echo $result;
}

curl_close($ch);
?>
