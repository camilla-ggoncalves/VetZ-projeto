<?php
require_once '../controllers/VacinacaoController.php';
require_once '../controllers/PetController.php';
require_once '../controllers/UsuarioController.php';

session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';

$vacinacaoController = new VacinacaoController(); // você tinha esquecido de instanciar!
$petController = new PetController();


$id = $_GET['id'] ?? null;
$vacinacao = null;

if ($id && $isLoggedIn) {
    $vacinacao = $vacinacaoController->buscarPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? "Editar Vacinação" : "Cadastrar Vacinação" ?> - VetZ</title>

    <!-- Bootstrap 4 (você já usa) + Font Awesome -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/images/logo_vetz.svg" rel="shortcut icon">

    <style>
        @font-face {
            font-family: 'Poppins-Regular';
            src: url("/projeto/vetz/views/webfonts/Poppins-Regular.ttf");
        }
        @font-face {
            font-family: 'Poppins-Medium';
            src: url("/projeto/vetz/views/webfonts/Poppins-Medium.ttf");
        }
        @font-face {
            font-family: 'Poppins-Bold';
            src: url("/projeto/vetz/views/webfonts/Poppins-Bold.ttf");
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins-Regular', sans-serif;
            background: #FEFFEF;
            min-height: 100vh;
            padding-top: 100px;
        }

        /* ==================== NAVBAR PERFEITA ==================== */
        .navbar {
            background: #FEFFEF;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            padding: 12px 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
            transition: all 0.3s ease;
        }

        .navbar-brand img {
            height: 85px;
            transition: all 0.3s;
        }

        .nav-link {
            color: #000 !important;
            font-family: 'Poppins-Medium';
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 10px 18px !important;
            border-radius: 30px;
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .nav-link:hover {
            color: #038654 !important;
            background: rgba(3, 134, 84, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #038654 !important;
            background: rgba(3, 134, 84, 0.15);
            font-weight: bold;
        }

        /* Botão de perfil lindo */
        .btn-perfil {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8fdf8;
            border: 2px solid #B5E7A0;
            color: #000;
            padding: 8px 20px;
            border-radius: 50px;
            font-family: 'Poppins-Medium';
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-perfil:hover {
            background: #038654;
            color: white !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(3,134,84,0.3);
        }

        .img-perfil {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #B5E7A0;
        }

        /* Responsivo mobile */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: #FEFFEF;
                margin-top: 15px;
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            .navbar-brand img {
                height: 70px;
            }
            body { padding-top: 90px; }
        }

        @media (max-width: 576px) {
            .navbar-brand img { height: 60px; }
            .btn-perfil { padding: 10px 15px; font-size: 14px; }
            .img-perfil { width: 35px; height: 35px; }
        }

        /* ==================== FIM NAVBAR ==================== */

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
            padding: 45px;
            max-width: 650px;
            margin: 40px auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 4px solid #B5E7A0;
        }

        .form-header i {
            font-size: 60px;
            color: #038654;
        }

        h1 {
            color: #038654;
            font-family: 'Poppins-Bold';
            font-size: 32px;
            margin: 15px 0 8px;
        }

        label {
            color: #038654;
            font-family: 'Poppins-Medium';
            font-size: 15px;
            margin-bottom: 8px;
        }

        input, select {
            border: 2px solid #B5E7A0;
            border-radius: 12px;
            padding: 14px 18px;
            background: #f8fdf8;
            transition: all 0.3s;
        }

        input:focus, select:focus {
            border-color: #038654;
            box-shadow: 0 0 0 4px rgba(3,134,84,0.15);
            background: white;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 12 12'%3E%3Cpath fill='%23038654' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 50px;
        }

        button[type="submit"] {
            background: linear-gradient(135deg, #038654 0%, #55974A 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-family: 'Poppins-Bold';
            font-size: 17px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 15px;
            transition: all 0.3s;
        }

        button[type="submit"]:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(3,134,84,0.4);
            background: linear-gradient(135deg, #026d47 0%, #038654 100%);
        }

        .footer {
            background: #B5E7A0;
            color: white;
            text-align: center;
            padding: 18px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 13px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR BONITONA -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/projeto/vetz/homepage">
                <img src="/projeto/vetz/views/images/logo_vetz.svg" alt="VetZ">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <i class="fas fa-bars fa-lg" style="color:#038654;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="/projeto/vetz/homepage">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/projeto/vetz/sobre-nos">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" href="/projeto/vetz/curiosidades">Curiosidades</a></li>
                    <li class="nav-item"><a class="nav-link" href="/projeto/vetz/recomendacoes">Recomendações</a></li>

                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item">
                            <a href="/projeto/vetz/perfil" class="btn-perfil">
                                <img src="/projeto/vetz/views/images/perfil.png" class="img-perfil" alt="Perfil">
                                <span class="d-none d-lg-inline"><?= htmlspecialchars($userName) ?></span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="/projeto/vetz/login" class="btn-perfil">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- FORMULÁRIO -->
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <i class="fas fa-syringe"></i>
                <h1><?= $id ? "Editar Vacinação" : "Cadastrar Vacinação" ?></h1>
                <p style="color:#666; font-size:15px;">Preencha todos os campos com atenção</p>
            </div>

            <form action="/projeto/vetz/salvar-vacina<?= $id ? '?id=' . $id : '' ?>" method="POST">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?= $id ?>">
                <?php endif; ?>

                <div class="form-group mb-4">
                    <label><i class="fas fa-calendar-alt"></i> Data da Aplicação</label>
                    <input type="date" class="form-control" name="data" value="<?= $vacinacao['data'] ?? '' ?>" required>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-prescription-bottle-alt"></i> Número de Doses</label>
                    <input type="number" class="form-control" name="doses" min="1" value="<?= $vacinacao['doses'] ?? '' ?>" required>
                </div>

                <div class="form-group mb-4">
                    <label><i class="fas fa-vial"></i> Tipo de Vacina</label>
                    <select class="form-control" name="id_vacina" required>
                        <option value="">Selecione a vacina</option>
                        <?php foreach ($vacinas as $v): ?>
                            <option value="<?= $v['id_vacina'] ?>" <?= ($vacinacao && $vacinacao['id_vacina'] == $v['id_vacina']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($v['vacina']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mb-5">
                    <label><i class="fas fa-paw"></i> Pet</label>
                    <select class="form-control" name="id_pet" required>
                        <option value="">Selecione o pet</option>
                        <?php foreach ($pets as $pet): ?>
                            <option value="<?= $pet['id'] ?>" <?= ($vacinacao && $vacinacao['id_pet'] == $pet['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pet['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-block">
                    <i class="fas fa-save"></i>
                    <?= $id ? "Atualizar Vacinação" : "Cadastrar Vacinação" ?>
                </button>
            </form>
        </div>
    </div>

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