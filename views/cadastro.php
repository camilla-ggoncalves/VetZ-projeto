<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - VetZ</title>
  <link rel="stylesheet" href="views/css/style.css" />
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

        /* Menu principal */
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

        /* Menu hamburguer do usuário */
        .user-menu-wrapper {
            position: relative;
        }

        .btn-user-toggle {
            background: none;
            border: 2px solid #333;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-user-toggle:hover {
            background: #333;
            color: white;
        }

        .btn-user-toggle i {
            font-size: 20px;
        }

        /* Dropdown do usuário */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown.show {
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .user-greeting {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .user-dropdown-body {
            padding: 10px 0;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
            gap: 10px;
        }

        .user-dropdown-item:hover {
            background: #f8f9fa;
        }

        .user-dropdown-item img {
            width: 20px;
            height: 20px;
        }

        .user-dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .user-dropdown-item.logout {
            color: #dc3545;
            border-top: 1px solid #eee;
        }

        .user-dropdown-item.logout:hover {
            background: #ffe6e6;
        }

        /* Responsivo */
        @media (max-width: 991px) {
            .d-none {
                display: none !important;
            }

            .left-menu {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
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

  <!-- Cabeçalho -->
  <?php include __DIR__ . '/navbar.php'; ?>


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
    </div>
  </main>

  <!-- Rodapé -->
  <footer class="rodape">
    <p>Todos os direitos reservados © 2025 - VetZ</p>
  </footer>

</body>
</html>
