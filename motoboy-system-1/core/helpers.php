<?php
// Função para sanitizar entradas de dados
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Função para gerar um código único
function generateUniqueCode($length = 10) {
    return bin2hex(random_bytes($length));
}

// Função para calcular a porcentagem
function calculatePercentage($amount, $percentage) {
    return ($amount * $percentage) / 100;
}

// Função para formatar valores monetários
function formatCurrency($amount) {
    return number_format($amount, 2, ',', '.');
}

// Função para enviar notificações via WhatsApp
function sendWhatsAppNotification($phoneNumber, $message) {
    // Implementar integração com a API do WhatsApp
}

// Função para calcular a distância entre dois pontos (opcional)
function calculateDistance($origin, $destination) {
    // Implementar integração com a API do Google Maps
}
?>