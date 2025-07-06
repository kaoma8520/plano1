<?php
session_start();
require_once '../config/database.php';
require_once '../core/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$orderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    if ($rating > 0 && $orderId > 0) {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, order_id, rating, comment) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$userId, $orderId, $rating, $comment])) {
            echo "<script>alert('Avaliação enviada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao enviar avaliação. Tente novamente.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Avaliar Motoboy</title>
</head>
<body>
    <div class="container">
        <h1>Avaliar Motoboy</h1>
        <form method="POST">
            <label for="rating">Nota:</label>
            <select name="rating" id="rating" required>
                <option value="">Selecione uma nota</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <label for="comment">Comentário:</label>
            <textarea name="comment" id="comment" rows="4" placeholder="Deixe seu comentário..."></textarea>

            <input type="hidden" name="order_id" value="<?php echo $orderId; ?>">
            <button type="submit">Enviar Avaliação</button>
        </form>
        <a href="history.php">Voltar para o Histórico</a>
    </div>
</body>
</html>