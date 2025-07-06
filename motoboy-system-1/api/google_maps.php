<?php
// Este arquivo contém funções para interagir com a API do Google Maps, como calcular distâncias e rotas.

function getDistance($origin, $destination) {
    $apiKey = 'SUA_CHAVE_API_DO_GOOGLE_MAPS';
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $apiKey;

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] === 'OK') {
        $distance = $data['rows'][0]['elements'][0]['distance']['text'];
        return $distance;
    } else {
        return null;
    }
}

function getRoute($origin, $destination) {
    $apiKey = 'SUA_CHAVE_API_DO_GOOGLE_MAPS';
    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($origin) . "&destination=" . urlencode($destination) . "&key=" . $apiKey;

    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] === 'OK') {
        return $data['routes'][0]['legs'][0]['steps'];
    } else {
        return null;
    }
}
?>