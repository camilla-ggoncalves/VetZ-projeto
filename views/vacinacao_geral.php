<?php
session_start();

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
    <title>VetZ</title>

    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="images/logoPNG.png" rel="shortcut icon">
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


<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "VetZ - Vacinação Geral";
ob_start();
?>
<style>
    .section06 {
        padding: 40px 0;
    }
    .info-cards {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 32px;
    }
    .info-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(44,122,122,0.10);
    padding: 8px 8px 12px 8px;
    text-align: center;
    flex: 1 1 160px;
    min-width: 140px;
    max-width: 180px;
    margin-bottom: 12px;
    min-height: 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    }
    .sec006titleh1 {
        color: #038654;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 18px;
        text-align: center;
    }
    .sec06ph1 {
        font-size: 1.2rem;
        color: #444;
        text-align: center;
        margin-bottom: 32px;
    }
    .sec06infosh2 {
        color: #2d7a7a;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .sec06infos {
        color: #555;
        font-size: 1rem;
        margin-bottom: 0;
    }
    .vacina {
        text-align: center;
        margin-top: 32px;
    }
    .sec06phvac {
        font-size: 1.1rem;
        color: #026d47;
        margin-bottom: 12px;
    }
    .carteirinha {
        background: #04c97b;
        color: #fff;
        font-size: 1.1rem;
        padding: 12px 32px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(44,122,122,0.12);
        transition: background 0.3s;
        display: inline-block;
    }
    .carteirinha:hover {
        background: #038654;
        color: #fff;
    }
    @media (max-width: 900px) {
        .info-cards {
            gap: 16px;
        }
        .info-card {
            min-width: 160px;
            max-width: 220px;
            padding: 16px 8px;
        }
        .sec006titleh1 {
            font-size: 1.5rem;
        }
    }
    @media (max-width: 600px) {
        .section06 {
            padding: 24px 0;
        }
        .info-cards {
            flex-direction: column;
            gap: 12px;
        }
        .info-card {
            min-width: 100%;
            max-width: 100%;
            margin-bottom: 8px;
        }
        .sec006titleh1 {
            font-size: 1.2rem;
        }
        .sec06ph1 {
            font-size: 1rem;
        }
        .sec06phvac {
            font-size: 1rem;
        }
        .carteirinha {
            font-size: 1rem;
            padding: 10px 18px;
        }
    }
</style>

<section class="section06" id="sec06" style="padding-top: 120px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="sec006titleh1">Página de Vacinações!</h1>
                <p class="sec06ph1">Nesta página você poderá acessar as vacinações do seu pet.</p>
                <div class="info-cards">
                    <div class="info-card">
                        <h2 class="sec06infosh2">Proteção</h2>
                        <p class="sec06infos">As vacinas são essenciais para proteger a saúde do seu pet e prevenir doenças graves.</p>
                    </div>
                    <div class="info-card">
                        <h2 class="sec06infosh2">Segurança</h2>
                        <p class="sec06infos">Elas evitam riscos tanto para os animais quanto para os humanos que convivem com eles.</p>
                    </div>
                    <div class="info-card">
                        <h2 class="sec06infosh2">Acompanhamento</h2>
                        <p class="sec06infos">Você pode visualizar e acompanhar as vacinações do seu cachorro ou gato.</p>
                    </div>
                </div>
                <div class="vacina">
                    <p class="sec06phvac">Confira as vacinas indicadas para proteger seu gato contra doenças comuns.</p>
                    <a href="vacinacao_pet.php" class="carteirinha">Carteirinha Digital</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>

