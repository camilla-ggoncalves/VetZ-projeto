<!-- navbar.php -->
<header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a href="homepage.php" rel="home">
                    <img class="logomenu" src="images/logo_vetz.svg" alt="VET Z" title="VetZ">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>
                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto left-menu">
                        <li><a href="homepage.php">HOME PAGE</a></li>
                        <li><a href="sobre_nos.html">SOBRE NÓS</a></li>
                        <li><a href="curiosidades.html">CURIOSIDADES</a></li>
                        <li><a href="vacinacao_geral.html">VACINAÇÃO</a></li>
                        <li><a href="cadastro.php" class="btn btn-menu" role="button">
                            <?php if (!isset($_SESSION['usuario'])): ?>
                                <span class="perfil-emoji" title="Perfil">👤</span>
                            <?php else: ?>
                                <img class="imgperfil" src="images/perfil" alt="Perfil">
                            <?php endif; ?>
                            CADASTRO</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </nav>
</header>
