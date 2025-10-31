<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro - VetZ</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>    

  <?php include 'navbar.php'; ?>

  <!-- Conteúdo principal -->           
  <main>
    <div class="cadastro-box">
      <h2 class="cadastro-title">Registrar-se</h2>
      <form action="/projeto/vetz/cadastrar" method="POST">
    <input type="text" name="nome" placeholder="Digite seu nome" required>
    <input type="email" name="email" placeholder="Digite seu e-mail" required>
    <input type="password" name="senha" placeholder="Digite sua senha" required>
    <button type="submit"class="cadastrar">Cadastrar</button>   

    
      
</form>

    </div>
  </main>

  <!-- Rodapé -->
  <footer class="rodape">
    <p>Todos os direitos reservados © 2025 - VetZ</p>
    
    </div>
  </footer>

</body>
</html>
