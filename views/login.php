<?php
$title = "Login - VetZ";
ob_start();

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../models/Usuario.php';
  $usuario = new Usuario();
  $user = $usuario->autenticar($_POST['email'], $_POST['senha']);
  if ($user) {
    session_start();
    $_SESSION['usuario'] = $user;
    header('Location: perfil_usuario.php?id=' . $user['id']);
    exit;
  } else {
    $erro = 'E-mail ou senha inválidos.';
  }
}
?>
<div class="login-box">
  <h2 class="login-title">LOGIN</h2>
  <form action="login.php" method="POST">
    <?php if ($erro): ?>
      <div class="erro" style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>
    <input type="email" name="email" required placeholder="Digite seu e-mail">
    <input type="password" name="senha" required placeholder="Digite sua senha">
    <button type="submit">Entrar</button>
  </form>
  <div class="links">
  <a href="cadastro.php">Criar conta</a>
    <br>
  <a href="recuperar.php">Esqueceu a senha?</a>
  </div>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>