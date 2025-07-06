<?php
session_start();

function login($username, $password) {
    // Conectar ao banco de dados
    include '../config/database.php';
    
    // Prepara a consulta
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    // Verifica se o usuário existe
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verifica a senha
        if (password_verify($password, $user['password'])) {
            // Inicia a sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type']; // 'admin', 'motoboy' ou 'cliente'
            return true;
        }
    }
    return false;
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserType() {
    return $_SESSION['user_type'] ?? null;
}
?>