<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['motoboy_id'])) {
    header("Location: login.php");
    exit();
}

$motoboy_id = $_SESSION['motoboy_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'] == 'active' ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE motoboys SET available = :available WHERE id = :id");
    $stmt->execute(['available' => $status, 'id' => $motoboy_id]);

    $message = $status ? "Você está agora disponível para receber corridas." : "Você está agora indisponível para receber corridas.";
}

$stmt = $pdo->prepare("SELECT available FROM motoboys WHERE id = :id");
$stmt->execute(['id' => $motoboy_id]);
$motoboy = $stmt->fetch();

$availability = $motoboy['available'] ? 'active' : 'inactive';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Disponibilidade - Motoboy</title>
</head>
<body>
    <div class="container">
        <h1>Controle de Disponibilidade</h1>
        <?php if (isset($message)): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>
                <input type="radio" name="status" value="active" <?php echo $availability == 'active' ? 'checked' : ''; ?>> Disponível
            </label>
            <label>
                <input type="radio" name="status" value="inactive" <?php echo $availability == 'inactive' ? 'checked' : ''; ?>> Indisponível
            </label>
            <button type="submit">Atualizar Disponibilidade</button>
        </form>
        <a href="dashboard.php">Voltar ao Painel</a>
    </div>
</body>
</html>