<?php
session_start();
include '../config/database.php';
include '../core/auth.php';

if (!isMotoboyLoggedIn()) {
    header("Location: login.php");
    exit();
}

$motoboy_id = $_SESSION['motoboy_id'];
$query = "SELECT * FROM orders WHERE motoboy_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$motoboy_id]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <th>Status</th>
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($history) > 0): ?>
                    <?php foreach ($history as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['origin']); ?></td>
                            <td><?php echo htmlspecialchars($order['destination']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                            <td>R$ <?php echo number_format($order['amount'], 2, ',', '.'); ?></td>
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