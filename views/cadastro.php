<?php
$title = "Cadastro - VetZ";
ob_start();

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../models/Usuario.php';
  $usuario = new Usuario();
  $ok = $usuario->cadastrar($_POST['nome'], $_POST['email'], $_POST['senha']);
  if ($ok) {
    $mensagem = '<div style="color:green;margin-bottom:16px;">Cadastro realizado com sucesso! <a href="login.php">Clique aqui para logar</a></div>';
  } else {
    $mensagem = '<div style="color:red;margin-bottom:16px;">Erro ao cadastrar. Tente novamente.</div>';
  }
}
?>
<style>
  .cadastro-box {
    max-width: 400px;
    margin: 70px auto 40px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(44,122,122,0.12);
    padding: 20px 16px;
    text-align: center;
  }
  .cadastro-title {
    color: #2d7a7a;
    font-size: 2rem;
    margin-bottom: 24px;
  }
  .cadastro-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #b2d8d8;
    border-radius: 6px;
    font-size: 1rem;
    background: #f8f8f8;
    transition: border 0.2s;
  }
  .cadastro-box input:focus {
    border-color: #2d7a7a;
    outline: none;
  }
  .cadastrarForm {
    width: 100%;
    padding: 12px;
    background: #2d7a7a;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1.1rem;
    margin-top: 16px;
    cursor: pointer;
    transition: background 0.2s;
  }
  .cadastrarForm:hover {
    background: #1e5454;
  }
  .links {
    margin-top: 18px;
    font-size: 0.95rem;
  }
  .links a {
    color: #2d7a7a;
    text-decoration: underline;
    margin: 0 4px;
  }
  @media (max-width: 600px) {
    .cadastro-box {
      padding: 16px 8px;
      @media (max-width: 600px) {
        .cadastro-box {
          max-width: 98vw;
          margin: 50px auto 16px auto;
          padding: 8px 2vw;
          font-size: 0.95rem;
        }
</style>
<style>
  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  main {
    flex: 1;
  }
  .rodape {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background: #eaf7dc;
    color: #4a6542;
    font-size: 14px;
    border-top: 1px solid #cfe8b6;
    text-align: center;
    padding: 15px 0;
    z-index: 100;
  }
        .cadastro-title {
          font-size: 1.3rem;
        }
        .cadastrarForm {
          font-size: 1rem;
          padding: 10px;
        }
        .cadastro-box input {
          padding: 10px;
          font-size: 0.95rem;
        }
        .links {
          font-size: 0.9rem;
        }
      }
      font-size: 0.95rem;
    }
    .cadastro-title {
      font-size: 1.3rem;
    }
    .cadastrarForm {
      font-size: 1rem;
    }
  }
</style>
<div class="cadastro-box">
  <h2 class="cadastro-title">Registrar-se</h2>
  <?= $mensagem ?>
  <form action="cadastro.php" method="POST">
    <input type="text" name="nome" placeholder="Digite seu nome" required>
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="password" name="senha" placeholder="Digite sua senha" required>
    <button type="submit" class="cadastrarForm">Cadastrar</button>
    <div class="links">
      <a href="login.php">Já tem uma conta? Logar</a>
    </div>
  </form>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>