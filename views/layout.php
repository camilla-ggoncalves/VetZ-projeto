<?php
// INICIA A SESSÃO AQUI — UMA ÚNICA VEZ
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VetZ - Controle de vacinas e saúde dos seus pets.">
    <title><?= htmlspecialchars($title ?? 'VetZ') ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/logoPNG.png">
    <link rel="icon" type="image/svg+xml" href="images/logo_vetz.svg">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Estilos -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <main class="flex-shrink-0">
        <?= $content ?? '' ?>
    </main>

    <footer class="footer bg-light py-4 mt-auto border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted small">
                        Todos os direitos reservados <span id="footer-year"></span> © VetZ
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>