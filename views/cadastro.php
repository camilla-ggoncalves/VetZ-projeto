<?php
require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - VetZ</title>

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

    .cadastro-box {
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

    .cadastro-header {
      text-align: center;
      margin-bottom: 35px;
    }

    .cadastro-icon {
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

    .cadastro-icon i {
      font-size: 40px;
      color: #fff;
    }

    .cadastro-title {
      color: #038654;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .cadastro-subtitle {
      color: #666;
      font-size: 14px;
    }

    .form-group {
      margin-bottom: 20px;
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

    form input {
      width: 100%;
      padding: 14px 18px;
      border: 2px solid #e0e0e0;
      border-radius: 12px;
      font-size: 15px;
      transition: all 0.3s;
      box-sizing: border-box;
      margin-bottom: 20px;
    }

    form input:focus {
      outline: none;
      border-color: #038654;
      box-shadow: 0 0 0 4px rgba(3, 134, 84, 0.1);
    }

    .senha-container {
      position: relative;
      margin-bottom: 10px;
    }

    .senha-container input {
      margin-bottom: 0;
      padding-right: 50px;
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

    .tooltip-senha {
      position: absolute;
      top: 50%;
      right: -240px;
      transform: translateY(-50%);
      width: 220px;
      background-color: #ffffff;
      color: #333;
      border: 1px solid #cde7b0;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 10px;
      font-size: 13px;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 10;
    }

    .tooltip-senha.mostrar {
      opacity: 1;
      pointer-events: auto;
    }

    .tooltip-senha ul {
      margin: 5px 0 0 15px;
      padding: 0;
    }

    .tooltip-senha li {
      list-style-type: disc;
    }

    .mensagem-forca {
      font-size: 13px;
      font-weight: 600;
      margin: 5px 0 15px 5px;
      text-align: left;
    }

    .fraca { color: #ff4d4d; }
    .media { color: #e6b800; }
    .forte { color: #2e8b57; }

    .erro-senha {
      display: block;
      font-size: 13px;
      margin: 5px 0 15px 5px;
      color: #ff4d4d;
    }

    .cadastrar {
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

    .cadastrar:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(3, 134, 84, 0.4);
      color: #000;
    }

    .btn-avancar-login {
      display: block;
      margin: 15px auto 0;
      padding: 12px 30px;
      background: #fff;
      color: #038654;
      border: 2px solid #038654;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .btn-avancar-login:hover {
      background: #038654;
      color: #000;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(3, 134, 84, 0.3);
    }

    @media (max-width: 768px) {
      .cadastro-box {
        padding: 35px 25px;
      }

      .cadastro-title {
        font-size: 24px;
      }

      .tooltip-senha {
        display: none;
      }
    }
  </style>

</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

  <!-- Conteúdo principal -->
  <main>
    <div class="cadastro-box">
      <div class="cadastro-header">
        <div class="cadastro-icon">
          <i class="fas fa-user-plus"></i>
        </div>
        <h2 class="cadastro-title">Criar Conta</h2>
        <p class="cadastro-subtitle">Preencha os dados para se cadastrar</p>
      </div>

      <form action="<?php echo url('/cadastrar'); ?>" method="POST" id="formCadastro">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="E-mail" required>

        <!-- Campo de senha com tooltip e olhinho -->
        <div class="senha-container">
          <input type="password" id="senha" name="senha"
            placeholder="Senha"
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

        <button type="submit" class="cadastrar">
          <i class="fas fa-user-check"></i> Cadastrar
        </button>
      </form>

      <div style="text-align: center;">
        <a href="<?php echo url('/loginForm'); ?>" class="btn-avancar-login">
          <i class="fas fa-sign-in-alt"></i> Já tenho conta
        </a>
      </div>
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
  
  <script>
    const senhaInput = document.getElementById('senha');
    const mensagemForca = document.getElementById('mensagem-forca');
    const erroSenha = document.getElementById('erro-senha');
    const tooltip = document.getElementById('tooltip-senha');
    const toggleSenha = document.getElementById('toggleSenha');
    const form = document.getElementById('formCadastro');

    // Mostrar/ocultar senha
    toggleSenha.addEventListener('click', () => {
      const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
      senhaInput.setAttribute('type', tipo);
      toggleSenha.innerHTML = tipo === 'password' ? '🐵' : '🙈';
    });

    // Mostra tooltip
    senhaInput.addEventListener('focus', () => {
      tooltip.style.opacity = '1';
      tooltip.style.pointerEvents = 'auto';
    });

    // Esconde tooltip
    senhaInput.addEventListener('blur', () => {
      tooltip.style.opacity = '0';
      tooltip.style.pointerEvents = 'none';
    });

    // Teste de força da senha
    senhaInput.addEventListener('input', function () {
      const senha = senhaInput.value;
      let forca = 0;

      if (senha.length >= 8) forca++;
      if (/[A-Z]/.test(senha)) forca++;
      if (/[a-z]/.test(senha)) forca++;
      if (/\d/.test(senha)) forca++;
      if (/[^A-Za-z0-9]/.test(senha)) forca++;

      if (senha.length === 0) {
        mensagemForca.textContent = "Digite uma senha";
        mensagemForca.style.color = "#555";
      } else if (forca <= 2) {
        mensagemForca.textContent = "Senha fraca";
        mensagemForca.style.color = "red";
      } else if (forca === 3 || forca === 4) {
        mensagemForca.textContent = "Senha média";
        mensagemForca.style.color = "orange";
      } else if (forca === 5) {
        mensagemForca.textContent = "Senha forte";
        mensagemForca.style.color = "green";
      }
    });

    // Validação personalizada no envio
    form.addEventListener('submit', function (e) {
      const senha = senhaInput.value;
      const padrao = /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}/;

      if (!padrao.test(senha)) {
        e.preventDefault();
        erroSenha.textContent = 'Senha inválida.';
        erroSenha.style.color = "#d62828";
      } else {
        erroSenha.textContent = '';
      }
    });
  </script>

</body>
</html>
