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
    .btn-home {
        background: linear-gradient(90deg, #04c97b 0%, #b6f7e1 100%);
        color: #026d47;
        border: none;
        border-radius: 8px;
        padding: 12px 32px;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
        margin-top: 8px;
        box-shadow: 0 2px 8px rgba(44,122,122,0.10);
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-home:hover {
        background: linear-gradient(90deg, #04c97b 0%, #7be3b7 100%);
        color: #014c2c;
    }
    .btn-logout {
        background: linear-gradient(90deg, #ffeaea 0%, #fff 100%);
        color: #d9534f;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 1rem;
        margin-top: 8px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(44,122,122,0.08);
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-logout:hover {
        background: linear-gradient(90deg, #ffd6d6 0%, #fff 100%);
        color: #a94442;
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

    <a href="homepage.php" class="btn-home d-block mb-2">
        <i class="fas fa-home"></i> Ir para Home
    </a>
    <form method="post" class="d-inline">
        <button type="submit" name="logout" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Sair
        </button>
    </form>
</div>

<?php
// Processa logout ANTES de renderizar o layout
if (isset($_POST['logout'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header('Location: login.php');
    exit;
}

$content = ob_get_clean();
include 'layout.php';
?>