<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro - VetZ</title>
  <link rel="stylesheet" href="views/css/style.css" />
</head>

<body>

  <!-- Cabeçalho -->
  <header class="topo">
    <div class="logo-box">
      <img src="views/images/logo_vetz.svg" alt="Logo da Clínica" />
      <span class="titulo">VetZ</span>
    </div>
    <button class="voltar" onclick="history.back()">VOLTAR</button>
  </header>

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
