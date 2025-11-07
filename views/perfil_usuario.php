<?php
include 'views/check-auth.php';

// Proteção: redireciona se não estiver logado
if (!$isLoggedIn) {
    header('Location: /projeto/vetz/cadastrarForm');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="veterinária, vídeos, pets, animais">
    <meta name="description" content="Vídeos sobre cuidados veterinários e curiosidades sobre animais">

    <title>Vídeos - VetZ</title>
    
    <!-- Loading Bootstrap -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet" media="screen and (color)">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/projeto/vetz/views/images/logo_vetz.svg">
    <link rel="alternate icon" type="image/png" href="/projeto/vetz/views/images/logoPNG.png">
</head>

<body>
    <!--Begin Header-->
    <header class="header">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
    
                <a href="/projeto/vetz/" rel="home">
                    <img class="logomenu" src="/projeto/vetz/views/images/logo_vetz.svg" alt="VET Z" title="VetZ">
                </a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
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
                            <li>
                                <a class="btn btn-menu" href="/projeto/vetz/cadastrarForm" role="button">
                                <img class="imgperfil" src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil"> CADASTRO
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div> 
        </nav>
    </header>
    <!--End Header-->


    <!-- --------------- CONTEÚDO DA PÁGINA ----------------->

    <!-- Begin Section 04 -->
    <section class="section04" id="sec04">
        <button class="back-button" onclick="window.history.back()">←</button>
        
        <div class="container">
            <div class="main-profile">
                <div class="profile-header" id="profileHeader">
                    <button class="banner-upload" type="button" id="bannerUploadBtn">
                        📷 Alterar Banner
                    </button>
                    <input type="file" id="bannerInput" class="file-input" accept="image/*" style="display: none;">
                    
                    <div class="profile-avatar" id="avatarUploadBtn">
                        <img id="avatarImage" src="images/avatar-padrao.png" alt="Foto de perfil" class="avatar-placeholder">
                        <div class="avatar-upload-overlay">Clique para alterar</div>
                    </div>
                    <input type="file" id="avatarInput" class="file-input" accept="image/*" style="display: none;">
                    
                    <div class="tutor">Tutor</div>
                    <div class="pet-breed">Marcela Sanches Miossi</div>
                </div>

                <div class="profile-content">
                    <div class="info-section">
                        <h3 class="section-title">Contato do Tutor</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">Nome</div>
                                <div class="info-value">Marcela Sanches</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Telefone</div>
                                <div class="info-value">(11) 99999-9999</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Endereço</div>
                                <div class="info-value">São Paulo, SP</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Nascimento</div>
                                <div class="info-value">29/03/2008</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">marcelasanches@email.com</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section 04 -->

    <!-- Begin Section 04.1 -->
    <section class="sec04-1">
        <div class="container">
            <div class="section-title">
                Meus Pets
                <button class="add-pet-btn" type="button" id="addPetButton" title="Adicionar novo pet">+</button>
            </div>

            <div class="pets-grid" id="petsGrid">
                <!-- Os pets serão renderizados aqui pelo JavaScript -->
            </div>
        </div>
    </section>
    <!-- End Section 04.1 -->

    <!-- Modal para adicionar novo pet -->
    <div id="addPetModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Adicionar Novo Pet</h2>
                <button class="close-modal" type="button" id="closeModalBtn">&times;</button>
            </div>
            
            <form id="addPetForm">
                <div class="form-group">
                    <label for="petNameInput">Nome do Pet *</label>
                    <input type="text" id="petNameInput" name="petNameInput" placeholder="Ex: Rex, Miau, Bolinha..." required>
                </div>

                <div class="form-group">
                    <label for="petSpeciesInput">Espécie *</label>
                    <select id="petSpeciesInput" name="petSpeciesInput" required>
                        <option value="">Selecione a espécie</option>
                        <option value="Cachorro">Cachorro</option>
                        <option value="Gato">Gato</option>
                        <option value="Coelho">Coelho</option>
                        <option value="Pássaro">Pássaro</option>
                        <option value="Hamster">Hamster</option>
                        <option value="Peixe">Peixe</option>
                        <option value="Tartaruga">Tartaruga</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="petAgeInput">Idade (em anos) *</label>
                    <input type="number" id="petAgeInput" name="petAgeInput" placeholder="Ex: 3" min="0" max="30" required>
                </div>

                <div class="form-group">
                    <label for="petPhotoInput">Foto do Pet</label>
                    <div class="photo-upload-area" id="photoUploadArea">
                        <div class="photo-preview" id="photoPreview">
                            <span class="upload-icon">📷</span>
                            <span class="upload-text">Clique para adicionar foto do pet</span>
                        </div>
                        <img id="petPhotoPreview" class="pet-photo-img" style="display: none;" alt="Preview">
                    </div>
                    <input type="file" id="petPhotoInput" name="petPhotoInput" accept="image/*" style="display: none;">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="cancelBtn">Cancelar</button>
                    <button type="submit" class="btn-save">Salvar Pet</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Begin footer-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="footerp1">
                        Todos os direitos reservados <span id="footer-year"></span> © - VetZ
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--End footer-->

    <!-- Load JS =============================-->
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>

session_start();

// Proteção: usuário não logado → volta para login
if (!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$title   = 'Perfil do Usuário - VetZ';

ob_start();
?>

<style>
    .perfil-box {
        max-width: 420px;
        margin: 80px auto 40px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(44,122,122,0.12);
        padding: 32px 28px;
        text-align: center;
    }
    .perfil-title {
        color: #038654;
        font-size: 2rem;
        margin-bottom: 24px;
        font-weight: 600;
    }
    .perfil-info {
        font-size: 1.1rem;
        color: #222;
        margin-bottom: 12px;
    }
    .btn-home {
        background: linear-gradient(90deg, #04c97b 0%, #b6f7e1 100%);
        color: #026d47;
        border: none;
        border-radius: 8px;
        padding: 12px 32px;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 12px;
        margin-top: 8px;
        box-shadow: 0 2px 8px rgba(44,122,122,0.10);
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-home:hover {
        background: linear-gradient(90deg, #04c97b 0%, #7be3b7 100%);
        color: #014c2c;
    }
    .btn-logout {
        background: linear-gradient(90deg, #ffeaea 0%, #fff 100%);
        color: #d9534f;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-size: 1rem;
        margin-top: 8px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(44,122,122,0.08);
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-logout:hover {
        background: linear-gradient(90deg, #ffd6d6 0%, #fff 100%);
        color: #a94442;
    }
</style>

<div class="perfil-box">
    <h2 class="perfil-title">Perfil do Usuário</h2>

    <div class="perfil-info">
        <strong>Nome:</strong>
        <?= htmlspecialchars($usuario['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </div>

    <div class="perfil-info">
        <strong>Email:</strong>
        <?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>
    </div>

    <a href="homepage.php" class="btn-home d-block mb-2">
        <i class="fas fa-home"></i> Ir para Home
    </a>
    <form method="post" class="d-inline">
        <button type="submit" name="logout" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Sair
        </button>
    </form>
</div>

<?php
// Processa logout ANTES de renderizar o layout
if (isset($_POST['logout'])) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header('Location: login.php');
    exit;
}

$content = ob_get_clean();
include 'layout.php';
?>

