<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    header('Location: /projeto/vetz/loginForm');
    exit;
}

if (!isset($usuario) || empty($usuario)) {
    echo "Usuário não encontrado.";
    exit;
}

$nome  = htmlspecialchars($usuario['nome'] ?? 'N/A');
$email = htmlspecialchars($usuario['email'] ?? 'N/A');
$telefone = htmlspecialchars($usuario['telefone'] ?? 'N/A');
$endereco = htmlspecialchars($usuario['endereco'] ?? 'N/A');
$nascimento = htmlspecialchars($usuario['nascimento'] ?? 'N/A');

$imagem = !empty($usuario['imagem']) ? $usuario['imagem'] : 'avatar-padrao.png';
$imagemPath = "/projeto/vetz/uploads/" . htmlspecialchars($imagem);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - VetZ</title>

    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">

    <style>
        .avatar-placeholder {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }
        .section-title {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .info-label {
            font-size: 14px;
            color: #666;
        }
        .info-value {
            font-size: 18px;
            font-weight: 500;
            color: #333;
        }
    </style>
</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->


<section class="section04" id="sec04">
    <button class="back-button" onclick="window.history.back()">←</button>

    <div class="container">
        <div class="main-profile">

            <!-- FOTO E BANNER -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <img id="avatarImage" src="<?= $imagemPath ?>" alt="Foto do usuário" class="avatar-placeholder">
                </div>

                <div class="tutor">Tutor</div>
                <div class="pet-breed"><?= $nome ?></div>
            </div>

            <!-- DADOS DE CONTATO -->
            <div class="profile-content">
                <div class="info-section">
                    <h3 class="section-title">Informações do Usuário</h3>

                    <div class="info-grid">

                        <div class="info-item">
                            <div class="info-label">Nome</div>
                            <div class="info-value"><?= $nome ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= $email ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Telefone</div>
                            <div class="info-value"><?= $telefone ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Endereço</div>
                            <div class="info-value"><?= $endereco ?></div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Nascimento</div>
                            <div class="info-value"><?= $nascimento ?></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SEÇÃO "MEUS PETS" — (você já tinha ela, mantida 100%) -->
<section class="sec04-1">
    <div class="container">
        <div class="section-title">
            Meus Pets
            <button class="add-pet-btn" type="button" id="addPetButton">+</button>
        </div>

        <div class="pets-grid" id="petsGrid"></div>
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
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>

</body>
</html>
