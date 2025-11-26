<?php
// Navbar padrao para todas as paginas
require_once __DIR__ . '/../config/config.php';
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userId = $isLoggedIn ? $_SESSION['user_id'] : '';
?>
<header class="header">
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="left-menu">
                <li><a href="<?php echo url('/homepage'); ?>">HOME</a></li>
                <li><a href="<?php echo url('/sobre-nos'); ?>">SOBRE NOS</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="<?php echo url('/list-pet'); ?>">MEUS PETS</a></li>
                    <li><a href="<?php echo url('/cadastrar-vacina'); ?>">VACINACAO</a></li>
                <?php endif; ?>
                <li><a href="<?php echo url('/curiosidades'); ?>">CURIOSIDADES</a></li>
                <li><a href="<?php echo url('/recomendacoes'); ?>">ADOCAO</a></li>
            </ul>

            <div class="user-menu-wrapper">
                <?php if ($isLoggedIn): ?>
                    <button class="btn-user-toggle" type="button" id="userMenuToggle">
                        <i class="fas fa-user"></i>
                    </button>
                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-dropdown-header">
                            <span class="user-greeting">Ola, <?php echo htmlspecialchars($userName); ?></span>
                        </div>
                        <div class="user-dropdown-body">
                            <a class="user-dropdown-item" href="<?php echo url('/perfil-usuario?id=' . $userId); ?>">
                                <i class="fas fa-user-circle"></i>
                                Meu Perfil
                            </a>
                            <a class="user-dropdown-item" href="<?php echo url('/list-pet'); ?>">
                                <i class="fas fa-paw"></i>
                                Meus Pets
                            </a>
                            <a class="user-dropdown-item" href="<?php echo url('/list-vacinas'); ?>">
                                <i class="fas fa-syringe"></i>
                                Minhas Vacinacoes
                            </a>
                            <a class="user-dropdown-item logout" href="<?php echo url('/logout'); ?>">
                                <i class="fas fa-sign-out-alt"></i>
                                Sair
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="btn-cadastro" href="<?php echo url('/loginForm'); ?>">
                        <i class="fas fa-sign-in-alt"></i>
                        LOGIN
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
<link href="<?php echo url('/views/css/navbar.css'); ?>" rel="stylesheet">
<script src="<?php echo url('/views/js/navbar.js'); ?>"></script>
