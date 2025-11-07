<?php 
// $pet — vindo do controller
// $vacinas — vindo do controller
// $usuarioId — vindo da sessão

// Função opcional para calcular idade
function calcularIdade($dataNascimento) {
    $hoje = new DateTime();
    $nasc = new DateTime($dataNascimento);
    return $hoje->diff($nasc)->y;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteira de Vacinação - <?= htmlspecialchars($pet['nome']) ?></title>

    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/images/logo_vetz.svg" rel="shortcut icon">
</head>

<body>

        <body>
                <?php include 'navbar.php'; ?>
                            </span>
                        </button>


<header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a href="/projeto/vetz/homepage">
                    <img class="logomenu" src="/projeto/vetz/views/images/logo_vetz.svg" alt="VET Z">
                </a>

                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto left-menu">
                        <li><a href="/projeto/vetz/homepage">HOME PAGE</a></li>
                        <li><a href="/projeto/vetz/sobre-nos">SOBRE NÓS</a></li>
                        <li><a href="/projeto/vetz/curiosidades">CURIOSIDADES</a></li>
                        <li><a href="/projeto/vetz/recomendacoes">RECOMENDAÇÕES</a></li>

                        <li>
                            <a class="btn btn-menu" href="/projeto/vetz/perfil">
                                <img class="imgperfil" src="/projeto/vetz/views/images/perfil" alt="Perfil">
                                PERFIL
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </nav>
</header>


<!-- ------------------ CONTEÚDO ---------------------- -->

<section class="section07" id="sec07">
    <div class="container07">

        <!-- Informações do Pet -->
        <div class="header-info">
            <div class="pet-photo">🐕</div>

            <h1 class="nome-pet"><?= htmlspecialchars($pet['nome']) ?></h1>

            <p>Tutor: 
                <?= isset($pet['nome_tutor']) ? htmlspecialchars($pet['nome_tutor']) : 'Desconhecido' ?>
            </p>

            <div class="pet-details">

                <div class="pet-detail-item">
                    <span class="pet-detail-label">Raça</span>
                    <span class="pet-detail-value"><?= htmlspecialchars($pet['raca']) ?></span>
                </div>


                <div class="pet-detail-item">
                    <span class="pet-detail-label">Nascimento</span>
                    <span class="pet-detail-value">
                        <?= date("d/m/Y", strtotime($pet['data_nascimento'])) ?>
                    </span>
                </div>

            </div>
        </div>

        <!-- Carteira -->
        <div class="vaccination-card">

            <h2>
                Carteirinha de Vacinação Digital
                <a href="/projeto/vetz/cadastrar-vacina">
                    <button class="edit-btn">✏️ Registrar Vacinas</button>
                </a>
            </h2>

            <div class="age-alert">
                <strong>⏰ Atenção:</strong>
                Confira as vacinas recomendadas para a idade do seu pet.
            </div>


            <!-- Tabela de vacinas -->
            <table class="vaccine-table">
                <thead>
                    <tr>
                        <th>Vacina</th>
                        <th>Doses</th>
                        <th>Aplicação</th>
                        <th>Próxima Dose</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($vacinas)): ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Nenhuma vacinação registrada ainda.
                        </td>
                    </tr>

                <?php else: ?>
                    <?php foreach ($vacinas as $v): ?>

                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($v['nome_vacina']) ?></strong>
                            </td>

                            <td><?= htmlspecialchars($v['doses']) ?></td>

                            <td><?= date("d/m/Y", strtotime($v['data'])) ?></td>

                            <td>
                                <?= date("d/m/Y", strtotime($v['data'] . " + 1 year")) ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>
</section>


<!-- ------------------- FOOTER ----------------------- -->

<div class="footer">
    <div class="container">
        <p class="footerp1">
            Todos os direitos reservados <span id="footer-year"></span> © - VetZ
        </p>
    </div>
</div>

<script src="/projeto/vetz/views/js/jquery-3.3.1.min.js"></script>
<script src="/projeto/vetz/views/js/scripts.js"></script>

<script>
document.getElementById('footer-year').textContent = new Date().getFullYear();
</script>

</body>
</html>
