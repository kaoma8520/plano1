<?php
function sendWhatsAppMessage($phoneNumber, $message) {
    $url = 'https://api.whatsapp.com/send?phone=' . urlencode($phoneNumber) . '&text=' . urlencode($message);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

function notifyMotoboy($motoboyPhone, $orderDetails) {
    $message = "Nova corrida atribuída:\n" . $orderDetails;
    return sendWhatsAppMessage($motoboyPhone, $message);
}

function notifyClient($clientPhone, $orderStatus) {
    $message = "Atualização do status da sua corrida:\n" . $orderStatus;
    return sendWhatsAppMessage($clientPhone, $message);
}
?>