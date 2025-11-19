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

    <!-- Conteúdo principal -->
    <main>
        <section class="youtube-section">
            <h2>Vídeos</h2>

            <div class="video-buttons">
                <button class="recentes active">MAIS RECENTES</button>
                <button class="antigos">MAIS ANTIGOS</button>
            </div>

            <div id="recentes" class="video-grid ativo">
                <!-- Os vídeos serão carregados aqui via JavaScript -->
            </div>
            
            <div id="antigos" class="video-grid">
                <!-- Os vídeos serão carregados aqui via JavaScript -->
            </div>
        </section>
    </main>

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

    <!-- Scripts -->
    <script src="https://apis.google.com/js/api.js"></script> <!-- API do YouTube -->
    <script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
    <script src="/projeto/vetz/views/js/bootstrap.min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.scrollTo-min.js"></script>
    <script src="/projeto/vetz/views/js/jquery.nav.js"></script>
    <script src="/projeto/vetz/views/js/scripts.js"></script>

    <script>
        // Atualiza o ano no rodapé automaticamente
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>
    
</body>