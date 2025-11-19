<?php 
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastrar Pet - VetZ</title>

    <!-- CSS -->
  <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
  <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
  <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/projeto/vetz/views/images/logo_vetz.svg">
  <link rel="alternate icon" type="image/png" href="/projeto/vetz/views/images/logoPNG.png">

</head>
<body>    
<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <!-- Se estiver editando, o campo hidden vai ter o id, mas não vai aparecer -->
     <form action="/projeto/vetz/save-pet" method="POST" enctype="multipart/form-data">
        <div class="cadastro-box">
            <h2 class="cadastro-title">Cadastrar Pet</h2>
            <input type="hidden" name="id" value="<?= $pet['id'] ?? '' ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="raca">Raça:</label>
            <input type="text" id="raca" name="raca" required><br><br>

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade"><br><br>

            <label for="porte">Porte:</label>
            <select type="text" id="porte" name="porte" required>
                <option value="">Selecione</option>
                <option value="pequeno">Pequeno</option>
                <option value="medio">Médio</option>
                <option value="grande">Grande</option>
            </select>

            <label for="peso">Peso:</label>
            <input type="number" id="peso" name="peso" required><br><br>

            <label for="sexo">Sexo:</label>
            <select type="text" id="sexo" name="sexo">
                <option value="">Selecione</option>
                <option value="Macho">Macho</option>
                <option value="Fêmea">Fêmea</option>
            </select>
            
            <label>Imagem do Pet:</label>
            <input type="file" name="imagem" accept="image/*">

            <input type="submit" value="Cadastrar Pet">
    </form>

  <!-- Load JS =============================-->
  <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
  <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
  <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
  <script src="/projeto/vetz/views/js/scripts.js"></script>

</body>
</html>
