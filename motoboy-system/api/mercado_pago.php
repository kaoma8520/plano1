<?php
// Configurações da API do Mercado Pago
require_once '../config/config.php';

// Inicializa a biblioteca do Mercado Pago
MercadoPago\SDK::setAccessToken(MP_ACCESS_TOKEN);

// Função para criar um pagamento
function createPayment($amount, $description, $paymentMethodId, $payerEmail) {
    $payment = new MercadoPago\Payment();
    $payment->setTransactionAmount($amount);
    $payment->setDescription($description);
    $payment->setPaymentMethodId($paymentMethodId);
    $payment->setPayer(array(
        "email" => $payerEmail
    ));
    
    // Salva o pagamento e retorna o resultado
    $payment->save();
    
    return $payment;
}

// Função para verificar o status de um pagamento
function getPaymentStatus($paymentId) {
    $payment = MercadoPago\Payment::find_by_id($paymentId);
    return $payment->status;
}

// Exemplo de uso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $paymentMethodId = $_POST['paymentMethodId'];
    $payerEmail = $_POST['payerEmail'];

    $payment = createPayment($amount, $description, $paymentMethodId, $payerEmail);
    echo json_encode($payment);
}
?>