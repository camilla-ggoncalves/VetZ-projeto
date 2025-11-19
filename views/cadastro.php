<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - VetZ</title>

    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/projeto/vetz/views/images/logo_vetz.svg">
    <link rel="alternate icon" type="image/png" href="/projeto/vetz/views/images/logoPNG.png">

</head>
         <!-- #region -->
  <!-- CSS NAVBAR -->
  <style>
    .header {
      position: relative;
    }
    .navbar {
      padding: 15px 0;
    }
    .navbar .container {
      display: flex;
      align-items: center;
    }
    .navbar .navbar-expand-lg {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .logomenu {
      max-height: 50px;
    }
    .left-menu {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
      gap: 20px;
    }
    .left-menu li a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color 0.3s;
    }
    .left-menu li a:hover {
      color: #007bff;
    }
    .btn-avancar-login {
      display: block;
      margin: 25px auto 0 auto;
      padding: 9px 29px;
      background: #fff;
      color: #038654;
      border: 2px solid #038654;
      border-radius: 8px;
      font-size: 14px;
      font-family: 'Poppins-SemiBold', Arial, sans-serif;
      cursor: pointer;
      transition: background 0.2s, color 0.2s, box-shadow 0.2s;
      box-shadow: 0 2px 8px rgba(3,134,84,0.08);
    }
    .btn-avancar-login:hover {
      background: #038654;
      color: #fff;
      box-shadow: 0 4px 16px rgba(3,134,84,0.15);
      transform: translateY(-2px);
    }
  </style>

  <!-- JS NAVBAR -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userMenuToggle = document.getElementById('userMenuToggle');
      const userDropdown = document.getElementById('userDropdown');
      if (userMenuToggle && userDropdown) {
        userMenuToggle.addEventListener('click', function(e) {
          e.stopPropagation();
          userDropdown.classList.toggle('show');
        });
        document.addEventListener('click', function(e) {
          if (!userMenuToggle.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.classList.remove('show');
          }
        });
        userDropdown.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    });
  </script>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

  <!-- Conteúdo principal -->
  <main>
    <div class="cadastro-box">
      <h2 class="cadastro-title">Registrar-se</h2>

      <form action="/projeto/vetz/cadastrar" method="POST" id="formCadastro">

        <input type="text" name="nome" placeholder="Digite seu nome" required>
        <input type="email" name="email" placeholder="Digite seu e-mail" required>

        <!-- Campo de senha com tooltip e olhinho -->
        <div class="senha-container">
          <input type="password" id="senha" name="senha"
            placeholder="Digite sua senha"
            required minlength="8"
            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}"
            title="Mínimo 8 caracteres, contendo uma letra maiúscula, uma minúscula, um número e um caractere especial.">

          <!-- Botão olhinho -->
          <button type="button" id="toggleSenha" class="toggle-senha">🐵</button>

          <!-- Tooltip lateral -->
          <div id="tooltip-senha" class="tooltip-senha">
            A senha deve conter:
            <ul>
              <li>Ao menos 8 caracteres</li>
              <li>Uma letra maiúscula</li>
              <li>Uma letra minúscula</li>
              <li>Um número</li>
              <li>Um caractere especial</li>
            </ul>
          </div>
        </div>

        <p id="mensagem-forca" class="mensagem-forca">Digite uma senha</p>
        <span id="erro-senha" class="erro-senha"></span>

        <button type="submit" class="cadastrar">Cadastrar</button>
      </form>
      <button type="button" class="btn-avancar-login" onclick="window.location.href='/projeto/vetz/views/login.php'">Já tenho conta</button>
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

</body>
</html>
