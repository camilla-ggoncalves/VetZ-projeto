<?php
session_start();
require_once __DIR__ . '/models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->buscarPorEmail($email);
    
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nome'];
        header('Location: /projeto/vetz/homepage');
        exit;
    } else {
        $erro = 'E-mail ou senha inválidos.';
        include __DIR__ . '/views/login.php';
        exit;
    }
}
// Se não for POST, redireciona para o formulário
header('Location: /projeto/vetz/views/login.php');
exit;
