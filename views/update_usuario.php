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

$nome = htmlspecialchars($usuario['nome'] ?? '');
$email = htmlspecialchars($usuario['email'] ?? '');
$telefone = htmlspecialchars($usuario['telefone'] ?? '');
$endereco = htmlspecialchars($usuario['endereco'] ?? '');
$nascimento = htmlspecialchars($usuario['nascimento'] ?? '');
$imagem = !empty($usuario['imagem']) ? $usuario['imagem'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - VetZ</title>

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

        .edit-container {
            max-width: 700px;
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

        .edit-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .avatar-preview {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .avatar-preview img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #038654;
            box-shadow: 0 4px 15px rgba(3, 134, 84, 0.2);
            margin-bottom: 15px;
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 4px dashed #ccc;
            color: #999;
            font-size: 48px;
        }

        .btn-remove-photo {
            background: #d32f2f;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            width: 100%;
            text-align: center;
            align-items: center;
            gap: 6px;
        }

        .btn-remove-photo:hover {
            background: #b71c1c;
            transform: translateY(-2px);
        }

        .btn-remove-photo i {
            margin-right: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group label i {
            color: #038654;
            margin-right: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="tel"],
        .form-group input[type="date"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #038654;
            box-shadow: 0 0 0 3px rgba(3, 134, 84, 0.1);
        }

        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        .form-group small {
            display: block;
            margin-top: 5px;
            color: #999;
            font-size: 12px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #038654;
            color: #fff;
        }

        .btn-primary:hover {
            background: #55974A;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(3, 134, 84, 0.3);
            color: #000;
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }

        @media (max-width: 768px) {
            .edit-card {
                padding: 25px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!--Begin Header-->
    <?php include __DIR__ . '/navbar.php'; ?>
    <!--End Header-->

    <div class="edit-container">
        <div class="page-header">
            <h1><i class="fas fa-user-edit"></i> Editar Perfil</h1>
            <p>Atualize suas informações pessoais</p>
        </div>

        <div class="edit-card">
            <div class="avatar-preview">
                <?php if (!empty($imagem)): ?>
                    <img src="<?php echo url('/uploads/' . $imagem); ?>"
                         alt="Avatar"
                         id="avatar-preview">
                <?php else: ?>
                    <div class="avatar-placeholder" id="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?php echo url('/update-usuario/' . $usuario['id']); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                <input type="hidden" name="remover_imagem" id="remover_imagem" value="0">

                <div class="form-group">
                    <label for="nome">
                        <i class="fas fa-user"></i>
                        Nome Completo
                    </label>
                    <input type="text"
                           id="nome"
                           name="nome"
                           value="<?= $nome ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        E-mail
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="<?= $email ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="telefone">
                        <i class="fas fa-phone"></i>
                        Telefone
                    </label>
                    <input type="tel"
                           id="telefone"
                           name="telefone"
                           value="<?= $telefone ?>"
                           placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label for="nascimento">
                        <i class="fas fa-calendar-alt"></i>
                        Data de Nascimento
                    </label>
                    <input type="date"
                           id="nascimento"
                           name="nascimento"
                           value="<?= $nascimento ?>">
                </div>

                <div class="form-group">
                    <label for="endereco">
                        <i class="fas fa-map-marker-alt"></i>
                        Endereço
                    </label>
                    <input type="text"
                           id="endereco"
                           name="endereco"
                           value="<?= $endereco ?>"
                           placeholder="Rua, número, bairro, cidade">
                </div>

                <div class="form-group">
                    <label for="senha">
                        <i class="fas fa-lock"></i>
                        Nova Senha
                    </label>
                    <input type="password"
                           id="senha"
                           name="senha"
                           placeholder="Deixe em branco para manter a senha atual">
                    <small>Preencha apenas se desejar alterar sua senha</small>
                </div>

                <div class="form-group">
                    <label for="imagem">
                        <i class="fas fa-image"></i>
                        Foto de Perfil
                    </label>
                    <input type="file"
                           id="imagem"
                           name="imagem"
                           accept="image/*">
                    <small>Formatos aceitos: JPG, PNG, GIF</small>
                    <?php if (!empty($imagem)): ?>
                        <button type="button" class="btn-remove-photo" id="btn-remove-photo" style="margin-top: 10px;">
                            <i class="fas fa-trash"></i> Remover Foto
                        </button>
                    <?php endif; ?>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                    <a href="<?php echo url('/perfil-usuario'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
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

        // Pre-visualizacao da imagem
        document.getElementById('imagem').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatarPreviewContainer = document.querySelector('.avatar-preview');

                    // Remove placeholder se existir
                    const placeholder = document.getElementById('avatar-placeholder');
                    if (placeholder) {
                        placeholder.remove();
                    }

                    // Remove botao de remover se existir
                    const btnRemove = document.getElementById('btn-remove-photo');
                    if (btnRemove) {
                        btnRemove.remove();
                    }

                    // Cria ou atualiza a imagem
                    let img = document.getElementById('avatar-preview');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'avatar-preview';
                        img.alt = 'Avatar';
                        avatarPreviewContainer.prepend(img);
                    }
                    img.src = e.target.result;

                    // Adiciona botao de remover no form-group da imagem
                    if (!document.getElementById('btn-remove-photo')) {
                        const formGroup = document.getElementById('imagem').closest('.form-group');
                        const btnRemove = document.createElement('button');
                        btnRemove.type = 'button';
                        btnRemove.className = 'btn-remove-photo';
                        btnRemove.id = 'btn-remove-photo';
                        btnRemove.style.marginTop = '10px';
                        btnRemove.innerHTML = '<i class="fas fa-trash"></i> Remover Foto';
                        formGroup.appendChild(btnRemove);

                        // Adiciona evento ao novo botao
                        btnRemove.addEventListener('click', removerFoto);
                    }

                    // Reseta o campo hidden
                    document.getElementById('remover_imagem').value = '0';
                }
                reader.readAsDataURL(file);
            }
        });

        // Funcao para remover foto
        function removerFoto() {
            const avatarPreviewContainer = document.querySelector('.avatar-preview');

            // Remove imagem
            const img = document.getElementById('avatar-preview');
            if (img) {
                img.remove();
            }

            // Remove botao de remover
            const btnRemove = document.getElementById('btn-remove-photo');
            if (btnRemove) {
                btnRemove.remove();
            }

            // Adiciona placeholder
            const placeholder = document.createElement('div');
            placeholder.className = 'avatar-placeholder';
            placeholder.id = 'avatar-placeholder';
            placeholder.innerHTML = '<i class="fas fa-user"></i>';
            avatarPreviewContainer.prepend(placeholder);

            // Limpa input file
            document.getElementById('imagem').value = '';

            // Marca para remover no servidor
            document.getElementById('remover_imagem').value = '1';
        }

        // Adiciona evento ao botao de remover se ele existir
        const btnRemoveExistente = document.getElementById('btn-remove-photo');
        if (btnRemoveExistente) {
            btnRemoveExistente.addEventListener('click', removerFoto);
        }
    </script>

</body>
</html>
