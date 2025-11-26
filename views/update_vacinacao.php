<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';

require_once __DIR__ . '/../models/Vacinacao.php';
require_once __DIR__ . '/../models/Pet.php';

// Verifica se a variável $vacina foi passada pelo controller
if (!isset($vacina) || empty($vacina)) {
    echo "Vacinação não encontrada.";
    exit;
}

// Buscar lista de vacinas disponíveis
$vacinacaoModel = new Vacinacao();
$vacinasDisponiveis = $vacinacaoModel->listarVacinas();

// Buscar pets do usuário
$petModel = new Pet();
$pets = $petModel->getPetsByUsuario($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Editar Vacinação - VetZ</title>

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

    .form-group input[type="date"],
    .form-group input[type="number"],
    .form-group select {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
      font-family: 'Poppins', Arial, sans-serif;
    }

    .form-group input[type="date"]:focus,
    .form-group input[type="number"]:focus,
    .form-group select:focus {
      outline: none;
      border-color: #038654;
      box-shadow: 0 0 0 3px rgba(3, 134, 84, 0.1);
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
          <h2><i class="fas fa-syringe"></i> Editar Vacinação</h2>
          <p>Atualize os dados da vacinação</p>
        </div>

        <form action="<?php echo url('/editar-vacina/' . $vacina['id']); ?>" method="POST">
          <input type="hidden" name="id" value="<?= htmlspecialchars($vacina['id']) ?>">

          <div class="form-group">
            <label for="id_pet"><i class="fas fa-paw"></i> Pet</label>
            <select id="id_pet" name="id_pet" required>
              <option value="">Selecione um pet</option>
              <?php foreach ($pets as $pet): ?>
                <option value="<?= $pet['id'] ?>" <?= $vacina['id_pet'] == $pet['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($pet['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="id_vacina"><i class="fas fa-syringe"></i> Vacina</label>
            <select id="id_vacina" name="id_vacina" required>
              <option value="">Selecione uma vacina</option>
              <?php foreach ($vacinasDisponiveis as $vac): ?>
                <option value="<?= $vac['id_vacina'] ?>" <?= $vacina['id_vacina'] == $vac['id_vacina'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($vac['nome_vacina']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="data"><i class="fas fa-calendar-alt"></i> Data da Vacinação</label>
              <input type="date" id="data" name="data" value="<?= htmlspecialchars($vacina['data_vacinacao']) ?>" required>
            </div>

            <div class="form-group">
              <label for="doses"><i class="fas fa-pills"></i> Doses</label>
              <input type="number" id="doses" name="doses" value="<?= htmlspecialchars($vacina['doses']) ?>" min="1" required>
            </div>
          </div>

          <div class="form-group">
            <label for="proxima_dose"><i class="fas fa-calendar-plus"></i> Próxima Dose (opcional)</label>
            <input type="date" id="proxima_dose" name="proxima_dose" value="<?= isset($vacina['proxima_dose']) && $vacina['proxima_dose'] ? htmlspecialchars($vacina['proxima_dose']) : '' ?>">
          </div>

          <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Salvar Alterações
          </button>

          <a href="<?php echo url('/cadastrar-vacina'); ?>" class="btn-cancel">
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
