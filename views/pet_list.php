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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pets - VetZ</title>

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

        .pets-container {
            max-width: 100%;
            margin: 15px auto;
            padding: 0 40px;
            flex: 1;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-top: 40px;
            padding: 25px 0;
            border-top: 1px solid #e0e0e0;
        }

        .pagination-info {
            color: #666;
            font-size: 14px;
            margin: 0 20px;
            font-weight: 500;
        }

        .pagination-btn {
            padding: 10px 18px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 45px;
            justify-content: center;
        }

        .pagination-btn.active {
            background: #038654;
            color: #fff;
            box-shadow: 0 4px 12px rgba(3, 134, 84, 0.25);
            transform: scale(1.05);
        }

        .pagination-btn:not(.active):not(.disabled) {
            background: #fff;
            color: #038654;
            border: 2px solid #e0e0e0;
        }

        .pagination-btn:not(.active):not(.disabled):hover {
            border-color: #038654;
            background: #f8fdf8;
            transform: translateY(-2px);
        }

        .pagination-btn.disabled {
            background: #f5f5f5;
            color: #ccc;
            border: 2px solid #e0e0e0;
            cursor: not-allowed;
        }

        .page-header {
            text-align: center;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .page-header h1 {
            font-family: 'Poppins-Bold';
            color: #038654;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .page-header p {
            color: #555;
            font-size: 12px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .btn-action {
            background: #038654;
            color: #fff;
            padding: 6px 16px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            font-size: 11px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(3, 134, 84, 0.2);
        }

        .btn-action:hover {
            background: #55974A;
            transform: translateY(-2px);
            box-shadow: 0 5px 18px rgba(3, 134, 84, 0.3);
            color: #000;
        }

        .btn-action.secondary {
            background: #fff;
            color: #038654;
            border: 2px solid #038654;
        }

        .btn-action.secondary:hover {
            background: #038654;
            color: #fff;
        }

        .pets-wrapper {
            position: relative;
            padding: 20px 0;
        }

        .pets-grid {
            display: flex;
            gap: 20px;
            margin-top: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pet-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: block;
            flex: 0 1 calc(16.666% - 17px);
            min-width: 200px;
            max-width: 280px;
        }

        .pet-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .pet-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #f0f0f0;
        }

        .pet-info {
            padding: 12px;
        }

        .pet-name {
            font-size: 16px;
            font-weight: bold;
            color: #038654;
            margin-bottom: 8px;
            text-align: left;
        }

        .pet-details-mini {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 10px;
        }

        .pet-raca {
            font-size: 11px;
            color: #555;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .pet-stats {
            display: flex;
            justify-content: space-between;
            gap: 8px;
        }

        .pet-stat {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            font-size: 10px;
        }

        .pet-stat-label {
            color: #999;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .pet-stat-value {
            color: #038654;
            font-weight: 600;
            font-size: 11px;
        }

        .pet-vacinas-badge {
            margin-top: 8px;
            padding: 6px 10px;
            background: #e8f5e9;
            border-left: 3px solid #038654;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            color: #038654;
            font-weight: 600;
        }

        .pet-vacinas-badge i {
            font-size: 12px;
        }

        .pet-actions {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid #eee;
        }

        .btn-pet {
            flex: 1;
            padding: 6px;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
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

        .btn-vaccine {
            background: #e8f5e9;
            color: #038654;
        }

        .btn-vaccine:hover {
            background: #038654;
            color: #000;
        }

        .pet-badge {
            display: inline-block;
            background: #B5E7A0;
            color: #038654;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .empty-state i {
            font-size: 80px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            color: #555;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #888;
            margin-bottom: 25px;
        }

        .alert {
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 12px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 3px solid #038654;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 3px solid #dc3545;
        }

        @media (max-width: 1400px) {
            .pet-card {
                flex: 0 1 calc(20% - 16px);
            }
        }

        @media (max-width: 1200px) {
            .pet-card {
                flex: 0 1 calc(25% - 15px);
            }
        }

        @media (max-width: 992px) {
            .pet-card {
                flex: 0 1 calc(33.333% - 14px);
            }

            .pets-container {
                padding: 0 20px;
            }
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 20px;
            }

            .pet-card {
                flex: 0 1 calc(50% - 10px);
                min-width: 160px;
            }

            .pets-container {
                padding: 0 15px;
            }
        }

        @media (max-width: 480px) {
            .pet-card {
                flex: 0 1 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="pets-container">
        <div class="page-header">
            <h1>Meus Pets</h1>
            <p>Gerencie todos os seus pets em um só lugar</p>
        </div>

        <!-- Mensagens -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= $_SESSION['success_message'] ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error_message'] ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Botoes de Acao -->
        <div class="action-buttons">
            <a href="<?php echo url('/formulario'); ?>" class="btn-action">
                <i class="fas fa-plus-circle"></i>
                Cadastrar Novo Pet
            </a>
            <a href="<?php echo url('/cadastrar-vacina'); ?>" class="btn-action secondary">
                <i class="fas fa-syringe"></i>
                Vacinações
            </a>
        </div>

        <!-- Grid de Pets -->
        <?php if (!empty($pets)): ?>
            <div class="pets-wrapper">
                <div class="pets-grid">
                <?php foreach ($pets as $pet): ?>
                    <div class="pet-card" onclick="window.location='<?php echo url('/update-pet/' . $pet['id']); ?>'">
                        <?php if (!empty($pet['imagem'])): ?>
                            <img src="<?php echo url('/uploads/' . htmlspecialchars($pet['imagem'])); ?>"
                                 alt="<?= htmlspecialchars($pet['nome']) ?>"
                                 class="pet-image">
                        <?php else: ?>
                            <div class="pet-image" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #B5E7A0, #86C67C);">
                                <i class="fas fa-paw" style="font-size: 50px; color: #fff;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="pet-info">
                            <div class="pet-name"><?= htmlspecialchars($pet['nome']) ?></div>

                            <div class="pet-details-mini">
                                <?php if (!empty($pet['raca'])): ?>
                                    <div class="pet-raca"><?= htmlspecialchars($pet['raca']) ?></div>
                                <?php endif; ?>

                                <div class="pet-stats">
                                    <?php if (!empty($pet['idade'])): ?>
                                        <div class="pet-stat">
                                            <span class="pet-stat-label">Idade</span>
                                            <span class="pet-stat-value"><?= htmlspecialchars($pet['idade']) ?> anos</span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($pet['peso'])): ?>
                                        <div class="pet-stat">
                                            <span class="pet-stat-label">Peso</span>
                                            <span class="pet-stat-value"><?= htmlspecialchars($pet['peso']) ?> kg</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if (isset($pet['total_vacinas'])): ?>
                                    <div class="pet-vacinas-badge">
                                        <i class="fas fa-syringe"></i>
                                        <span><?= $pet['total_vacinas'] ?> vacina<?= $pet['total_vacinas'] != 1 ? 's' : '' ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="pet-actions" onclick="event.stopPropagation();">
                                <a href="<?php echo url('/vacinacao-pet/' . $pet['id']); ?>" class="btn-pet btn-vaccine" title="Acessar Carteirinha">
                                    <i class="fas fa-syringe"></i>
                                </a>
                                <a href="<?php echo url('/update-pet/' . $pet['id']); ?>" class="btn-pet btn-edit" title="Editar Pet">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo url('/delete-pet/' . $pet['id']); ?>"
                                   class="btn-pet btn-delete"
                                   title="Excluir Pet"
                                   onclick="event.preventDefault(); event.stopPropagation(); if(confirm('<?= !empty($pet['tem_vacina']) ? 'Excluir este pet apagara todas as vacinacoes dele. Quer continuar?' : 'Tem certeza que deseja excluir este pet?' ?>')) { window.location.href=this.href; }">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>

            <!-- Paginação -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <!-- Botão Anterior -->
                    <a href="<?php echo url('/list-pet?page=' . max(1, $currentPage - 1)); ?>"
                       class="pagination-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </a>

                    <!-- Números das páginas -->
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?php echo url('/list-pet?page=' . $i); ?>"
                           class="pagination-btn <?= $i == $currentPage ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <!-- Botão Próximo -->
                    <a href="<?php echo url('/list-pet?page=' . min($totalPages, $currentPage + 1)); ?>"
                       class="pagination-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                        Próximo <i class="fas fa-chevron-right"></i>
                    </a>

                    <!-- Info -->
                    <span class="pagination-info">
                        Página <?= $currentPage ?> de <?= $totalPages ?> (<?= $totalPets ?> pets)
                    </span>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-paw"></i>
                <h2>Nenhum pet cadastrado ainda</h2>
                <p>Comece cadastrando seu primeiro pet para acompanhar a saude dele!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
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

    <!-- Load JS -->
    <script src="<?php echo url('/views/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.scrollTo-min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.nav.js'); ?>"></script>
    <script src="<?php echo url('/views/js/scripts.js'); ?>"></script>

    <script>
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
