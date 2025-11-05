<?php
$title = "Login - VetZ";
ob_start();
?>
<div class="login-box">
  <h2 class="login-title">LOGIN</h2>
  <form action="/projeto/vetz/login" method="POST">
    <?php if (isset($erro)): ?>
      <div class="erro" style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>
    <input type="email" name="email" required>
    <input type="password" name="senha" required>
    <button type="submit">Entrar</button>
  </form>
  <div class="links">
  <a href="/projeto/vetz/cadastrarForm">Criar conta</a>
    <br>
  <a href="/projeto/vetz/recuperarForm">Esqueceu a senha?</a>
  </div>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>