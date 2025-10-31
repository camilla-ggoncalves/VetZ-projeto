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
    <h1>Atualizar Pet</h1>
    <form action="/projeto/vetz/update-pet" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($pet['id']) ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($pet['nome']) ?>" required><br>

        <label for="raca">Raça:</label>
        <input type="text" name="raca" value="<?= htmlspecialchars($pet['raca']) ?>" required><br>

        <label for="idade">Idade:</label>
        <input type="number" name="idade" value="<?= htmlspecialchars($pet['idade']) ?>" required><br>

        <label for="porte">Porte:</label>
                <select name="porte" required>
                <option value="">Selecione</option>
                <option value="pequeno" <?= $pet['porte'] === 'pequeno' ? 'selected' : '' ?>>Pequeno</option>
                <option value="medio" <?= $pet['porte'] === 'medio' ? 'selected' : '' ?>>Médio</option>
                <option value="grande" <?= $pet['porte'] === 'grande' ? 'selected' : '' ?>>Grande</option>
            </select>    
        <br>
        

        <label for="peso">Peso:</label>
        <input type="text" name="peso" value="<?= htmlspecialchars($pet['peso']) ?>" required><br>


        <label for="sexo">Sexo:</label>
        <select name="sexo" required>
            <option value="Macho" <?= $pet['sexo'] === 'Macho' ? 'selected' : '' ?>>Macho</option>
            <option value="Fêmea" <?= $pet['sexo'] === 'Fêmea' ? 'selected' : '' ?>>Fêmea</option>
        </select><br>

        <label for="imagem">Imagem:</label>
        <?php if (!empty($pet['imagem'])): ?>
            <img src="/projeto/uploads/<?= htmlspecialchars($pet['imagem']) ?>" alt="Imagem atual" width="100"><br>
        <?php endif; ?>
        <input type="file" name="imagem"><br>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
