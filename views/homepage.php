<?php 
session_start();
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
    <title>VetZ</title>

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

    <!--Begin Header-->
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
    <!--End Header-->

    <!-- --------------- CONTEÚDO DA PÁGINA ----------------->

    <!-- Begin Section 01 -->
    <section class="section01" id="sec01">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="sec01titleh1">A verdadeira cura começa no respeito pela vida.</h1>
                    <div class="col-lg-8 mx-auto">
                        <p class="sec01ph1">Gerencie todas as vacinações dos seus pets em um só lugar. Mantenha o histórico completo e nunca perca uma data importante.</p>
                        <div class="hero-buttons">
                            <a href="/projeto/vetz/cadastrarForm" class="btn-hero">
                                <i class="fas fa-user-plus"></i> Começar Gratuitamente
                            </a>
                            <a href="/projeto/vetz/loginForm" class="btn-hero-outline">
                                <i class="fas fa-sign-in-alt"></i> Já tenho conta
                            </a>
                        </div>
                    </div>

                    <div class="product-cards">

                        <!-- Card 1 -->
                        <div class="product-card">
                            <a href="https://lista.mercadolivre.com.br/tapete-higienico-c%C3%A3o-e-gato?sb=all_mercadolibre#D[A:tapete%20higienico%20c%C3%A3o%20e%20gato]" target="_blank">
                                <img src="/projeto/vetz/views/images/tapete_cao.jpg" alt="Tapete higiênico para cães e gatos" class="product-img">
                                <h2 class="product-title">TAPETE</h2>
                            </a>
                        </div>

                        <!-- Card 2 -->
                        <div class="product-card">
                            <a href="https://lista.mercadolivre.com.br/ra%C3%A7%C3%A3o-c%C3%A3o-e-gato#D[A:ra%C3%A7%C3%A3o%20c%C3%A3o%20e%20gato]" target="_blank">
                                <img src="/projeto/vetz/views/images/racao_cao.jpg" alt="Ração para cães e gatos" class="product-img">
                                <h2 class="product-title">RAÇÃO</h2>
                            </a>
                        </div>

                        <!-- Card 3 -->
                        <div class="product-card">
                            <a href="https://lista.mercadolivre.com.br/brinquedos-para-c%C3%A3o-e-gato?sb=all_mercadolibre#D[A:brinquedos%20para%20c%C3%A3o%20e%20gato]" target="_blank">
                                <img src="/projeto/vetz/views/images/brinquedo_cao.jpg" alt="Brinquedos para cães e gatos" class="product-img">
                                <h2 class="product-title">BRINQUEDOS</h2>
                            </a>
                        </div>

                        <!-- Card 4 -->
                        <div class="product-card">
                            <a href="https://www.mercadolivre.com.br/colcho-cachorro-grande-pet-impermeavel-100x70-cor-marinho/p/MLB36933404?pdp_filters=item_id:MLB5233031478" target="_blank">
                                <img src="/projeto/vetz/views/images/cama_cao.jpg" alt="Cama para cachorro" class="product-img">
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
                    <p class="sec01_01ph2">Desenvolvido especialmente para donos de pets que se preocupam com a saúde dos seus companheiros</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-syringe feature-icon"></i>
                        <h4 class="sec01_1titles">Controle de Vacinação</h4>
                        <p class="sec01_01ph2">Mantenha o histórico completo de todas as vacinas dos seus pets, com datas e doses organizadas.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt feature-icon"></i>
                        <h4 class="sec01_1titles">Lembretes Automáticos</h4>
                        <p class="sec01_01ph2">Nunca mais esqueça uma vacinação importante com nosso sistema de lembretes personalizados.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-paw feature-icon"></i>
                        <h4 class="sec01_1titles">Multi-Pets</h4>
                        <p class="sec01_01ph2">Gerencie quantos pets quiser em uma única conta. Cães, gatos ou outros animais de estimação.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4 class="sec01_1titles">Relatórios Detalhados</h4>
                        <p class="sec01_01ph2">Visualize estatísticas e relatórios completos sobre a saúde preventiva dos seus pets.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-mobile-alt feature-icon"></i>
                        <h4 class="sec01_1titles">Acesso em Qualquer Lugar</h4>
                        <p class="sec01_01ph2">Use em qualquer dispositivo - computador, tablet ou smartphone. Seus dados sempre seguros.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h4 class="sec01_1titles">Dados Seguros</h4>
                        <p class="sec01_01ph2">Seus dados e dos seus pets estão protegidos com a mais alta tecnologia de segurança.</p>
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
                <!--
                <div class="col-md-1">
                    <p class="instagram">
                        <a><img href="#!" src="/projeto/vetz/views/images/instagram.svg"></a>
                </div>
                <div class="col-md-1">
                    <p class="email">
                        <a><img href="#!" src="/projeto/vetz/views/images/email.svg"></a>
                </div>
                -->
            </div>
        </div>
    </div>
    <!--End footer-->


    <!-- Load JS =============================-->
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>
    <script>
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