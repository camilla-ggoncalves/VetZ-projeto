<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Teste - VetZ";
ob_start();
?>

<section class="sectionTeste" id="teste" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Página de Teste</h1>
                <p style="font-size:1.1rem;color:#444;">Esta página é utilizada para testes e experimentos no sistema VetZ.</p>
                <!-- Adicione aqui conteúdo de teste -->
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>