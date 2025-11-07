<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container py-2">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="homepage.php">
            <img src="images/logo_vetz.svg" alt="VetZ" height="45" class="me-2">
            <span class="fw-bold text-success fs-5">VetZ</span>
        </a>

        <!-- Toggler (mobile) -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars text-success fs-4"></i>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto text-center">
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark px-3" href="homepage.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark px-3" href="sobre_nos.php">SOBRE NÓS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark px-3" href="curiosidades.php">CURIOSIDADES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark px-3" href="vacinacao_geral.php">VACINAÇÃO</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-medium text-dark px-3" href="carteirinha.php">CARTEIRINHA</a>
                </li>
            </ul>

            <!-- Botões de Login/Cadastro -->
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?php
                if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
                if (isset($_POST['logout'])) {
                    $_SESSION = array();
                    if (ini_get("session.use_cookies")) {
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                            $params["path"], $params["domain"],
                            $params["secure"], $params["httponly"]
                        );
                    }
                    session_destroy();
                    header('Location: login.php');
                    exit;
                }
                ?>
                <?php if (!isset($_SESSION['usuario'])): ?>
                    <!-- DESLOGADO -->
                    <a href="cadastro.php" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-user-plus me-2"></i> Cadastrar
                    </a>
                    <a href="login.php" class="btn btn-outline-success px-4 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </a>
                <?php else: ?>
                    <!-- LOGADO -->
                    <div class="d-flex align-items-center gap-3">
                        <a href="perfil_usuario.php" class="text-decoration-none">
                            <span class="d-flex align-items-center text-success fw-medium">
                                <i class="fas fa-user-circle fs-4 me-2"></i>
                                <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
                            </span>
                        </a>
                        <form method="post" style="display:inline;">
                            <button type="submit" name="logout" class="btn btn-outline-danger px-4 py-2 rounded-pill shadow-sm">
                                <i class="fas fa-sign-out-alt me-2"></i> Sair
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>