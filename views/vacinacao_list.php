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
  <title>Vacinações Registradas - VetZ</title>

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

    .vacinas-container {
      max-width: 1200px;
      margin: 20px auto;
      padding: 0 20px;
      flex: 1;
    }

    .page-header {
      text-align: center;
      margin-bottom: 20px;
      margin-top: 15px;
    }

    .page-header h1 {
      font-family: 'Poppins-Bold';
      color: #038654;
      font-size: 24px;
      margin-bottom: 8px;
    }

    .page-header p {
      color: #666;
      font-size: 13px;
    }

    .action-button {
      text-align: center;
      margin-bottom: 25px;
    }

    .btn-action {
      background: #038654;
      color: #fff;
      padding: 10px 20px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 3px 12px rgba(3, 134, 84, 0.2);
    }

    .btn-action:hover {
      background: #55974A;
      transform: translateY(-2px);
      box-shadow: 0 5px 18px rgba(3, 134, 84, 0.3);
      color: #000;
    }

    .table-container {
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead {
      background: linear-gradient(135deg, #038654, #55974A);
    }

    thead th {
      padding: 15px;
      text-align: left;
      color: #fff;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    tbody tr {
      border-bottom: 1px solid #f0f0f0;
      transition: background 0.2s;
    }

    tbody tr:hover {
      background: #f8fdf8;
    }

    tbody td {
      padding: 15px;
      color: #333;
      font-size: 14px;
    }

    .empty-state {
      text-align: center;
      padding: 50px 20px;
    }

    .empty-state i {
      font-size: 60px;
      color: #ddd;
      margin-bottom: 15px;
    }

    .empty-state h3 {
      color: #666;
      margin-bottom: 10px;
    }

    .empty-state p {
      color: #999;
      margin-bottom: 20px;
    }

    .action-links {
      display: flex;
      gap: 10px;
    }

    .btn-edit, .btn-delete {
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 12px;
      font-weight: 600;
      transition: all 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .btn-edit {
      background: #e3f2fd;
      color: #1976d2;
    }

    .btn-edit:hover {
      background: #1976d2;
      color: #fff;
    }

    .btn-delete {
      background: #ffebee;
      color: #d32f2f;
    }

    .btn-delete:hover {
      background: #d32f2f;
      color: #fff;
    }

    .badge-vacina {
      background: #B5E7A0;
      color: #038654;
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: 600;
    }

    @media (max-width: 768px) {
      .table-container {
        padding: 15px;
      }

      table {
        font-size: 12px;
      }

      thead th, tbody td {
        padding: 10px 8px;
      }

      .action-links {
        flex-direction: column;
        gap: 5px;
      }
    }
  </style>

</head>
<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <div class="vacinas-container">
      <div class="page-header">
        <h1><i class="fas fa-syringe"></i> Vacinações Registradas</h1>
        <p>Histórico completo de todas as vacinações dos seus pets</p>
      </div>

      <div class="action-button">
        <a href="<?php echo url('/nova-vacina'); ?>" class="btn-action">
          <i class="fas fa-plus-circle"></i> Cadastrar Nova Vacinação
        </a>
      </div>

      <div class="table-container">
        <?php if (!empty($vacinas)): ?>
          <table>
            <thead>
              <tr>
                <th><i class="fas fa-calendar-alt"></i> Data</th>
                <th><i class="fas fa-syringe"></i> Vacina</th>
                <th><i class="fas fa-paw"></i> Pet</th>
                <th><i class="fas fa-user"></i> Tutor</th>
                <th><i class="fas fa-pills"></i> Doses</th>
                <th><i class="fas fa-cogs"></i> Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($vacinas as $vacina): ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($vacina['data_vacinacao'])) ?></td>
                  <td><span class="badge-vacina"><?= htmlspecialchars($vacina['nome_vacina']) ?></span></td>
                  <td><?= htmlspecialchars($vacina['nome_pet']) ?></td>
                  <td><?= htmlspecialchars($vacina['nome_tutor']) ?></td>
                  <td><?= htmlspecialchars($vacina['doses']) ?></td>
                  <td>
                    <div class="action-links">
                      <a href="<?php echo url('/editar-vacina/' . $vacina['id']); ?>" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                      </a>
                      <a href="<?php echo url('/excluir-vacina/' . $vacina['id']); ?>"
                         class="btn-delete"
                         onclick="return confirm('Tem certeza que deseja excluir esta vacinação?');">
                        <i class="fas fa-trash"></i> Excluir
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="empty-state">
            <i class="fas fa-syringe"></i>
            <h3>Nenhuma vacinação registrada</h3>
            <p>Comece cadastrando a primeira vacinação dos seus pets</p>
          </div>
        <?php endif; ?>
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
