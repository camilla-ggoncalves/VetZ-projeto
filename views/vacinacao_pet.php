<?php 
session_start();

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
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/images/logo_vetz.svg" rel="shortcut icon">
        <style>
        .header {
            position: relative;
        }

        .navbar {
            padding: 15px 0;
        }

        .navbar .container {
            display: flex;
            align-items: center;
        }

        .navbar .navbar-expand-lg {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logomenu {
            max-height: 50px;
        }

        /* Menu principal */
        .left-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 20px;
        }

        .left-menu li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .left-menu li a:hover {
            color: #007bff;
        }

        /* Menu hamburguer do usuário */
        .user-menu-wrapper {
            position: relative;
        }

        .btn-user-toggle {
            background: none;
            border: 2px solid #333;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-user-toggle:hover {
            background: #333;
            color: white;
        }

        .btn-user-toggle i {
            font-size: 20px;
        }

        /* Dropdown do usuário */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown.show {
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .user-greeting {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .user-dropdown-body {
            padding: 10px 0;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
            gap: 10px;
        }

        .user-dropdown-item:hover {
            background: #f8f9fa;
        }

        .user-dropdown-item img {
            width: 20px;
            height: 20px;
        }

        .user-dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .user-dropdown-item.logout {
            color: #dc3545;
            border-top: 1px solid #eee;
        }

        .user-dropdown-item.logout:hover {
            background: #ffe6e6;
        }

        /* Responsivo */
        @media (max-width: 991px) {
            .d-none {
                display: none !important;
            }

            .left-menu {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

<?php include __DIR__ . '/navbar.php'; ?>


<!-- ------------------ CONTEÚDO ---------------------- -->

<section class="section07" id="sec07">
    <div class="container07">

        <!-- Informações do Pet -->
        <div class="header-info">
            <div class="pet-photo">🐕</div>

            <h1 class="nome-pet">
                <?= safe($pet['nome'] ?? 'Nome não informado') ?>
            </h1>

            <p>Tutor: 
                <?= safe($pet['nome_tutor'] ?? 'Desconhecido') ?>
            </p>

            <div class="pet-details">

                <div class="pet-detail-item">
                    <span class="pet-detail-label">Raça</span>
                    <span class="pet-detail-value">
                        <?= safe($pet['raca'] ?? 'Não informada') ?>
                    </span>
                </div>

                <div class="pet-detail-item">
                    <span class="pet-detail-label">Nascimento</span>
                    <span class="pet-detail-value">
                        <?= (isset($pet['data_nascimento']) && !empty($pet['data_nascimento']))
                            ? date("d/m/Y", strtotime($pet['data_nascimento']))
                            : 'Não informado' ?>
                    </span>
                </div>

            </div>
        </div>

        <!-- Carteira -->
        <div class="vaccination-card">

            <h2>
                Carteirinha de Vacinação Digital
                <a href="/projeto/vetz/views/vacinacao_form.php">
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
                                <?= isset($v['data']) ? date("d/m/Y", strtotime($v['data'])) : '---' ?>
                            </td>

                            <td>
                                <?= isset($v['data']) ? date("d/m/Y", strtotime($v['data'] . " + 1 year")) : '---' ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>
</section>


<!-- ------------------- FOOTER ----------------------- -->

<div class="footer">
    <div class="container">
        <p class="footerp1">
            Todos os direitos reservados <span id="footer-year"></span> © - VetZ
        </p>
    </div>
</div>

<script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
<script src="/projeto/vetz/views/js/scripts.js"></script>

<script>
document.getElementById('footer-year').textContent = new Date().getFullYear();
</script>

</body>
</html>
