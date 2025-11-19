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
    <link rel="icon" type="image/svg+xml" href="/projeto/vetz/views/images/logo_vetz.svg">
    <link rel="alternate icon" type="image/png" href="/projeto/vetz/views/images/logoPNG.png">
    
</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
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