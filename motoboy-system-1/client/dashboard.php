<?php
session_start();
include '../config/database.php';
include '../core/auth.php';

// Verifica se o usuário está logado
if (!isLoggedIn('client')) {
    header('Location: login.php');
    exit();
}

// Obtém informações do cliente
$clientId = $_SESSION['user_id'];
$query = "SELECT * FROM clients WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$clientId]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtém o histórico de pedidos do cliente
$queryOrders = "SELECT * FROM orders WHERE client_id = ? ORDER BY created_at DESC";
$stmtOrders = $pdo->prepare($queryOrders);
$stmtOrders->execute([$clientId]);
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Painel do Cliente</title>
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($client['name']); ?></h1>
        <nav>
            <a href="new_order.php">Solicitar Corrida</a>
            <a href="history.php">Histórico de Corridas</a>
            <a href="review.php">Avaliar Motoboy</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <h2>Seus Pedidos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['origin']); ?></td>
                        <td><?php echo htmlspecialchars($order['destination']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($order['created_at']))); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Motoboy System. Todos os direitos reservados.</p>
    </footer>
</body>
</html>