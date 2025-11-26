<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';

// SE $pet NÃO EXISTIR, EVITA ERROS
$pet = isset($pet) && is_array($pet) ? $pet : [];

// SE $vacinas NÃO EXISTIR
$vacinas = isset($vacinas) && is_array($vacinas) ? $vacinas : [];

function safe($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteirinha - <?= safe($pet['nome'] ?? 'Pet Desconhecido') ?></title>

    <!-- CSS -->
    <link href="<?php echo url('/views/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/navbar.css'); ?>" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo url('/views/images/logo_vetz.svg'); ?>">
    <link rel="alternate icon" type="image/png" href="<?php echo url('/views/images/logoPNG.png'); ?>">

</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->


<!-- ------------------ CONTEÚDO ---------------------- -->

<section class="section07" id="sec07">
    <div class="container07">

        <!-- Informações do Pet -->
        <div class="header-info">
            <?php if (!empty($pet['imagem'])): ?>
                <div class="pet-photo">
                    <img src="<?php echo url('/uploads/' . htmlspecialchars($pet['imagem'])); ?>"
                         alt="<?= safe($pet['nome']) ?>"
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                </div>
            <?php else: ?>
                <div class="pet-photo">🐕</div>
            <?php endif; ?>

            <h1 class="nome-pet">
                <?= safe($pet['nome'] ?? 'Nome não informado') ?>
            </h1>

            <div class="pet-details">

                <div class="pet-detail-item">
                    <span class="pet-detail-label">Tutor</span>
                    <span class="pet-detail-value">
                        <?= safe($tutor['nome'] ?? 'Desconhecido') ?>
                    </span>
                </div>

                <div class="pet-detail-item">
                    <span class="pet-detail-label">Raça</span>
                    <span class="pet-detail-value">
                        <?= safe($pet['raca'] ?? 'Não informada') ?>
                    </span>
                </div>

            </div>
        </div>

        <!-- Carteira -->
        <div class="vaccination-card">

            <h2>
                Carteirinha de Vacinação Digital
                <a href="<?php echo url('/cadastrar-vacina?pet_id=' . ($pet['id'] ?? '')); ?>">
                    <button class="edit-btn">✏️ Registrar Vacinas</button>
                </a>
            </h2>

            <div class="age-alert">
                <strong>⏰ Atenção:</strong>
                Confira as vacinas recomendadas para a idade do seu pet.
            </div>


            <!-- Tabela de vacinas -->
            <table class="vaccine-table">
                <thead>
                    <tr>
                        <th>Vacina</th>
                        <th>Doses</th>
                        <th>Aplicação</th>
                        <th>Próxima Dose</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($vacinas)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Nenhuma vacinação registrada ainda.
                        </td>
                    </tr>

                <?php else: ?>
                    <?php foreach ($vacinas as $v): ?>

                        <tr>
                            <td><strong><?= safe($v['nome_vacina']) ?></strong></td>

                            <td><?= safe($v['doses']) ?></td>

                            <td>
                                <?= isset($v['data_vacinacao']) && !empty($v['data_vacinacao']) ? date("d/m/Y", strtotime($v['data_vacinacao'])) : '---' ?>
                            </td>

                            <td>
                                <?= isset($v['proxima_dose']) && !empty($v['proxima_dose']) ? date("d/m/Y", strtotime($v['proxima_dose'])) : '---' ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>
</section>


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

    <!-- Load JS =============================-->
    <script src="<?php echo url('/views/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.scrollTo-min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.nav.js'); ?>"></script>
    <script src="<?php echo url('/views/js/scripts.js'); ?>"></script>

</body>
</html>
