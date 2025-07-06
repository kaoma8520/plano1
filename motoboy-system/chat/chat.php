<?php
session_start();
include_once '../config/database.php';
include_once '../core/session.php';
include_once '../core/auth.php';

if (!isset($_SESSION['client_id']) && !isset($_SESSION['motoboy_id'])) {
    header("Location: ../index.php");
    exit();
}

$messages = [];
$client_id = $_SESSION['client_id'] ?? null;
$motoboy_id = $_SESSION['motoboy_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = htmlspecialchars(trim($_POST['message']));
    $sender_id = $client_id ? $client_id : $motoboy_id;

    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO chat_messages (sender_id, message, timestamp) VALUES (?, ?, NOW())");
        $stmt->execute([$sender_id, $message]);
    }
}

$stmt = $pdo->query("SELECT * FROM chat_messages ORDER BY timestamp ASC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Chat Interno</title>
</head>
<body>
    <div class="chat-container">
        <h2>Chat Interno</h2>
        <div class="messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <strong><?php echo $msg['sender_id']; ?>:</strong> <?php echo $msg['message']; ?>
                    <span class="timestamp"><?php echo $msg['timestamp']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="POST" action="">
            <input type="text" name="message" placeholder="Digite sua mensagem..." required>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>