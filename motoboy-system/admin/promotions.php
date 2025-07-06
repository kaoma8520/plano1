<?php
session_start();
include_once '../config/database.php';
include_once '../core/auth.php';

if (!isAdminLoggedIn()) {
    header('Location: login.php');
    exit();
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $promo_code = $_POST['promo_code'];
    $discount_value = $_POST['discount_value'];
    $expiration_date = $_POST['expiration_date'];

    $stmt = $conn->prepare("INSERT INTO promotions (promo_code, discount_value, expiration_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $promo_code, $discount_value, $expiration_date);

    if ($stmt->execute()) {
        $message = "Promoção criada com sucesso!";
    } else {
        $message = "Erro ao criar promoção: " . $stmt->error;
    }
}

$promotions = [];
$result = $conn->query("SELECT * FROM promotions");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $promotions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Promoções</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Gerenciar Promoções</h1>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        
        <form method="POST" action="">
            <label for="promo_code">Código Promocional:</label>
            <input type="text" name="promo_code" required>
            
            <label for="discount_value">Valor do Desconto (%):</label>
            <input type="number" name="discount_value" required>
            
            <label for="expiration_date">Data de Expiração:</label>
            <input type="date" name="expiration_date" required>
            
            <button type="submit">Criar Promoção</button>
        </form>

        <h2>Promoções Atuais</h2>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Desconto (%)</th>
                    <th>Data de Expiração</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promotions as $promotion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($promotion['promo_code']); ?></td>
                        <td><?php echo htmlspecialchars($promotion['discount_value']); ?></td>
                        <td><?php echo htmlspecialchars($promotion['expiration_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>