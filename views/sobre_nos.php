<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Sobre Nós - VetZ";
ob_start();
?>

<section class="sectionSobreNos" id="sobre-nos" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Sobre o VetZ</h1>
                <p style="font-size:1.1rem;color:#444;">O VetZ é um sistema dedicado ao controle de vacinação de pets, facilitando o acompanhamento da saúde dos animais de estimação. Nossa missão é garantir que todos os pets estejam protegidos e que seus tutores tenham acesso fácil ao histórico de vacinas, lembretes e informações importantes.</p>
                <ul style="font-size:1rem;color:#026d47;margin-top:24px;">
                    <li>Histórico completo de vacinas</li>
                    <li>Lembretes automáticos</li>
                    <li>Multi-pets em uma conta</li>
                    <li>Relatórios detalhados</li>
                    <li>Dados seguros e criptografados</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>