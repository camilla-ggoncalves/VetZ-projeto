<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "VetZ - Controle de Vacinação para Pets";
ob_start();
?>

<style>
    .product-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: center;
        margin-top: 40px;
    }

    .product-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(44, 122, 122, 0.12);
        padding: 24px 16px;
        text-align: center;
        flex: 1 1 220px;
        min-width: 220px;
        max-width: 300px;
        transition: transform .3s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(44, 122, 122, 0.18);
    }

    .product-img {
        width: 100%;
        max-width: 120px;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .product-title {
        color: #2d7a7a;
        font-size: 1.2rem;
        margin: 8px 0 0;
        font-weight: 600;
    }

    .btn-careirinha {
        background: #038654;
        color: #fff;
        border: none;
        padding: 12px 32px;
        font-size: 1.1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-careirinha:hover {
        background: #026d47;
        transform: translateY(-2px);
        color: #fff;
    }

    @media (max-width: 600px) {
        .product-cards { gap: 16px; margin-top: 32px; }
        .product-card { padding: 16px 8px; min-width: 140px; max-width: 180px; }
        .product-img { max-width: 80px; }
        .product-title { font-size: 1rem; }
    }
</style>

<!-- Hero Section -->
<section class="section01 py-5" id="sec01" style="padding-top: 100px;">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h1 class="sec01titleh1 display-5 fw-bold">
                    A verdadeira cura começa no respeito pela vida.
                </h1>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="sec01ph1 lead text-muted mt-3">
                    Gerencie todas as vacinações dos seus pets em um só lugar.
                    Mantenha o histórico completo e nunca perca uma data importante.
                </p>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- USUÁRIO LOGADO -->
                    <div class="text-center mt-4 mb-2">
                        <p style="font-size:2rem;font-weight:700;color:#038654;">
                            <i class="fas fa-check-circle"></i> Olá, <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>!
                        </p>
                        <div style="margin-bottom:18px;">
                            <span style="font-size:1.3rem;color:#026d47;font-weight:500;display:block;margin-bottom:10px;">Crie agora a carteirinha de vacinação do seu pet:</span>
                            <a href="vacinacao_geral.php" class="btn btn-careirinha btn-lg" style="background:#04c97b;color:#fff;font-size:1.2rem;padding:16px 40px;border-radius:12px;box-shadow:0 2px 8px rgba(44,122,122,0.18);font-weight:700;">
                                <i class="fas fa-id-card"></i> Fazer Carteirinha de Vacinação
                            </a>
                        </div>
                    </div>
                    <div class="hero-buttons d-flex flex-column flex-sm-row gap-3 justify-content-center mt-2">
                        <a href="perfil_usuario.php" class="btn btn-outline-success btn-lg">
                            <i class="fas fa-user"></i> Meu Perfil
                        </a>
                    </div>

                <?php else: ?>
                    <!-- USUÁRIO NÃO LOGADO -->
                    <div class="hero-buttons d-flex flex-column flex-sm-row gap-3 justify-content-center mt-4">
                        <a href="cadastro.php" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-user-plus"></i> Começar Gratuitamente
                        </a>
                        <a href="login.php" class="btn btn-outline-success btn-lg px-4">
                            <i class="fas fa-sign-in-alt"></i> Já tenho conta
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cards de Produtos -->
        <div class="product-cards">
            <div class="product-card">
                <a href="https://lista.mercadolivre.com.br/tapete-higienico-cao-e-gato" target="_blank" class="text-decoration-none">
                    <img src="images/tapete_cao.jpg" alt="Tapete higiênico para pets" class="product-img">
                    <h2 class="product-title">TAPETE HIGIÊNICO</h2>
                </a>
            </div>

            <div class="product-card">
                <a href="https://lista.mercadolivre.com.br/racao-cao-e-gato" target="_blank" class="text-decoration-none">
                    <img src="images/racao_cao.jpg" alt="Ração premium para pets" class="product-img">
                    <h2 class="product-title">RAÇÃO PREMIUM</h2>
                </a>
            </div>
        </div>

        <!-- Recursos (Features) -->
        <div class="row mt-5 g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-syringe fa-2x text-success mb-3"></i>
                    <h4 class="h5 fw-semibold">Controle de Vacinação</h4>
                    <p class="text-muted small">Histórico completo de vacinas com datas, doses e certificados.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-calendar-alt fa-2x text-success mb-3"></i>
                    <h4 class="h5 fw-semibold">Lembretes Automáticos</h4>
                    <p class="text-muted small">Notificações por e-mail e app para nunca esquecer uma dose.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-paw fa-2x text-success mb-3"></i>
                    <h4 class="h5 fw-semibold">Multi-Pets</h4>
                    <p class="text-muted small">Gerencie cães, gatos e outros animais em uma única conta.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                    <h4 class="h5 fw-semibold">Relatórios Detalhados</h4>
                    <p class="text-muted small">Gráficos e estatísticas sobre a saúde preventiva dos pets.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-mobile-alt fa-2x text-success mb-3"></i>
                    <h4 class="h5 fw-semibold">Acesso em Qualquer Lugar</h4>
                    <p class="text-muted small">Use no celular, tablet ou computador com sincronização total.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                    <h4 class="h5 fw-semibold">Dados 100% Seguros</h4>
                    <p class="text-muted small">Criptografia avançada e backups automáticos diários.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>