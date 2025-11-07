<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Vacinação Pet ADM - VetZ";
ob_start();
?>

<section class="sectionVacinacaoPetAdm" id="vacinacao-pet-adm" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Vacinação Pet ADM</h1>
                <p style="font-size:1.1rem;color:#444;">Página administrativa para controle de vacinação dos pets.</p>
                <!-- Adicione aqui funcionalidades administrativas -->
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>