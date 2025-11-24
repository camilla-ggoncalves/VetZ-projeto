<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/VacinacaoController.php';
require_once __DIR__ . '/../controllers/PetController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Protecao
if (!isset($_SESSION['user_id'])) {
    redirect('/loginForm');
}

$vacinacaoController = new VacinacaoController();
$petController = new PetController();

$id = $_GET['id'] ?? null;
$vacinacao = $id ? $vacinacaoController->buscarPorId($id) : null;

// Pega o pet_id da URL se vier da carteirinha
$pet_id_url = $_GET['pet_id'] ?? null;

// Carrega pets do usuário logado
$pets = $petController->listarPorUsuario($_SESSION['user_id']);

// Variáveis para o header
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Usuário';

$titulo = $id ? "Editar Vacinação" : "Cadastrar Nova Vacinação";

// Obter sugestões de vacinas
$sugestoesVacinas = [
    'V8 / V10 (Cães)',
    'Antirrábica',
    'V5 (Gatos)',
    'Giárdia',
    'Tosse dos Canis',
    'Leishmaniose',
    'V4 (Gatos)',
    'V3 (Gatos)',
    'Raiva',
    'Influenza Canina',
    'Parvovirose',
    'Cinomose'
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova vacinação - VetZ</title>

    <!-- CSS -->
    <link href="<?php echo url('/views/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/all.min.css'); ?>" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo url('/views/images/logo_vetz.svg'); ?>">
    <link rel="alternate icon" type="image/png" href="<?php echo url('/views/images/logoPNG.png'); ?>">

    <style>
        .page-title {
            font-family: 'Poppins-Bold';
            color: #038654;
            text-align: center;
            margin: 30px 0 10px;
            font-size: 28px;
        }
        .page-subtitle {
            text-align: center;
            color: #555;
            margin-bottom: 40px;
            font-size: 16px;
        }
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 700px;
            margin: 20px auto;
        }
        .form-control {
            border: 2px solid #B5E7A0 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            background: #f8fdf8 !important;
            font-size: 15px;
            height: auto !important;
            min-height: 48px !important;
        }
        .form-control select,
        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23038654' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 12px;
            padding-right: 40px !important;
        }
        .form-control option {
            padding: 10px;
            background: white;
            color: #333;
        }
        .form-control option:first-child {
            color: #999;
        }
        .form-control:focus {
            border-color: #038654 !important;
            box-shadow: 0 0 0 4px rgba(3,134,84,0.15) !important;
            background: white !important;
        }
        label {
            color: #038654;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 15px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #038654, #55974A);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-family: 'Poppins-Bold';
            font-size: 17px;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(3,134,84,0.4);
            color: #000;
        }
        .back-btn {
            position: absolute;
            left: 20px;
            top: 120px;
            background: white;
            border: 2px solid #B5E7A0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #038654;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .back-btn:hover {
            background: #038654;
            color: white;
            transform: scale(1.1);
        }
        .alert {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #038654;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }
        .sugestoes-vacina {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 5px;
            display: none;
        }
        .sugestao-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }
        .sugestao-item:hover {
            background-color: #f8f9fa;
        }
        .sugestao-item:last-child {
            border-bottom: none;
        }
        @media (max-width: 768px) {
            .form-card { padding: 30px 20px; margin: 10px; }
            .back-btn { top: 100px; left: 15px; }
        }
    </style>
