
<?php
$title = "Pets Cadastrados - VetZ";
ob_start();
?>
<h1>Pets Cadastrados</h1>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>Raça</th>
        <th>Idade</th>
        <th>Porte</th>
        <th>Peso</th>
        <th>Sexo</th>
        <th>Imagem</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($pets as $pet): ?>
    <tr>
        <td><?= htmlspecialchars($pet['nome']) ?></td>
        <td><?= htmlspecialchars($pet['raca']) ?></td>
        <td><?= htmlspecialchars($pet['idade']) ?></td>
        <td><?= htmlspecialchars($pet['porte']) ?></td>
        <td><?= htmlspecialchars($pet['peso']) ?></td>
        <td><?= htmlspecialchars($pet['sexo']) ?></td>
        <td>
            <img src="/public/uploads/<?= htmlspecialchars($pet['imagem']) ?>" alt="Imagem do pet" width="150">
        </td>
        <td>
            <a href="/projeto/vetz/update-pet/<?= $pet['id'] ?>">Editar</a>
        <?php if ($pet['tem_vacina']) : ?>
            <a href="/projeto/vetz/delete-pet?id=<?= $pet['id'] ?>"
               onclick="return confirm('Excluir este pet apagará todas as vacinações dele. Quer continuar?');">
               Excluir Pet
            </a>
        <?php else : ?>
            <a href="/projeto/vetz/delete-pet?id=<?= $pet['id'] ?>">Excluir Pet</a>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
<br>
<a href="/projeto/vetz/formulario">Cadastrar novo pet</a>
<a href="/projeto/vetz/cadastrar-vacina">Adicionar Vacina</a>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
