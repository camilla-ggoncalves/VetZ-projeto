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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Home Page - VetZ</title>

    <!-- CSS -->
    <link href="<?php echo url('/views/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/navbar.css'); ?>" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo url('/views/images/logo_vetz.svg'); ?>">
    <link rel="alternate icon" type="image/png" href="<?php echo url('/views/images/logoPNG.png'); ?>">

</head>

<body>

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <!-- --------------- CONTEÚDO DA PÁGINA ----------------->

    <!-- Begin Section 01 -->
    <section class="section01" id="sec01">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="sec01titleh1">A verdadeira cura começa no respeito pela vida.</h1>
                    <div class="col-lg-8 mx-auto">
                        <p class="sec01ph1">Gerencie todas as vacinações dos seus pets em um só lugar. Mantenha o
                            histórico completo e nunca perca uma data importante.</p>
                        <?php if (!$isLoggedIn): ?>
                            <div class="hero-buttons">
                                <a href="<?php echo url('/cadastrarForm'); ?>" class="btn-hero">
                                    <i class="fas fa-user-plus"></i> Comecar Gratuitamente
                                </a>
                                <a href="<?php echo url('/loginForm'); ?>" class="btn-hero-outline">
                                    <i class="fas fa-sign-in-alt"></i> Ja tenho conta
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="product-cards">

                        <!-- Card 1 -->
                        <div class="product-card">
                            <a href="https://lista.mercadolivre.com.br/tapete-higienico-c%C3%A3o-e-gato?sb=all_mercadolibre#D[A:tapete%20higienico%20c%C3%A3o%20e%20gato]"
                                target="_blank">
                                <img src="<?php echo url('/views/images/tapete_cao.jpg'); ?>"
                                    alt="Tapete higienico para caes e gatos" class="product-img">
                                <h2 class="product-title">TAPETE</h2>
                            </a>
                        </div>

                        <!-- Card 2 -->
                        <div class="product-card">
                            <a href="https://lista.mercadolivre.com.br/ra%C3%A7%C3%A3o-c%C3%A3o-e-gato#D[A:ra%C3%A7%C3%A3o%20c%C3%A3o%20e%20gato]"
                                target="_blank">
                                <img src="<?php echo url('/views/images/racao_cao.jpg'); ?>" alt="Racao para caes e gatos"
                                    class="product-img">
                                <h2 class="product-title">RACAO</h2>
                            </a>
                        </div>

                        <!-- Card 3 -->
                        <div class="product-card">
                            <a href="https://lista.mercadolivre.com.br/brinquedos-para-c%C3%A3o-e-gato?sb=all_mercadolibre#D[A:brinquedos%20para%20c%C3%A3o%20e%20gato]"
                                target="_blank">
                                <img src="<?php echo url('/views/images/brinquedo_cao.jpg'); ?>"
                                    alt="Brinquedos para caes e gatos" class="product-img">
                                <h2 class="product-title">BRINQUEDOS</h2>
                            </a>
                        </div>

                        <!-- Card 4 -->
                        <div class="product-card">
                            <a href="https://www.mercadolivre.com.br/colcho-cachorro-grande-pet-impermeavel-100x70-cor-marinho/p/MLB36933404?pdp_filters=item_id:MLB5233031478"
                                target="_blank">
                                <img src="<?php echo url('/views/images/cama_cao.jpg'); ?>" alt="Cama para cachorro"
                                    class="product-img">
                                <h2 class="product-title">CAMA</h2>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- End Section 01 -->

    <!-- Begin Section 01.1 -->
    <section id="features" class="section01_1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="sec01_1titleh2">Por que escolher o VetZ?</h2>
                    <p class="sec01_01ph2">Desenvolvido especialmente para donos de pets que se preocupam com a saúde
                        dos seus companheiros</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-syringe feature-icon"></i>
                        <h4 class="sec01_1titles">Controle de Vacinação</h4>
                        <p class="sec01_01ph2">Mantenha o histórico completo de todas as vacinas dos seus pets, com
                            datas e doses organizadas.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt feature-icon"></i>
                        <h4 class="sec01_1titles">Lembretes Automáticos</h4>
                        <p class="sec01_01ph2">Nunca mais esqueça uma vacinação importante com nosso sistema de
                            lembretes personalizados.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-paw feature-icon"></i>
                        <h4 class="sec01_1titles">Multi-Pets</h4>
                        <p class="sec01_01ph2">Gerencie quantos pets quiser em uma única conta. Cães, gatos ou outros
                            animais de estimação.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4 class="sec01_1titles">Relatórios Detalhados</h4>
                        <p class="sec01_01ph2">Visualize estatísticas e relatórios completos sobre a saúde preventiva
                            dos seus pets.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-mobile-alt feature-icon"></i>
                        <h4 class="sec01_1titles">Acesso em Qualquer Lugar</h4>
                        <p class="sec01_01ph2">Use em qualquer dispositivo - computador, tablet ou smartphone. Seus
                            dados sempre seguros.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h4 class="sec01_1titles">Dados Seguros</h4>
                        <p class="sec01_01ph2">Seus dados e dos seus pets estão protegidos com a mais alta tecnologia de
                            segurança.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Section 01.1 -->

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

</body>
</html>