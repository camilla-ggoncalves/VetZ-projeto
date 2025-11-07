<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$title = "Curiosidades - VetZ";
ob_start();
?>

<section class="sectionCuriosidades" id="curiosidades" style="padding-top:100px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <h1 class="text-success mb-4" style="font-size:2rem;font-weight:700;">Curiosidades sobre Pets</h1>
                <ul style="font-size:1.1rem;color:#444;">
                    <li>Os cães têm cerca de 220 milhões de receptores olfativos no nariz.</li>
                    <li>Gatos dormem em média 16 horas por dia.</li>
                    <li>O latido de um cachorro pode ser diferente para cada situação.</li>
                    <li>Animais de estimação ajudam a reduzir o estresse dos tutores.</li>
                    <li>Existem mais de 340 raças de cães reconhecidas mundialmente.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'layout.php';
?>