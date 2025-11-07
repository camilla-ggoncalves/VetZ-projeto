<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Dog - VetZ";
ob_start();
?>

<section class="sectionDog" id="dog" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Dog - VetZ</h1>
                <p style="font-size:1.1rem;color:#444;">Página especial para animações ou informações sobre cães.</p>
                <!-- Adicione aqui conteúdo especial ou animações -->
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>