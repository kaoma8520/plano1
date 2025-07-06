<?php
session_start();
require_once '../config/database.php';
require_once '../core/auth.php';

if (!isMotoboyLoggedIn()) {
    header('Location: login.php');
    exit();
}

$motoboy_id = $_SESSION['motoboy_id'];
$query = "SELECT * FROM orders WHERE motoboy_id = ? AND status IN ('pending', 'in_progress')";
$stmt = $pdo->prepare($query);
$stmt->execute([$motoboy_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Minhas Corridas</title>
</head>
<body>
    <div class="container">
        <h1>Minhas Corridas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo htmlspecialchars($order['origin']); ?></td>
                        <td><?php echo htmlspecialchars($order['destination']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td>
                            <form action="accept_order.php" method="POST" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                <button type="submit">Aceitar</button>
                            </form>
                            <form action="reject_order.php" method="POST" style="display:inline;">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                <button type="submit">Recusar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>