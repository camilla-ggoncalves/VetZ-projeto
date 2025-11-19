<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - VetZ</title>

  <!-- CSS -->
  <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
  <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
  <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/projeto/vetz/views/images/logo_vetz.svg">
  <link rel="alternate icon" type="image/png" href="/projeto/vetz/views/images/logoPNG.png">

</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

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

    <!-- Begin footer-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="footerp1">
                        Todos os direitos reservados <span id="footer-year"></span> © - VetZ </p>
                </div>
            </div>
        </div>
    </div>
    <!--End footer-->

    <!-- Load JS =============================-->
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>

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
