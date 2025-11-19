<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Perfil Pet - VetZ</title>

    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="images/logoPNG.png" rel="shortcut icon">
</head>

<body>

    <!--Begin Header-->
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
                                    <a class="btn btn-menu" href="/projeto/vetz/perfil-usuario?id=<?php echo $_SESSION['user_id']; ?>" role="button">
                                        <img class="imgperfil" src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil">
                                        PERFIL
                                    </a>
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
    <!--End Header-->

    <!-- --------------- CONTEÚDO DA PÁGINA ----------------->

<div class="profile-container">
    <?php if (!isset($pet) || empty($pet)): ?>
        <div class="text-center">
            <h3>Pet não encontrado</h3>
            <p>O pet solicitado não foi encontrado ou o identificador não foi informado.</p>
            <a href="/projeto/vetz/list-pet" class="btn btn-secondary">Voltar</a>
        </div>
    <?php else: ?>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="m-0">Perfil do Pet</h2>
            <div class="back-btn">
                <a href="/projeto/vetz/list-pet" class="btn btn-secondary">Voltar</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 text-center">
                <?php
                    $imagem = !empty($pet['imagem']) ? $pet['imagem'] : 'default.png';
                    $imagemPath = "/projeto/vetz/uploads/" . htmlspecialchars($imagem);
                ?>
                <img src="<?= $imagemPath ?>" alt="Foto de <?= htmlspecialchars($pet['nome'] ?? 'Pet') ?>" class="pet-img">
            </div>

            <div class="col-md-8">
                <div class="info-box">
                    <div class="info-title">Informações do Pet</div>
                    <p><strong>Nome:</strong> <?= htmlspecialchars($pet['nome'] ?? 'N/A') ?></p>
                    <p><strong>Raça:</strong> <?= htmlspecialchars($pet['raca'] ?? 'N/A') ?></p>
                    <p><strong>Idade:</strong> <?= htmlspecialchars($pet['idade'] ?? 'N/A') ?> <?= isset($pet['idade']) ? 'anos' : '' ?></p>
                    <p><strong>Porte:</strong> <?= htmlspecialchars($pet['porte'] ?? 'N/A') ?></p>
                    <p><strong>Peso:</strong> <?= htmlspecialchars($pet['peso'] ?? 'N/A') ?> <?= isset($pet['peso']) ? 'kg' : '' ?></p>
                    <p><strong>Sexo:</strong> <?= htmlspecialchars($pet['sexo'] ?? 'N/A') ?></p>
                </div>

                <div class="info-box">
                    <div class="info-title">Tutor</div>
                    <p><strong>Nome:</strong> <?= htmlspecialchars($pet['user_name'] ?? 'N/A') ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($pet['user_email'] ?? 'N/A') ?></p>
                </div>

                <div class="mt-4">
                    <a href="/projeto/vetz/update-pet?id=<?= htmlspecialchars($pet['id']) ?>" class="btn btn-primary">Editar Pet</a>
                    <a href="/projeto/vetz/delete-pet?id=<?= htmlspecialchars($pet['id']) ?>" class="btn btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir?')">Excluir Pet</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

        <!-- Load JS =============================-->
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>

    </body>
</html>
