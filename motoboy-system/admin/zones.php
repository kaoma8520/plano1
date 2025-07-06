<?php
session_start();
include_once '../config/database.php';

// Verifica se o usuário está autenticado como admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Conexão com o banco de dados
$db = new Database();
$conn = $db->getConnection();

// Função para obter zonas de atendimento
function getZones($conn) {
    $query = "SELECT * FROM zones ORDER BY city, neighborhood";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para adicionar uma nova zona
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_zone'])) {
    $city = $_POST['city'];
    $neighborhood = $_POST['neighborhood'];

    $query = "INSERT INTO zones (city, neighborhood) VALUES (:city, :neighborhood)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':neighborhood', $neighborhood);
    
    if ($stmt->execute()) {
        $message = "Zona adicionada com sucesso!";
    } else {
        $message = "Erro ao adicionar zona.";
    }
}

// Função para excluir uma zona
if (isset($_GET['delete'])) {
    $zone_id = $_GET['delete'];
    $query = "DELETE FROM zones WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $zone_id);
    $stmt->execute();
    header('Location: zones.php');
    exit();
}

$zones = getZones($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zonas de Atendimento - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Zonas de Atendimento</h1>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
        
        <form method="POST" action="">
            <input type="text" name="city" placeholder="Cidade" required>
            <input type="text" name="neighborhood" placeholder="Bairro" required>
            <button type="submit" name="add_zone">Adicionar Zona</button>
        </form>

        <h2>Lista de Zonas</h2>
        <table>
            <thead>
                <tr>
                    <th>Cidade</th>
                    <th>Bairro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zones as $zone): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($zone['city']); ?></td>
                        <td><?php echo htmlspecialchars($zone['neighborhood']); ?></td>
                        <td>
                            <a href="?delete=<?php echo $zone['id']; ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>