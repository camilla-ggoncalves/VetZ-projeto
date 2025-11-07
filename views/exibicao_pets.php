<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Exibição de Pets - VetZ";
ob_start();
?>

<section class="sectionExibicaoPets" id="exibicao-pets" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Exibição de Pets</h1>
                <p style="font-size:1.1rem;color:#444;">Aqui você pode visualizar os pets cadastrados no sistema.</p>
                <!-- Adicione aqui a listagem dinâmica dos pets se desejar -->
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>