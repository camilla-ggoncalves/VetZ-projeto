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

  <!-- Script -->
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
