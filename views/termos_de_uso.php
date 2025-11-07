<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Termos de Uso - VetZ";
ob_start();
?>

<section class="sectionTermoUso" id="termos" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Termos de Uso</h1>
                <p style="font-size:1.1rem;color:#444;">Ao utilizar o sistema VetZ, você concorda com os seguintes termos:</p>
                <ul style="font-size:1rem;color:#026d47;margin-top:24px;">
                    <li>Seus dados serão protegidos e utilizados apenas para fins de controle de vacinação.</li>
                    <li>O sistema não compartilha informações pessoais sem autorização.</li>
                    <li>É responsabilidade do usuário manter seus dados atualizados.</li>
                    <li>O VetZ pode enviar notificações sobre vacinas e novidades.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>