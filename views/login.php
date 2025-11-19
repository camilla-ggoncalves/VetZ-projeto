<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - VetZ</title>
  <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="views/css/style.css">
</head>

<body>

  <!-- Cabeçalho -->
  <header class="topo">
    <div class="logo-box">
      <img src="views/images/logo_vetz.svg" alt="Logo">
      <span class="titulo">VetZ</span>
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

    <!-- Load JS =============================-->
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>
    
</body>
</html>
