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
    <title>Sobre Nós - VetZ</title>

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

    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->


        <!-- --------------- CONTEÚDO DA PÁGINA ----------------->

        <!-- Begin Section 02 -->
        <section class="section02" id="sec02">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="sec02titleh1">Bem-vindos</h1>
                        <p class="sec02ph1">Quem somos nós?

                            Somos um grupo de estudantes do 3º ano do ensino médio, com foco em veterinária e zootecnia. Nosso projeto, "Vetz", busca explorar de forma inovadora a relação entre os animais, a saúde deles e a acessibilidade.
                            com foco em áreas como comportamento animal, controle de vacinação e práticas de cuidado, unindo conhecimento e sensibilidade para transformar a forma como lidamos com os nossos animais.
                            Nosso objetivo é contribuir para o bem-estar dos animais, de forma que possamos juntar o carinho e cuidado por eles no VetZ.</p>
                        <!-- <p class="sec02ph2">texto.</p> -->
                    </div>
                </section>
        <!-- End Section 02 --> 

        <!-- Begin Section 03 -->
        <section class="section03" id="sec03">
            <div class="container">
                <h2 class="sec03titleh2">Integrantes do Projeto</h2>

                <!-- Contêiner para a primeira linha -->
                <div class="grid-container-line1">
                    <div class="grid-item">
                        <img src="/projeto/vetz/views/images/camilla_foto.png" class="card-img-top" alt="Camilla">
                        <p class="sec03phinte">CAMILLA GARCEZ</p>
                    </div>
                    <div class="grid-item">
                        <img src="/projeto/vetz/views/images/marcela_foto.jpg" class="card-img-top" alt="Marcela">
                        <p class="sec03phinte">MARCELA SANCHES</p>
                    </div>
                    <div class="grid-item">
                        <img src="/projeto/vetz/views/images/isadora_foto.png" class="card-img-top" alt="Isadora">
                        <p class="sec03phinte">ISADORA MOREIRA</p>
                    </div>
                </div>

                <!-- Contêiner para a segunda linha -->
                <div class="grid-container-line2">

                    <div class="grid-item-img1">
                        <img src="/projeto/vetz/views/images/victor_hugo_foto.png" class="card-img-top" alt="Victor">
                        <p class="sec03phinte">VICTOR M.</p>
                    </div>
                    <div class="grid-item-img2z">
                        <img src="/projeto/vetz/views/images/alexandre_foto.jpeg" class="card-img-top" alt="Guilherme">
                        <p class="sec03phinte">GUILHERME A.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section 03  -->

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