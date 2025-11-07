<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VetZ</title>
  <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="views/css/style.css">
</head>

<body>

  <!-- Cabeçalho -->
  <header class="topo">
    <div class="logo-box">
      <img src="views/images/logo_vetz.svg" alt="Logo">
      <span class="titulo">Vetz</span>
    </div>
    <button class="voltar" onclick="history.back()">VOLTAR</button>
  </header>

  <!-- Conteúdo Principal -->
  <main>
    <div class="login-box">
      <h2 class="login-title">LOGIN</h2>

      <form action="../vetz/login" method="POST">
        <?php if (isset($erro)): ?>
          <div class="erro" style="color: red; margin-bottom: 10px;">
            <?= htmlspecialchars($erro) ?>
          </div>
        <?php endif; ?>

        <label for="email" class="emailLabel">E-mail:</label>
        <input type="email" name="email" required placeholder="exemplo@email.com">

        <label for="senha" class="senhaLabel">Senha:</label>

        <!-- Campo de senha com botão olhinho -->
        <div class="senha-container">
          <input type="password" id="senha" name="senha" required placeholder="********">
          <button type="button" id="toggleSenha" class="toggle-senha">🐵</button>
        </div>

        <button type="submit" class="entrar">Entrar</button>

        <div class="links">
          <a href="/projeto/vetz/cadastrarForm">Criar conta</a>
          <p></p>
          <a href="/projeto/vetz/recuperarForm">Esqueceu a senha?</a>
        </div>
      </form>

      <!-- Gif fofo abaixo do link -->
      <img src="https://media.giphy.com/media/3o6Zt6ML6BklcajjsA/giphy.gif" alt="Cachorro e gato animados"
        class="bichinho">
    </div>
  </main>

  <!-- Rodapé -->
  <footer class="rodape">
    <p>© 2025 VetZ - Todos os direitos reservados.</p>
  </footer>

  <!-- Script do olhinho -->
  <script>
    const senhaInput = document.getElementById('senha');
    const toggleSenha = document.getElementById('toggleSenha');

    toggleSenha.addEventListener('click', () => {
      const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
      senhaInput.setAttribute('type', tipo);
      toggleSenha.innerHTML = tipo === 'password' ? '🐵' : '🙈';
    });
  </script>

</body>

</html>

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

