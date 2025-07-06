<?php
session_start();

function login($userId) {
    $_SESSION['user_id'] = $userId;
}

function logout() {
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>