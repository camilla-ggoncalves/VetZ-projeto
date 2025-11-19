<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';


// Garante que as variáveis sempre existam
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Vacinação - VetZ</title>

    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="images/logoPNG.png" rel="shortcut icon">

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

                                    <a class="btn btn-menu btn-perfil" href="/projeto/vetz/perfil" role="button">
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
    <!--End Header-->


        <!-- --------------- CONTEÚDO DA PÁGINA ----------------->
        <!-- Begin Section 06 -->
        <section class="section06" id="sec06">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="sec006titleh1">Pagina de Vacinações!</h1>
                        <p class="sec06ph1">Nesta página você poderá acessar as vacinações do seu pet.</p>
                        <div class="info-cards">
                        <!-- Card 1 -->
                        <div class="info-card">
                            <h2 class="sec06infosh2">Proteção</h2>
                            <p class="sec06infos">As vacinas são essenciais para proteger a saúde do seu pet e prevenir doenças graves.</p>
                        </div>

                        <!-- Card 2 -->
                        <div class="info-card">
                            <h2 class="sec06infosh2">Segurança</h2>
                            <p class="sec06infos">Elas evitam riscos tanto para os animais quanto para os humanos que convivem com eles.</p>
                        </div>

                        <!-- Card 3 -->
                        <div class="info-card">
                            <h2 class="sec06infosh2">Acompanhamento</h2>
                            <p class="sec06infos">Você pode visualizar e acompanhar as vacinações do seu cachorro ou gato.</p>
                        </div>
                        </div>

                        <div class="vacina">
                            <p class="sec06phvac">Confira as vacinas indicadas para proteger seu pet contra doenças comuns.</p>
                            <a href="/projeto/vetz/views/vacinacao_pet.php" class="carteirinha">Carteirinha Digital</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- End Section 06 -->

        

        <!-- Begin footer-->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="footerp1">
                            Todos os direitos reservados <span id="footer-year"></span> © - VetZ </p>
                    </div>

                    <!-- <div class="col-md-1">
                        <p class="instagram">
                            <a><img href="#!" src="images/instagram.svg"></a>
                    </div>
                    <div class="col-md-1">
                        <p class="email">
                            <a><img href="#!" src="images/email.svg"></a>
                    </div> -->
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