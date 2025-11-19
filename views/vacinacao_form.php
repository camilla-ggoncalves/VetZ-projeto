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
    <title><?= $titulo ?> - VetZ</title>

    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">

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
<header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar navbar-expand-lg">
                <a href="/projeto/vetz/" rel="home">
                    <img class="logomenu" src="/projeto/vetz/views/images/logo_vetz.svg" alt="VET Z" title="VetZ">
                </a>

                <!-- Menu principal para desktop -->
                <div class="navbar-collapse collapse d-none d-lg-flex" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto left-menu">
                        <li><a href="/projeto/vetz/homepage">HOME PAGE</a></li>
                        <li><a href="/projeto/vetz/sobre-nos">SOBRE NÓS</a></li>
                        <li><a href="/projeto/vetz/curiosidades">CURIOSIDADES</a></li>
                        <li><a href="/projeto/vetz/recomendacoes">RECOMENDAÇÕES</a></li>
                        <li><a href="/projeto/vetz/cadastrar-vacina">VACINAÇÃO</a></li>
                    </ul>
                </div>

                <!-- Menu hamburguer do usuário -->
                <div class="user-menu-wrapper ml-auto">
                    <?php if ($isLoggedIn): ?>
                        <button class="btn-user-toggle" type="button" id="userMenuToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="user-dropdown" id="userDropdown">
                            <div class="user-dropdown-header">
                                <span class="user-greeting">Olá, <?php echo htmlspecialchars($userName); ?></span>
                            </div>
                            <div class="user-dropdown-body">
                                <a class="user-dropdown-item" href="/projeto/vetz/views/perfil_usuario.php">
                                    <img src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil">
                                    Acessar Perfil
                                </a>
                                <a class="user-dropdown-item logout" href="/projeto/vetz/logout.php">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Sair
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a class="btn btn-menu" href="/projeto/vetz/cadastrarForm" role="button">
                            <img class="imgperfil" src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil">
                            CADASTRO
                        </a>
                    <?php endif; ?>
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
                <a href="/projeto/vetz/formulario" class="btn btn-primary btn-sm ml-2">Cadastrar Pet</a>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form action="/projeto/vetz/salvar-vacina" method="POST">
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
                            <label><i class="fas fa-prescription-bottle-alt"></i> Número de Doses *</label>
                            <input type="number" class="form-control" name="doses" min="1" max="10" 
                                   value="<?= isset($vacinacao['doses']) ? htmlspecialchars($vacinacao['doses']) : '1' ?>" 
                                   required>
                            <small class="form-text text-muted">Número total de doses aplicadas</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-vial"></i> Tipo de Vacina *</label>
                    <input type="text" class="form-control" name="id_vacina" 
                           value="<?= isset($vacinacao['id_vacina']) ? htmlspecialchars($vacinacao['id_vacina']) : '' ?>" 
                           placeholder="Ex: V8, V10, Antirrábica, V5, etc." 
                           required
                           list="sugestoes-vacinas">
                    
                    <!-- Lista de sugestões -->
                    <datalist id="sugestoes-vacinas">
                        <?php foreach ($sugestoesVacinas as $vacina): ?>
                            <option value="<?= htmlspecialchars($vacina) ?>">
                        <?php endforeach; ?>
                    </datalist>
                    
                    <small class="form-text text-muted">
                        Digite o nome da vacina. Sugestões: V8, V10, Antirrábica, V5, Giárdia, etc.
                    </small>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-paw"></i> Pet *</label>
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
                    <?= $id ? "Atualizar Vacinação" : "Salvar Vacinação" ?>
                </button>

                <?php if (empty($pets)): ?>
                <div class="text-center mt-3">
                    <a href="/projeto/vetz/cadastrar-pet" class="btn btn-primary">
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

        // Validação da data
        document.querySelector('form').addEventListener('submit', function(e) {
            const dataInput = document.querySelector('input[name="data"]');
            const selectedDate = new Date(dataInput.value);
            const today = new Date();
            
            if (selectedDate > today) {
                e.preventDefault();
                alert('A data da vacinação não pode ser futura.');
                dataInput.focus();
            }
        });

        // Auto-complete para vacinas
        const vacinaInput = document.querySelector('input[name="id_vacina"]');
        const sugestoes = <?= json_encode($sugestoesVacinas) ?>;
        
        vacinaInput.addEventListener('input', function() {
            const valor = this.value.toLowerCase();
            if (valor.length > 1) {
                const sugestoesFiltradas = sugestoes.filter(vacina => 
                    vacina.toLowerCase().includes(valor)
                );
                
                // Se quiser mostrar sugestões em tempo real, pode implementar aqui
                console.log('Sugestões:', sugestoesFiltradas);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuToggle && userDropdown) {
        // Toggle dropdown ao clicar no botão
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(e) {
            if (!userMenuToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });
        
        // Prevenir que cliques dentro do dropdown o fechem
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
    </script>
</body>
</html>