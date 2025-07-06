<?php
session_start();
include '../config/database.php';
include '../core/auth.php';

// Verifica se o usuário está logado como administrador
if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Funções para obter dados do sistema
function getTotalOrders($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM orders");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTotalMotoboys($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'motoboy'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTotalClients($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'client'");
    $stmt->execute();
    return $stmt->fetchColumn();
}

$totalOrders = getTotalOrders($conn);
$totalMotoboys = getTotalMotoboys($conn);
$totalClients = getTotalClients($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Painel Administrativo</title>
</head>
<body>
    <header>
        <h1>Painel Administrativo</h1>
        <nav>
            <ul>
                <li><a href="users.php">Usuários</a></li>
                <li><a href="orders.php">Pedidos</a></li>
                <li><a href="reports.php">Relatórios</a></li>
                <li><a href="zones.php">Zonas de Atendimento</a></li>
                <li><a href="reviews.php">Avaliações</a></li>
                <li><a href="promotions.php">Promoções</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Visão Geral</h2>
        <div class="dashboard">
            <div class="card">
                <h3>Total de Pedidos</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div class="card">
                <h3>Total de Motoboys</h3>
                <p><?php echo $totalMotoboys; ?></p>
            </div>
            <div class="card">
                <h3>Total de Clientes</h3>
                <p><?php echo $totalClients; ?></p>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistema de Gerenciamento de Pedidos</p>
    </footer>
</body>
</html>