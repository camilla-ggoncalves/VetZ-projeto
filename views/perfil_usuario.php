<?php
require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';

if (!$isLoggedIn) {
    redirect('/loginForm');
    exit;
}

if (!isset($usuario) || empty($usuario)) {
    echo "Usuário não encontrado.";
    exit;
}

$nome  = htmlspecialchars($usuario['nome'] ?? 'N/A');
$email = htmlspecialchars($usuario['email'] ?? 'N/A');
$telefone = htmlspecialchars($usuario['telefone'] ?? 'Não informado');
$endereco = htmlspecialchars($usuario['endereco'] ?? 'Não informado');
$nascimento = htmlspecialchars($usuario['nascimento'] ?? 'Não informado');
$imagem = !empty($usuario['imagem']) ? $usuario['imagem'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - VetZ</title>

    <!-- CSS -->
    <link href="<?php echo url('/views/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo url('/views/css/navbar.css'); ?>" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?php echo url('/views/images/logo_vetz.svg'); ?>">
    <link rel="alternate icon" type="image/png" href="<?php echo url('/views/images/logoPNG.png'); ?>">

    <style>
        body {
            background: #f8fdf8;
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            flex-shrink: 0;
        }

        .footer {
            flex-shrink: 0;
            margin-top: auto;
        }

        .profile-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
            flex: 1;
        }

        .page-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: #038654;
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
            font-size: 13px;
        }

        .profile-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .profile-header-section {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }

        .avatar-container {
            position: relative;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #038654;
            box-shadow: 0 4px 15px rgba(3, 134, 84, 0.2);
        }

        .user-info-header {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .user-name {
            font-size: 28px;
            font-weight: bold;
            color: #038654;
            margin-bottom: 5px;
        }

        .user-role {
            display: inline-block;
            background: #B5E7A0;
            color: #038654;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .user-email {
            color: #666;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-section {
            margin-top: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #038654;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            text-align: left;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .info-value {
            font-size: 15px;
            color: #333;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value i {
            color: #038654;
            font-size: 14px;
        }

        .btn-edit-profile {
            background: #038654;
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-edit-profile:hover {
            background: #55974A;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(3, 134, 84, 0.3);
            color: #fff;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .profile-header-section {
                flex-direction: column;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                padding: 25px;
            }

            .avatar {
                width: 100px;
                height: 100px;
            }

            .user-name {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <div class="profile-container">
        <div class="page-header">
            <h1><i class="fas fa-user-circle"></i> Meu Perfil</h1>
            <p>Visualize e gerencie suas informações pessoais</p>
        </div>

        <div class="profile-card">
            <div class="profile-header-section">
                <?php if (!empty($imagem)): ?>
                    <div class="avatar-container">
                        <img src="<?php echo url('/uploads/' . $imagem); ?>" alt="Foto do usuário" class="avatar">
                    </div>
                <?php endif; ?>
                <div class="user-info-header">
                    <div class="user-name"><?= $nome ?></div>
                    <span class="user-role"><i class="fas fa-user"></i> Tutor</span>
                    <div class="user-email">
                        <i class="fas fa-envelope"></i>
                        <?= $email ?>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Informações Pessoais
                </h3>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nome Completo</span>
                        <span class="info-value">
                            <i class="fas fa-user"></i>
                            <?= $nome ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">E-mail</span>
                        <span class="info-value">
                            <i class="fas fa-envelope"></i>
                            <?= $email ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Telefone</span>
                        <span class="info-value">
                            <i class="fas fa-phone"></i>
                            <?= $telefone ?>
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Data de Nascimento</span>
                        <span class="info-value">
                            <i class="fas fa-calendar-alt"></i>
                            <?= $nascimento != 'Não informado' ? date('d/m/Y', strtotime($nascimento)) : $nascimento ?>
                        </span>
                    </div>

                    <div class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Endereço</span>
                        <span class="info-value">
                            <i class="fas fa-map-marker-alt"></i>
                            <?= $endereco ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="<?php echo url('/update-usuario/' . $usuario['id']); ?>" class="btn-edit-profile">
                    <i class="fas fa-edit"></i> Editar Perfil
                </a>
            </div>
        </div>
    </div>

    <!-- Begin footer-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="footerp1">
                        Todos os direitos reservados <span id="footer-year"></span> - VetZ
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!--End footer-->

    <!-- Load JS =============================-->
    <script src="<?php echo url('/views/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.scrollTo-min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.nav.js'); ?>"></script>
    <script src="<?php echo url('/views/js/scripts.js'); ?>"></script>

    <script>
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>

</body>
</html>
