<?php 
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Senha - VetZ</title>
    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/projeto/vetz/views/images/logo_vetz.svg">
    <link rel="alternate icon" type="image/png" href="/projeto/vetz/views/images/logoPNG.png">
    
   <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
    }
    .topo {
  background-color: #ffffff;
  border-bottom: 2px solid #d8e8cc;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
}

.logo-box {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo-box img {
  width: 40px;
  height: 40px;
}

.titulo {
  font-size: 20px;
  font-weight: bold;
  color: #4b7942;
}

    body {
      background-color: #fdfcea;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 100vh;
    }
      
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      border-bottom: 2px solid #b1b1b1;
    }

    .logo {
      height: 60px;
    }
.voltar {
  background-color: #d4f1c5;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-weight: bold;
  color: #2d5c24;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.voltar:hover {
  background-color: #bde9ad;
}

   
  

    main {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .box {
      background: linear-gradient(#ffffff, #fcfcfc);
      border-radius: 20px;
      box-shadow: 5px 5px 10px rgba(0,0,0,0.2);
      padding: 30px;
      width: 400px;
      text-align: center;
    }

    .box h2 {
      font-size: 24px;
      color: #464b78;
      margin-bottom: 20px;
    }
  <link rel="stylesheet" href="views\css\style.css">

    .box p {
      background-color: #fff;
      padding: 15px;
      border-radius: 15px;
      font-size: 15px;
      color: #333;
      margin-bottom: 30px;
    }

    .campo-codigo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 16px;
    }

    .campo-codigo label {
      font-weight: bold;
      color: #464b78;
    }

    .campo-codigo input {
      padding: 10px;
      border-radius: 15px;
      border: none;
      width: 120px;
      text-align: center;
      font-size: 16px;
      background-color: #ffffff;
      box-shadow: 0 0 4px rgba(0,0,0,0.1);
    }

    footer {
  text-align: center;
  padding: 15px;
  background-color: #eaf7dc;
  color: #4a6542;
  font-size: 14px;
  border-top: 1px solid #cfe8b6;
}


    .icons {
      position: absolute;
      right: 20px;
      top: 10px;
    }

    .icons img {
      width: 24px;
      margin-left: 10px;
    }
    .envcod {
      background-color: #7ADEA7;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    .bt-trsenha{
      background-color: #7ADEA7;
      color: #fff;
      border: none;
      padding: 5px 10px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    @media (max-width: 480px) {
      .box {
        width: 90%;
      }
    }
  </style>

</head>
<body>


 <header class="topo">
    <div class="logo-box">
      <img src="views/images/logo_vetz.svg" alt="Logo da Clínica" />
      <span class="titulo">VetZ</span>
    </div>
    <button class="voltar" onclick="history.back()">VOLTAR</button>
  </header>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->


  <main>
    <div class="box">
      <h2>Recuperando a senha</h2>
      <p>Será enviado um código para recuperação de senha no email. (exemplo: marc*********@gmail.com)</p>

      <form id="form-email" action="/projeto/vetz/enviarCodigo" method="POST">
        <input name="email" id="email" type="email" placeholder="Digite seu e-mail" required>
        <button class= "envcod" >Enviar código</button>
      </form>

      <div id="popup-codigo" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
        <div style="background:#fff; padding:30px; border-radius:15px; width:300px; margin:auto; text-align:center; position:relative;">
          <h3>Digite o código recebido</h3>
          <form id="form-codigo" action="/projeto/vetz/verificarCodigo" method="POST">
            <input name="email" id="popup-email" type="hidden">
            <input name="codigo" type="text" placeholder="Código" required style="margin-bottom:10px; width:90%;"><br>
            <input name="nova_senha" type="password" placeholder="Nova senha" required style="margin-bottom:10px; width:90%;"><br>
            <button class="bt-trsenha" type="submit">Trocar senha</button>
          </form>
          <button onclick="fecharPopup()" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
          <div id="msg-codigo" style="margin-top:10px; color:#038654;"></div>
        </div>
      </div>

      <div id="popup-codigo" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:1000; align-items:center; justify-content:center;">
  <div style="background:#fff; padding:30px; border-radius:15px; width:300px; margin:auto; text-align:center; position:relative;">
    <h3>Digite o código recebido</h3>
    <form action="/projeto/vetz/verificarCodigo" method="POST">
      <input name="email" id="popup-recupera" type="hidden">
      <input name="codigo" type="text" placeholder="Código" required style="margin-bottom:10px; width:90%;"><br>
      <input name="nova_senha" type="password" placeholder="Nova senha" required style="margin-bottom:10px; width:90%;"><br>
      <button class="bt-trsenha"type="submit">Trocar senha</button>
    </form>
    <button onclick="fecharPopup()" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:18px; cursor:pointer;">&times;</button>
  </div>
</div>

      <!-- Novo popup de sucesso -->
      <div id="popup-sucesso" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.4); z-index:2000; align-items:center; justify-content:center;">
        <div style="background:#fff; padding:30px; border-radius:15px; width:300px; margin:auto; text-align:center; position:relative;">
          <h3 style="color:#038654;">Senha alterada com sucesso!</h3>
          <button  onclick="fecharPopupSucesso()" style="margin-top:20px; background:#038654; color:#fff; border:none; border-radius:8px; padding:10px 20px; cursor:pointer;" >OK</button>
        </div>
      </div>

      <div id="msg-email" style="margin-top:15px; color:#038654;"></div>
      <div id="codigo-teste" style="margin-top:10px; color:#b00; font-weight:bold;"></div>
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

  <script>
function fecharPopup() {
  document.getElementById('popup-codigo').style.display = 'none';
}
function fecharPopupSucesso() {
  document.getElementById('popup-sucesso').style.display = 'none';
  window.location.href="/projeto/vetz/loginForm"
  
}

// Envio do e-mail para receber o código
document.getElementById('form-email').onsubmit = function(e) {
  e.preventDefault();
  var email = document.getElementById('email').value;
  var btn = this.querySelector('button');
  btn.disabled = true;
  btn.innerText = 'Enviando...';
  fetch('/projeto/vetz/enviarCodigo', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'email=' + encodeURIComponent(email)
  })
  .then(r => r.text())
  .then(codigo => {
    document.getElementById('msg-email').innerText = 'Código enviado para o e-mail!';
    document.getElementById('popup-email').value = email;
    document.getElementById('popup-codigo').style.display = 'flex';
    btn.disabled = false;
    btn.innerText = 'Enviar código';
    // Exibe o código na tela para teste
    document.getElementById('codigo-teste').innerText = 'Código de recuperação: ' + codigo;
  })
  .catch(() => {
    document.getElementById('msg-email').innerText = 'Erro ao enviar código.';
    btn.disabled = false;
    btn.innerText = 'Enviar código';
    document.getElementById('codigo-teste').innerText = '';
  });
};

// Envio do código + nova senha
document.getElementById('form-codigo').onsubmit = function(e) {
  e.preventDefault();
  var form = this;
  var dados = new FormData(form);
  var btn = form.querySelector('button');
  btn.disabled = true;
  btn.innerText = 'Verificando...';
  fetch('/projeto/vetz/verificarCodigo', {
    method: 'POST',
    body: new URLSearchParams([...dados])
  })
  .then(r => r.text())
  .then(msg => {
    document.getElementById('msg-codigo').innerText = msg;
    if (msg.includes('sucesso')) {
      fecharPopup();
      // Mostra o popup de sucesso
      document.getElementById('popup-sucesso').style.display = 'flex';
      // Opcional: fechar automaticamente após 2 segundos
      // setTimeout(() => { fecharPopupSucesso(); }, 2000);
    }
    btn.disabled = false;
    btn.innerText = 'Trocar senha';
  })
  .catch(() => {
    document.getElementById('msg-codigo').innerText = 'Erro ao redefinir senha.';
    btn.disabled = false;
    btn.innerText = 'Trocar senha';
  });
};
</script>

</body>
</html>
