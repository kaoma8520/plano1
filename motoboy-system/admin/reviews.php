<?php
session_start();
include_once '../config/database.php';
include_once '../core/auth.php';

checkAdminSession();

$conn = new PDO($dsn, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'delete') {
        $reviewId = $_POST['review_id'];
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $reviewId);
        $stmt->execute();
    }
}

$stmt = $conn->prepare("SELECT r.id, r.rating, r.comment, m.name AS motoboy_name FROM reviews r JOIN motoboys m ON r.motoboy_id = m.id ORDER BY r.created_at DESC");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Gerenciamento de Avaliações</title>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Avaliações</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Motoboy</th>
                    <th>Avaliação</th>
                    <th>Comentário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($review['id']); ?></td>
                        <td><?php echo htmlspecialchars($review['motoboy_name']); ?></td>
                        <td><?php echo htmlspecialchars($review['rating']); ?></td>
                        <td><?php echo htmlspecialchars($review['comment']); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review['id']); ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" onclick="return confirm('Tem certeza que deseja deletar esta avaliação?');">Deletar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>