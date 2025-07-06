<?php
session_start();
include_once '../config/database.php';

function validateCoupon($code) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = ? AND expiration_date >= NOW() AND is_active = 1");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $coupon = $result->fetch_assoc();
        return [
            'valid' => true,
            'discount' => $coupon['discount'],
            'message' => 'Cupom válido! Desconto de ' . $coupon['discount'] . '% aplicado.'
        ];
    } else {
        return [
            'valid' => false,
            'message' => 'Cupom inválido ou expirado.'
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $couponCode = $_POST['coupon_code'] ?? '';
    $response = validateCoupon($couponCode);
    echo json_encode($response);
}
?>