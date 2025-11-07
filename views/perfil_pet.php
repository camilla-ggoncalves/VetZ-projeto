<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Perfil do Pet - VetZ";
ob_start();
?>

<section class="sectionPerfilPet" id="perfil-pet" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Perfil do Pet</h1>
                <p style="font-size:1.1rem;color:#444;">Aqui você pode visualizar e editar informações do seu pet.</p>
                <!-- Adicione aqui informações dinâmicas do pet -->
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>