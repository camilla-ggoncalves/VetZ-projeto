<?php 
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista vacinação - VetZ</title>
    <link rel="stylesheet" href="./style.css">
        <style>
        .header {
            position: relative;
        }

        .navbar {
            padding: 15px 0;
        }

        .navbar .container {
            display: flex;
            align-items: center;
        }

        .navbar .navbar-expand-lg {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logomenu {
            max-height: 50px;
        }

        /* Menu principal */
        .left-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 20px;
        }

        .left-menu li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .left-menu li a:hover {
            color: #007bff;
        }

        /* Menu hamburguer do usuário */
        .user-menu-wrapper {
            position: relative;
        }

        .btn-user-toggle {
            background: none;
            border: 2px solid #333;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-user-toggle:hover {
            background: #333;
            color: white;
        }

        .btn-user-toggle i {
            font-size: 20px;
        }

        /* Dropdown do usuário */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            display: none;
            z-index: 1000;
        }

        .user-dropdown.show {
            display: block;
            animation: fadeInDown 0.3s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-dropdown-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .user-greeting {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .user-dropdown-body {
            padding: 10px 0;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: #333;
            transition: background 0.3s;
            gap: 10px;
        }

        .user-dropdown-item:hover {
            background: #f8f9fa;
        }

        .user-dropdown-item img {
            width: 20px;
            height: 20px;
        }

        .user-dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .user-dropdown-item.logout {
            color: #dc3545;
            border-top: 1px solid #eee;
        }

        .user-dropdown-item.logout:hover {
            background: #ffe6e6;
        }

        /* Responsivo */
        @media (max-width: 991px) {
            .d-none {
                display: none !important;
            }

            .left-menu {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Vacinações Registradas</h1>

    <!-- Link que leva para o formulário de cadastro de uma nova vacinação -->
    <a href="/projeto/vetz/cadastrar-vacina">
        <button>Cadastrar nova vacinação</button>
    </a>

    <!-- Tabela que exibirá os dados das vacinações registradas -->
    <table border="1" cellpadding="10" cellspacing="0"> <!-- Espaçamento entre as células -->
        <thead>
            <tr>
                <!-- Cabeçalho da tabela com os nomes das colunas -->
                <th>Data</th>
                <th>Doses</th>
                <th>Vacina</th>
                <th>Pet</th>
                <th>Tutor</th> 
                <th>Ações</th> <!-- Coluna reservada para os links de editar e excluir -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vacinacoes)) : ?> <!-- Verifica se existe alguma vacinação registrada na variável $vacinacoes -->
                <?php foreach ($vacinacoes as $vacina) : ?> <!-- Loop que percorre cada item (vacinação) do array $vacinacoes -->
                    <tr>
                        <!-- Exibe os dados de cada vacinação de forma segura -->
                        <td><?= htmlspecialchars($vacina['data']) ?></td> <!-- Data da vacinação -->
                        <td><?= htmlspecialchars($vacina['doses']) ?></td> <!-- Quantidade de doses aplicadas -->
                        <td><?= htmlspecialchars($vacina['vacina']) ?></td> <!-- Nome da vacina aplicada -->
                        <td><?= htmlspecialchars($vacina['nome_pet']) ?></td> <!-- Nome do pet que recebeu a vacina -->
                        <td><?= htmlspecialchars($vacina['nome_tutor']) ?></td> <!-- Nome do pet que recebeu a vacina -->
                        <td>
                            <!-- Link para editar a vacinação selecionada, passando o ID da vacina pela URL -->
                            <a href="/projeto/vetz/editar-vacina/<?= $vacina['id'] ?>">Editar</a> |
                            
                            <!-- Link para excluir a vacinação selecionada, com confirmação de exclusão via JavaScript -->
                            <a href="/projeto/vetz/excluir-vacina/<?= $vacina['id'] ?>" 
                               onclick="return confirm('Tem certeza que deseja excluir esta vacinação?');">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?> <!-- Caso não existam vacinações registradas -->
                <tr>
                    <td colspan="6">Nenhuma vacinação registrada.</td> <!-- Mensagem informando que não há dados -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<script>
<!-- Link para excluir a vacinação selecionada, com confirmação de exclusão via JavaScript -->
<a href="/projeto/vetz/excluir-vacina/<?= $vacina['id'] ?>" 
   onclick="return confirm('Tem certeza que deseja excluir esta vacinação?');">
   Excluir
</a>
</script>
</body>
</html>

