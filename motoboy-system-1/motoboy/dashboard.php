<?php
session_start();
include '../config/database.php';
include '../core/auth.php';

// Verifica se o motoboy está logado
if (!isMotoboyLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Obtém informações do motoboy logado
$motoboyId = $_SESSION['motoboy_id'];
$query = "SELECT * FROM motoboys WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$motoboyId]);
$motoboy = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtém corridas atribuídas ao motoboy
$queryOrders = "SELECT * FROM orders WHERE motoboy_id = ? ORDER BY created_at DESC";
$stmtOrders = $pdo->prepare($queryOrders);
$stmtOrders->execute([$motoboyId]);
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Painel do Motoboy</title>
</head>
<body>
    <header>
        <h1>Bem-vindo, <?php echo htmlspecialchars($motoboy['name']); ?></h1>
        <nav>
            <ul>
                <li><a href="orders.php">Corridas</a></li>
                <li><a href="history.php">Histórico</a></li>
                <li><a href="availability.php">Disponibilidade</a></li>
                <li><a href="../core/logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Corridas Atribuídas</h2>
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
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>