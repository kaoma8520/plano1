<?php
session_start();
require_once 'config/database.php';
require_once 'core/auth.php';

// Redireciona para a área apropriada com base na sessão do usuário
if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == 'admin') {
        header('Location: admin/dashboard.php');
        exit();
    } elseif ($_SESSION['user_type'] == 'motoboy') {
        header('Location: motoboy/dashboard.php');
        exit();
    } elseif ($_SESSION['user_type'] == 'client') {
        header('Location: client/dashboard.php');
        exit();
    }
}

// Se não estiver logado, redireciona para a página de login
header('Location: client/login.php');
exit();
?>