</head>
<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <!-- Botao voltar -->
    <a href="<?php echo url('/list-vacinas'); ?>" class="back-btn">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="container">
        <h1 class="page-title">
            <i class="fas fa-syringe"></i> <?= $titulo ?>
        </h1>
        <p class="page-subtitle">Preencha os dados da vacinação com atenção</p>

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

        <?php if (empty($pets)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                <strong>Nenhum pet cadastrado!</strong> Você precisa cadastrar um pet antes de registrar vacinações. 
                <a href="<?php echo url('/formulario'); ?>" class="btn btn-primary btn-sm ml-2">Cadastrar Pet</a>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form action="<?php echo url('/salvar-vacina'); ?>" method="POST">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label><i class="fas fa-calendar-alt"></i> Data da Aplicação *</label>
                            <input type="date" class="form-control" name="data"
                                   value="<?= isset($vacinacao['data']) ? htmlspecialchars($vacinacao['data']) : '' ?>"
                                   required max="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label><i class="fas fa-calendar-plus"></i> Próxima Dose</label>
                            <input type="date" class="form-control" name="proxima_dose"
                                   value="<?= isset($vacinacao['proxima_dose']) ? htmlspecialchars($vacinacao['proxima_dose']) : '' ?>"
                                   min="<?= date('Y-m-d') ?>">
                            <small class="form-text text-muted">Data prevista para a próxima dose (opcional)</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-prescription-bottle-alt"></i> Número de Doses *</label>
                    <input type="number" class="form-control" name="doses" min="1" max="10"
                           value="<?= isset($vacinacao['doses']) ? htmlspecialchars($vacinacao['doses']) : '1' ?>"
                           required>
                    <small class="form-text text-muted">Número total de doses aplicadas</small>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-vial"></i> Tipo de Vacina *</label>
                    <select class="form-control" name="id_vacina" required style="color: #999;">
                        <option value="" disabled selected>Selecione a vacina</option>
                        <?php if (isset($vacinas) && !empty($vacinas)): ?>
                            <?php foreach ($vacinas as $vac): ?>
                                <option value="<?= $vac['id_vacina'] ?>" 
                                    <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == $vac['id_vacina']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($vac['nome_vacina']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Nenhuma vacina disponível</option>
                        <?php endif; ?>
                    </select>
                    
                    <small class="form-text text-muted">
                        Selecione o tipo de vacina a aplicar
                    </small>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-paw"></i> Pet *</label>
                    <select class="form-control" name="id_pet" required <?= empty($pets) ? 'disabled' : '' ?> style="color: #999;">
                        <option value="" disabled selected>Selecione o pet</option>
                        <?php if (!empty($pets)): ?>
                            <?php foreach ($pets as $pet): ?>
                                <?php
                                // Pré-seleciona se vier da URL ou se for edição
                                $selected = false;
                                if (isset($vacinacao['id_pet']) && $vacinacao['id_pet'] == $pet['id']) {
                                    $selected = true;
                                } elseif (isset($pet_id_url) && $pet_id_url == $pet['id']) {
                                    $selected = true;
                                }
                                ?>
                                <option value="<?= $pet['id'] ?>" <?= $selected ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($pet['nome']) ?> (<?= htmlspecialchars($pet['raca'] ?? 'N/A') ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Nenhum pet cadastrado</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label><i class="fas fa-stethoscope"></i> Veterinário</label>
                            <input type="text" class="form-control" name="veterinario" 
                                   value="<?= isset($vacinacao['veterinario']) ? htmlspecialchars($vacinacao['veterinario']) : '' ?>" 
                                   placeholder="Nome do veterinário responsável">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label><i class="fas fa-map-marker-alt"></i> Local de Aplicação</label>
                            <input type="text" class="form-control" name="local" 
                                   value="<?= isset($vacinacao['local']) ? htmlspecialchars($vacinacao['local']) : '' ?>" 
                                   placeholder="Clínica ou local onde foi aplicada">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-file-medical-alt"></i> Observações</label>
                    <textarea class="form-control" name="observacoes" rows="3" 
                              placeholder="Observações adicionais sobre a vacinação"><?= isset($vacinacao['observacoes']) ? htmlspecialchars($vacinacao['observacoes']) : '' ?></textarea>
                </div>

                <button type="submit" class="btn-submit" <?= empty($pets) ? 'disabled' : '' ?>>
                    <i class="fas fa-save"></i>
                    <?= $id ? "Atualizar Vacinacao" : "Salvar Vacinacao" ?>
                </button>

                <?php if (empty($pets)): ?>
                <div class="text-center mt-3">
                    <a href="<?php echo url('/formulario'); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Cadastrar Pet Primeiro
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

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

    <script>
        // Mudar cor do select quando uma opcao for selecionada
        $(document).ready(function() {
            $('select.form-control').on('change', function() {
                if ($(this).val() !== '') {
                    $(this).css('color', '#333');
                } else {
                    $(this).css('color', '#999');
                }
            });

            // Definir cor inicial baseado no valor atual
            $('select.form-control').each(function() {
                if ($(this).val() !== '' && $(this).val() !== null) {
                    $(this).css('color', '#333');
                }
            });
        });
    </script>

</body>
</html>