<?php
$title = "Cadastro - VetZ";
ob_start();
?>
<div class="cadastro-box">
  <h2 class="cadastro-title">Registrar-se</h2>
  <form action="/projeto/vetz/cadastrar" method="POST">
    <input type="text" name="nome" placeholder="Digite seu nome" required>
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="password" name="senha" placeholder="Digite sua senha" required>
    <button type="submit" class="cadastrarForm">Cadastrar</button>
    <div class="links">
  <a href="/projeto/vetz/loginForm">Já tem uma conta? Logar</a>
    </div>
  </form>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>