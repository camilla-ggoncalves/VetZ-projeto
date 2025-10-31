<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>VetZ</title>
    <!-- Loading Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Loading código CSS -->
    <link href="css/style.css" rel="stylesheet" media="screen and (color)">
    <!-- Awsome Fonts -->
    <link href="css/all.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link href="images/logoPNG.png" rel="shortcut icon">
</head>
<body>
    <h1>Atualizar Usuário</h1>
    <form action="/projeto/vetz/update-usuario/<?= htmlspecialchars($usuario['id']) ?>" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">


        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" value="<?= htmlspecialchars($usuario['senha']) ?>" required><br>

        <label for="imagem">Imagem:</label>
        <?php if (!empty($usuario['imagem'])): ?>
            <img src="/projeto/uploads/<?= htmlspecialchars($usuario['imagem']) ?>" alt="Imagem atual" width="100"><br>
        <?php endif; ?>
        <input type="file" name="imagem"><br>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
