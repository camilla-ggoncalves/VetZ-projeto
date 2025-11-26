<?php
require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Atualizar Pet - VetZ</title>

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
      background: #f8fdf8;
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
      padding: 0;
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

    .form-container {
      max-width: 600px;
      margin: 30px auto;
      padding: 0 20px;
      flex: 1;
    }

    .form-card {
      background: #fff;
      border-radius: 15px;
      padding: 35px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .form-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .form-header h2 {
      color: #038654;
      font-size: 26px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .form-header p {
      color: #666;
      font-size: 13px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      color: #333;
      font-weight: 600;
      font-size: 13px;
      margin-bottom: 8px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group select {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
      font-family: 'Poppins', Arial, sans-serif;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="number"]:focus,
    .form-group select:focus {
      outline: none;
      border-color: #038654;
      box-shadow: 0 0 0 3px rgba(3, 134, 84, 0.1);
    }

    .form-group input[type="file"] {
      padding: 10px;
      border-style: dashed;
    }

    .current-image {
      margin-top: 10px;
      text-align: center;
    }

    .current-image img {
      max-width: 200px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .current-image p {
      margin-top: 8px;
      font-size: 12px;
      color: #666;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .btn-submit {
      width: 100%;
      background: #038654;
      color: #fff;
      padding: 14px;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-submit:hover {
      background: #55974A;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(3, 134, 84, 0.3);
      color: #000;
    }

    .btn-cancel {
      width: 100%;
      background: #fff;
      color: #666;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-cancel:hover {
      border-color: #038654;
      color: #038654;
    }

    @media (max-width: 768px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .form-card {
        padding: 25px;
      }
    }
  </style>

</head>
<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <div class="form-container">
      <div class="form-card">
        <div class="form-header">
          <h2><i class="fas fa-edit"></i> Atualizar Pet</h2>
          <p>Edite os dados do seu pet</p>
        </div>

        <form action="<?php echo url('/update-pet'); ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= htmlspecialchars($pet['id']) ?>">

          <div class="form-group">
            <label for="nome"><i class="fas fa-tag"></i> Nome do Pet</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($pet['nome']) ?>" placeholder="Ex: Rex, Mia, Bob..." required>
          </div>

          <div class="form-group">
            <label for="raca"><i class="fas fa-dog"></i> Raça</label>
            <input type="text" id="raca" name="raca" value="<?= htmlspecialchars($pet['raca']) ?>" placeholder="Ex: Labrador, Persa, SRD..." required>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="idade"><i class="fas fa-calendar-alt"></i> Idade</label>
              <input type="number" id="idade" name="idade" value="<?= htmlspecialchars($pet['idade']) ?>" placeholder="Anos" min="0">
            </div>

            <div class="form-group">
              <label for="peso"><i class="fas fa-weight"></i> Peso (kg)</label>
              <input type="number" id="peso" name="peso" value="<?= htmlspecialchars($pet['peso']) ?>" placeholder="Ex: 5.5" step="0.1" min="0" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="porte"><i class="fas fa-arrows-alt-v"></i> Porte</label>
              <select id="porte" name="porte" required>
                <option value="">Selecione</option>
                <option value="Pequeno" <?= $pet['porte'] === 'Pequeno' || $pet['porte'] === 'pequeno' ? 'selected' : '' ?>>Pequeno</option>
                <option value="Médio" <?= $pet['porte'] === 'Médio' || $pet['porte'] === 'medio' ? 'selected' : '' ?>>Médio</option>
                <option value="Grande" <?= $pet['porte'] === 'Grande' || $pet['porte'] === 'grande' ? 'selected' : '' ?>>Grande</option>
              </select>
            </div>

            <div class="form-group">
              <label for="sexo"><i class="fas fa-venus-mars"></i> Sexo</label>
              <select id="sexo" name="sexo">
                <option value="">Selecione</option>
                <option value="Macho" <?= $pet['sexo'] === 'Macho' ? 'selected' : '' ?>>Macho</option>
                <option value="Fêmea" <?= $pet['sexo'] === 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="imagem"><i class="fas fa-image"></i> Atualizar Imagem do Pet</label>
            <?php if (!empty($pet['imagem'])): ?>
              <div class="current-image">
                <img src="<?php echo url('/uploads/' . htmlspecialchars($pet['imagem'])); ?>" alt="Imagem atual">
                <p>Imagem atual</p>
              </div>
            <?php endif; ?>
            <input type="file" id="imagem" name="imagem" accept="image/*">
          </div>

          <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Salvar Alterações
          </button>

          <a href="<?php echo url('/list-pet'); ?>" class="btn-cancel">
            <i class="fas fa-times-circle"></i> Cancelar
          </a>
        </form>
      </div>
    </div>

    <!-- Begin footer-->
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <p class="footerp1">
              Todos os direitos reservados <span id="footer-year"></span> - VetZ
            </p>
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
  </script>

</body>
</html>
