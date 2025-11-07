<?php
session_start();

// Proteção: usuário não logado → volta para login
if (!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$title   = 'Perfil do Usuário - VetZ';

ob_start();
?>

<style>
    .perfil-box {
        max-width: 420px;
        margin: 80px auto 40px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(44,122,122,0.12);
        padding: 32px 28px;
        text-align: center;
    }
    .perfil-title {
        color: #038654;
        font-size: 2rem;
        margin-bottom: 24px;
        font-weight: 600;
    }
    .perfil-info {
        font-size: 1.1rem;
        color: #222;
        margin-bottom: 12px;
    }
    .btn-logout {
        background: #2d7a7a;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 10px 24px;
        font-size: 1rem;
        margin-top: 18px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-weight: 500;
    }
    .btn-logout:hover {
        background: #1e5454;
    }
</style>

<div class="perfil-box">
    <h2 class="perfil-title">Perfil do Usuário</h2>

    <div class="perfil-info">
        <strong>Nome:</strong>
        <?= htmlspecialchars($usuario['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </div>

    <div class="perfil-info">
        <strong>Email:</strong>
        <?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </div>

    <form method="post" class="d-inline">
        <button type="submit" name="logout" class="btn-logout">
            Sair
        </button>
    </form>
</div>

<?php
// Processa logout ANTES de renderizar o layout
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$content = ob_get_clean();
include 'layout.php';
?>