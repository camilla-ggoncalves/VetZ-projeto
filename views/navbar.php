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
                        <li><a href="carteirinha.php">CARTEIRINHA</a></li>
                        <?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
                        <?php if (!isset($_SESSION['usuario'])): ?>
                            <li><a href="cadastro.php" class="btn btn-menu" role="button">
                                <span class="perfil-emoji" title="Perfil">👤</span>
                                CADASTRO</a></li>
                            <li><a href="login.php" class="btn btn-menu" role="button">LOGIN</a></li>
                        <?php else: ?>
                            <li><a href="perfil_usuario.php" class="btn btn-menu" role="button">
                                <span class="perfil-emoji" title="Perfil">👤</span>
                                <?= htmlspecialchars($_SESSION['usuario']['nome']) ?></a></li>
                            <li><form method="post" style="display:inline;"><button type="submit" name="logout" class="btn btn-menu" style="background:#d9534f;color:#fff;">SAIR</button></form></li>
                            <?php if (isset($_POST['logout'])) { session_destroy(); header('Location: homepage.php'); exit; } ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </nav>
</header>