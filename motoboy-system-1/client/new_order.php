<?php
session_start();
require_once '../config/database.php';
require_once '../core/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$origin = '';
$destination = '';
$estimatedValue = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $estimatedValue = $_POST['estimated_value'];

    // Aqui você pode adicionar a lógica para inserir o pedido no banco de dados
    // e integrar com a API do Mercado Pago para o pagamento.

    // Exemplo de inserção no banco de dados (ajuste conforme sua estrutura):
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, origin, destination, estimated_value, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->execute([$userId, $origin, $destination, $estimatedValue]);

    // Enviar notificação via WhatsApp (chame a função apropriada da API)
    // require_once '../api/whatsapp.php';
    // sendWhatsAppNotification($userId, $origin, $destination, $estimatedValue);

    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Nova Corrida</title>
</head>
<body>
    <div class="container">
        <h1>Solicitar Nova Corrida</h1>
        <form action="new_order.php" method="POST">
            <label for="origin">Origem:</label>
            <input type="text" id="origin" name="origin" required value="<?php echo htmlspecialchars($origin); ?>">

            <label for="destination">Destino:</label>
            <input type="text" id="destination" name="destination" required value="<?php echo htmlspecialchars($destination); ?>">

            <label for="estimated_value">Valor Estimado:</label>
            <input type="number" id="estimated_value" name="estimated_value" required value="<?php echo htmlspecialchars($estimatedValue); ?>">

            <button type="submit">Solicitar Corrida</button>
        </form>
        <a href="dashboard.php">Voltar ao Painel</a>
    </div>
</body>
</html>