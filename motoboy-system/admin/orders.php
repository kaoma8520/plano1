<?php
session_start();
include '../config/database.php';
include '../core/auth.php';

// Verifica se o usuário está logado como administrador
if (!isAdminLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Filtragem de pedidos
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$date_filter = isset($_GET['date']) ? $_GET['date'] : '';
$payment_filter = isset($_GET['payment']) ? $_GET['payment'] : '';

// Consulta SQL para buscar pedidos
$sql = "SELECT * FROM orders WHERE 1=1";

if ($status_filter) {
    $sql .= " AND status = '" . $conn->real_escape_string($status_filter) . "'";
}
if ($date_filter) {
    $sql .= " AND DATE(order_date) = '" . $conn->real_escape_string($date_filter) . "'";
}
if ($payment_filter) {
    $sql .= " AND payment_method = '" . $conn->real_escape_string($payment_filter) . "'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Gerenciamento de Pedidos</title>
</head>
<body>
    <h1>Gerenciamento de Pedidos</h1>
    
    <form method="GET" action="orders.php">
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">Todos</option>
            <option value="pendente" <?php if ($status_filter == 'pendente') echo 'selected'; ?>>Pendente</option>
            <option value="em andamento" <?php if ($status_filter == 'em andamento') echo 'selected'; ?>>Em Andamento</option>
            <option value="finalizada" <?php if ($status_filter == 'finalizada') echo 'selected'; ?>>Finalizada</option>
        </select>

        <label for="date">Data:</label>
        <input type="date" name="date" id="date" value="<?php echo $date_filter; ?>">

        <label for="payment">Forma de Pagamento:</label>
        <select name="payment" id="payment">
            <option value="">Todas</option>
            <option value="PIX" <?php if ($payment_filter == 'PIX') echo 'selected'; ?>>PIX</option>
            <option value="Cartão" <?php if ($payment_filter == 'Cartão') echo 'selected'; ?>>Cartão</option>
        </select>

        <button type="submit">Filtrar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Data do Pedido</th>
                <th>Forma de Pagamento</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['client_name']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['order_date']}</td>
                        <td>{$row['payment_method']}</td>
                        <td>{$row['total_amount']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nenhum pedido encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="dashboard.php">Voltar ao Painel</a>
</body>
</html>

<?php
$conn->close();
?>