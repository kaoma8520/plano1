<?php
session_start();
include '../config/database.php';
include '../core/auth.php';

if (!isClientLoggedIn()) {
    header("Location: login.php");
    exit();
}

$clientId = $_SESSION['client_id'];
$query = "SELECT * FROM orders WHERE client_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$clientId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Histórico de Corridas</title>
</head>
<body>
    <div class="container">
        <h1>Histórico de Corridas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($orders) > 0): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['origin']); ?></td>
                            <td><?php echo htmlspecialchars($order['destination']); ?></td>
                            <td>R$ <?php echo number_format($order['amount'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhuma corrida encontrada.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php">Voltar ao Painel</a>
    </div>
</body>
</html>