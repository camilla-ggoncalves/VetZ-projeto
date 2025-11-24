<?php
require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - VetZ</title>

  <!-- CSS -->
  <link href="<?php echo url('/views/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo url('/views/css/style.css'); ?>" rel="stylesheet">
  <link href="<?php echo url('/views/css/all.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo url('/views/css/navbar.css'); ?>" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?php echo url('/views/images/logo_vetz.svg'); ?>">
  <link rel="alternate icon" type="image/png" href="<?php echo url('/views/images/logoPNG.png'); ?>">

  <style>
    body {
      background: linear-gradient(135deg, #B5E7A0 0%, #86C67C 100%);
      font-family: 'Poppins', Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .header {
      flex-shrink: 0;
    }

    .footer {
      flex-shrink: 0;
      margin-top: auto;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .login-box {
      background: #fff;
      border-radius: 25px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      padding: 50px 40px;
      max-width: 480px;
      width: 100%;
      position: relative;
      animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .login-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #B5E7A0, #86C67C);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      box-shadow: 0 4px 15px rgba(3, 134, 84, 0.3);
    }

    .login-icon i {
      font-size: 40px;
      color: #fff;
    }

    .login-title {
      color: #038654;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .login-subtitle {
      color: #666;
      font-size: 14px;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-group label {
      display: block;
      color: #038654;
      font-weight: 600;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-group label i {
      margin-right: 5px;
    }

    .form-control {
      width: 100%;
      padding: 14px 18px;
      border: 2px solid #e0e0e0;
      border-radius: 12px;
      font-size: 15px;
      transition: all 0.3s;
      box-sizing: border-box;
    }

    .form-control:focus {
      outline: none;
      border-color: #038654;
      box-shadow: 0 0 0 4px rgba(3, 134, 84, 0.1);
    }

    .senha-container {
      position: relative;
    }

    .toggle-senha {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 20px;
      color: #666;
      padding: 0;
      transition: all 0.2s;
    }

    .toggle-senha:hover {
      color: #038654;
    }

    .btn-entrar {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #038654, #55974A);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(3, 134, 84, 0.3);
    }

    .btn-entrar:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(3, 134, 84, 0.4);
      color: #000;
    }

    .links {
      text-align: center;
      margin-top: 25px;
    }

    .links a {
      color: #038654;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.3s;
    }

    .links a:hover {
      color: #55974A;
    }

    .links p {
      margin: 10px 0;
    }

    .message {
      padding: 12px 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 14px;
      text-align: center;
    }

    .message-error {
      background: #f8d7da;
      color: #721c24;
      border-left: 4px solid #dc3545;
    }

    @media (max-width: 768px) {
      .login-box {
        padding: 35px 25px;
      }

      .login-title {
        font-size: 24px;
      }
    }
  </style>

</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

  <!-- Conteúdo Principal -->
  <main>
    <div class="login-box">
      <div class="login-header">
        <div class="login-icon">
          <i class="fas fa-sign-in-alt"></i>
        </div>
        <h2 class="login-title">Entrar na Conta</h2>
        <p class="login-subtitle">Bem-vindo de volta! Faça login para continuar</p>
      </div>

      <form action="<?php echo url('/login'); ?>" method="POST">
        <?php if (isset($erro)): ?>
          <div class="message message-error">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($erro) ?>
          </div>
        <?php endif; ?>

        <div class="form-group">
          <label for="email">
            <i class="fas fa-envelope"></i> E-mail
          </label>
          <input type="email"
                 id="email"
                 name="email"
                 class="form-control"
                 placeholder="seu@email.com"
                 required>
        </div>

        <div class="form-group">
          <label for="senha">
            <i class="fas fa-lock"></i> Senha
          </label>
          <div class="senha-container">
            <input type="password"
                   id="senha"
                   name="senha"
                   class="form-control"
                   placeholder="Digite sua senha"
                   required>
            <button type="button" id="toggleSenha" class="toggle-senha">🐵</button>
          </div>
        </div>

        <button type="submit" class="btn-entrar">
          <i class="fas fa-sign-in-alt"></i> Entrar
        </button>

        <div class="links">
          <a href="<?php echo url('/cadastrarForm'); ?>">
            <i class="fas fa-user-plus"></i> Criar conta
          </a>
          <p></p>
          <a href="<?php echo url('/recuperarForm'); ?>">
            <i class="fas fa-key"></i> Esqueceu a senha?
          </a>
        </div>
      </form>
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
    <script src="<?php echo url('/views/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.scrollTo-min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.nav.js'); ?>"></script>
    <script src="<?php echo url('/views/js/scripts.js'); ?>"></script>

    <script>
      document.getElementById('footer-year').textContent = new Date().getFullYear();

      const senhaInput = document.getElementById('senha');
      const emailInput = document.getElementById('email');
      const toggleSenha = document.getElementById('toggleSenha');

      toggleSenha.addEventListener('click', () => {
          const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
          senhaInput.setAttribute('type', tipo);
          toggleSenha.innerHTML = tipo === 'password' ? '🐵' : '🙈';
      });

      // Se houver mensagem de erro, destacar os campos
      <?php if (isset($erro)): ?>
        <?php if (strpos($erro, 'e-mail') !== false || strpos($erro, 'Usuario nao encontrado') !== false): ?>
          emailInput.classList.add('error');
          emailInput.focus();
        <?php elseif (strpos($erro, 'Senha') !== false): ?>
          senhaInput.classList.add('error');
          senhaInput.focus();
        <?php endif; ?>

        // Remover classe de erro ao digitar
        emailInput.addEventListener('input', () => emailInput.classList.remove('error'));
        senhaInput.addEventListener('input', () => senhaInput.classList.remove('error'));
      <?php endif; ?>
    </script>

</body>
</html>
