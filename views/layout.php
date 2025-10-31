<?php
// layout.php - Layout base para todas as páginas
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title><?= isset($title) ? $title : 'VetZ' ?></title>
    <!-- Loading Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Loading código CSS -->
    <link href="css/style.css" rel="stylesheet" media="screen and (color)">
    <!-- Awsome Fonts -->
    <link href="css/all.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link href="images/logoPNG.png" rel="shortcut icon">
    <!-- Imagem na guia -->
    <link rel="icon" type="image/svg+xml" href="images/logo_vetz.svg">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main>
        <?php if (isset($content)) echo $content; ?>
    </main>
    <footer class="rodape">
        <p>Todos os direitos reservados © <?= date('Y') ?> - VetZ</p>
    </footer>
</body>
</html>
