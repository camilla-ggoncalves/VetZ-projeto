<?php
// Navbar padrão para todas as páginas
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>
<header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar navbar-expand-lg">
                <a href="/projeto/vetz/" rel="home">
                    <img class="logomenu" src="/projeto/vetz/views/images/logo_vetz.svg" alt="VET Z" title="VetZ">
                </a>
                <div class="navbar-collapse collapse d-none d-lg-flex" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto left-menu">
                        <li><a href="/projeto/vetz/homepage">HOME PAGE</a></li>
                        <li><a href="/projeto/vetz/sobre-nos">SOBRE NÓS</a></li>
                        <li><a href="/projeto/vetz/curiosidades">CURIOSIDADES</a></li>
                        <li><a href="/projeto/vetz/recomendacoes">RECOMENDAÇÕES</a></li>
                        <li><a href="/projeto/vetz/cadastrar-vacina">VACINAÇÃO</a></li>
                    </ul>
                </div>
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
<link href="/projeto/vetz/views/css/navbar.css" rel="stylesheet">
<script src="/projeto/vetz/views/js/navbar.js"></script>
