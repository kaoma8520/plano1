<?php
session_start();
include_once '../config/database.php';
include_once '../core/auth.php';

// Verifica se o usuário está autenticado como admin
if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Conexão com o banco de dados
$db = new Database();
$conn = $db->getConnection();

// Função para gerar relatórios financeiros
function generateFinancialReport($conn) {
    $query = "SELECT SUM(amount) as total_revenue FROM orders WHERE status = 'completed'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para gerar relatórios operacionais
function generateOperationalReport($conn) {
    $query = "SELECT COUNT(*) as total_orders, COUNT(DISTINCT motoboy_id) as total_motoboys FROM orders";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Geração dos relatórios
$financialReport = generateFinancialReport($conn);
$operationalReport = generateOperationalReport($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Relatórios - Admin</title>
</head>
<body>
    <div class="container">
        <h1>Relatórios Financeiros e Operacionais</h1>
        <h2>Relatório Financeiro</h2>
        <p>Total de Receita: R$ <?php echo number_format($financialReport['total_revenue'], 2, ',', '.'); ?></p>

        <h2>Relatório Operacional</h2>
        <p>Total de Pedidos: <?php echo $operationalReport['total_orders']; ?></p>
        <p>Total de Motoboys: <?php echo $operationalReport['total_motoboys']; ?></p>
    </div>
</body>
</html>