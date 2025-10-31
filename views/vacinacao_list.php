<?php include 'navbar.php'; ?>
<?php
// views/vacinacao/vacina_list.php
// Arquivo responsável por exibir a lista de vacinações registradas no sistema.
?>

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

<?php
$title = "Vacinações Registradas - VetZ";
ob_start();
?>
    <div class="container mt-4">
        <h2 class="mb-4">Vacinações Registradas</h2>
        <a href="/projeto/vetz/cadastrar-vacina" class="btn btn-success mb-3">Cadastrar nova vacinação</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Doses</th>
                    <th>Vacina</th>
                    <th>Pet</th>
                    <th>Tutor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($vacinacoes)) : ?>
                    <?php foreach ($vacinacoes as $vacina) : ?>
                        <tr>
                            <td><?= htmlspecialchars($vacina['data']) ?></td>
                            <td><?= htmlspecialchars($vacina['doses']) ?></td>
                            <td><?= htmlspecialchars($vacina['vacina']) ?></td>
                            <td><?= htmlspecialchars($vacina['nome_pet']) ?></td>
                            <td><?= htmlspecialchars($vacina['nome_tutor']) ?></td>
                            <td>
                                <a href="/projeto/vetz/editar-vacina/<?= $vacina['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="/projeto/vetz/excluir-vacina/<?= $vacina['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta vacinação?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else { ?>
                    <tr>
                        <td colspan="6">Nenhuma vacinação registrada.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
require_once 'layout.php';
?>
                </tr>

            <?php endif; ?>
