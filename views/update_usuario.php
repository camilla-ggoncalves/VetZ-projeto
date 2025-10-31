<?php
$title = "Atualizar Usuário - VetZ";
ob_start();
?>
    <div class="cadastro-box">
        <h2 class="cadastro-title">Atualizar Usuário</h2>
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
    </div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
