<?php
session_start();
require_once '../../config/database.php';
require_once '../../core/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $whatsapp = $_POST['whatsapp'];
    $password = $_POST['password'];

    if (authenticateClient($whatsapp, $password)) {
        $_SESSION['client'] = $whatsapp;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Credenciais inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Login - Cliente</title>
</head>
<body>
    <div class="login-container">
        <h2>Login do Cliente</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="whatsapp">WhatsApp:</label>
            <input type="text" name="whatsapp" required>
            <label for="password">Senha:</label>
            <input type="password" name="password" required>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="register.php">Cadastre-se</a></p>
    </div>
</body>
</html>