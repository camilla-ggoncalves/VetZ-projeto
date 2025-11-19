<?php
require_once '../controllers/VacinacaoController.php';
require_once '../controllers/PetController.php';

session_start();

// Proteção
if (!isset($_SESSION['user_id'])) {
    header('Location: /projeto/vetz/login');
    exit;
}

$vacinacaoController = new VacinacaoController();
$petController = new PetController();

$id = $_GET['id'] ?? null;
$vacinacao = $id ? $vacinacaoController->buscarPorId($id) : null;

// CORREÇÃO: Usando o método correto do PetController
$pets = $petController->listarPorUsuario($_SESSION['user_id']);

// Variáveis para o header
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Usuário';

$titulo = $id ? "Editar Vacinação" : "Cadastrar Nova Vacinação";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> - VetZ</title>

    <!-- Seus CSS originais -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">

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
            max-width: 600px;
            margin: 20px auto;
        }
        .form-control {
            border: 2px solid #B5E7A0 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            background: #f8fdf8 !important;
            font-size: 15px;
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
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #17a2b8;
        }
        @media (max-width: 768px) {
            .form-card { padding: 30px 20px; margin: 10px; }
            .back-btn { top: 100px; left: 15px; }
        }
    </style>
</head>
<body>
    <header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar navbar-expand-lg">
                <a href="/projeto/vetz/" rel="home">
                    <img class="logomenu" src="/projeto/vetz/views/images/logo_vetz.svg" alt="VET Z" title="VetZ">
                </a>

                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>

                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto left-menu">
                        <li><a href="/projeto/vetz/homepage">HOME PAGE</a></li>
                        <li><a href="/projeto/vetz/sobre-nos">SOBRE NÓS</a></li>
                        <li><a href="/projeto/vetz/curiosidades">CURIOSIDADES</a></li>
                        <li><a href="/projeto/vetz/recomendacoes">RECOMENDAÇÕES</a></li>
                        <li><a href="/projeto/vetz/cadastrar-vacina">VACINAÇÃO</a></li>

                        <?php if ($isLoggedIn): ?>
                            <!-- Usuário LOGADO -->
                            <li>
                                <div class="user-logged-menu">
                                    <span class="user-name">Olá, <?php echo htmlspecialchars($userName); ?></span>

                                    <a class="btn btn-menu btn-perfil" href="/projeto/vetz/views/perfil_usuario.php" role="button">
                                        <img class="imgperfil" src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil">
                                        PERFIL
                                    </a>

                                    <a class="btn btn-menu btn-logout" href="/projeto/vetz/logout.php" role="button">
                                        SAIR
                                    </a>
                                </div>
                            </li>

                        <?php else: ?>
                            <!-- Usuário NÃO LOGADO -->
                            <li>
                                <a class="btn btn-menu" href="/projeto/vetz/cadastrarForm" role="button">
                                    <img class="imgperfil" src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil">
                                    CADASTRO
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

    <!-- Botão voltar -->
    <a href="/projeto/vetz/listar-vacinas" class="back-btn">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="container">
        <h1 class="page-title">
            <i class="fas fa-syringe"></i> <?= $titulo ?>
        </h1>
        <p class="page-subtitle">Preencha os dados da vacinação com atenção</p>

        <?php if (empty($pets)): ?>
            <div class="alert-info">
                <i class="fas fa-info-circle"></i> 
                <strong>Nenhum pet cadastrado!</strong> Você precisa cadastrar um pet antes de registrar vacinações. 
                <a href="/projeto/vetz/views/pet_form.php" class="btn btn-primary btn-sm ml-2">Cadastrar Pet</a>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form action="/projeto/vetz/salvar-vacina" method="POST">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="form-group mb-4">
                    <label><i class="fas fa-calendar-alt"></i> Data da Aplicação</label>
                    <input type="date" class="form-control" name="data" 
                           value="<?= isset($vacinacao['data']) ? htmlspecialchars($vacinacao['data']) : '' ?>" 
                           required max="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-prescription-bottle-alt"></i> Número de Doses</label>
                    <input type="number" class="form-control" name="doses" min="1" max="10" 
                           value="<?= isset($vacinacao['doses']) ? htmlspecialchars($vacinacao['doses']) : '1' ?>" 
                           required>
                    <small class="form-text text-muted">Número total de doses aplicadas</small>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-vial"></i> Tipo de Vacina</label>
                    <select class="form-control" name="id_vacina" required>
                        <option value="">Selecione a vacina</option>
                        <option value="1" <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == 1) ? 'selected' : '' ?>>V8 / V10 (Cães)</option>
                        <option value="2" <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == 2) ? 'selected' : '' ?>>Antirrábica</option>
                        <option value="3" <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == 3) ? 'selected' : '' ?>>V5 (Gatos)</option>
                        <option value="4" <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == 4) ? 'selected' : '' ?>>Giárdia</option>
                        <option value="5" <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == 5) ? 'selected' : '' ?>>Tosse dos Canis</option>
                        <option value="6" <?= (isset($vacinacao['id_vacina']) && $vacinacao['id_vacina'] == 6) ? 'selected' : '' ?>>Leishmaniose</option>
                    </select>
                </div>

                <div class="form-group mb-5">
                    <label><i class="fas fa-paw"></i> Pet</label>
                    <select class="form-control" name="id_pet" required <?= empty($pets) ? 'disabled' : '' ?>>
                        <option value="">Selecione o pet</option>
                        <?php if (!empty($pets)): ?>
                            <?php foreach ($pets as $pet): ?>
                                <option value="<?= $pet['id'] ?>" 
                                    <?= (isset($vacinacao['id_pet']) && $vacinacao['id_pet'] == $pet['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($pet['nome']) ?> (<?= htmlspecialchars($pet['especie'] ?? 'N/A') ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>Nenhum pet cadastrado</option>
                        <?php endif; ?>
                    </select>
                    <?php if (empty($pets)): ?>
                        <small class="form-text text-danger">
                            <i class="fas fa-exclamation-triangle"></i> 
                            Cadastre um pet primeiro para poder registrar vacinações.
                        </small>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-submit" <?= empty($pets) ? 'disabled' : '' ?>>
                    <i class="fas fa-save"></i>
                    <?= $id ? "Atualizar Vacinação" : "Salvar Vacinação" ?>
                </button>

                <?php if (empty($pets)): ?>
                <div class="text-center mt-3">
                    <a href="/projeto/vetz/views/pet_form.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Cadastrar Pet Primeiro
                    </a>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <p class="footerp1">
                Todos os direitos reservados <span id="footer-year"></span> © - VetZ
            </p>
        </div>
    </div>

    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>