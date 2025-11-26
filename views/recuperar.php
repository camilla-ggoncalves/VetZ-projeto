<?php
require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - VetZ</title>

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
            background: linear-gradient(135deg, #B5E7A0 0%, #86C67C 100%);
            font-family: 'Poppins', Arial, sans-serif;
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

        .recovery-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .recovery-card {
            background: #fff;
            border-radius: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            padding: 50px 40px;
            max-width: 480px;
            width: 100%;
            position: relative;
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .recovery-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .recovery-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #B5E7A0, #86C67C);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(3, 134, 84, 0.3);
        }

        .recovery-icon i {
            font-size: 40px;
            color: #fff;
        }

        .recovery-header h1 {
            color: #038654;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .recovery-header p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #038654;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group label i {
            margin-right: 5px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #038654;
            box-shadow: 0 0 0 4px rgba(3, 134, 84, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #B5E7A0, #86C67C);
            color: #038654;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(3, 134, 84, 0.4);
            color: #000;
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }


        .back-to-login {
            text-align: center;
            margin-top: 25px;
        }

        .back-to-login a {
            color: #038654;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s;
        }

        .back-to-login a:hover {
            color: #55974A;
            gap: 8px;
        }

        .message {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }

        .message-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #038654;
        }

        .message-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .code-display {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px 15px;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 14px;
            color: #856404;
            text-align: center;
            font-weight: 600;
        }

        /* Modal Popup */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            max-width: 450px;
            width: 90%;
            position: relative;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close:hover {
            color: #333;
            transform: rotate(90deg);
        }

        .modal-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .modal-header h3 {
            color: #038654;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal-header p {
            color: #666;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .recovery-card {
                padding: 35px 25px;
            }

            .recovery-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="recovery-container">
        <div class="recovery-card">
            <div class="recovery-header">
                <div class="recovery-icon">
                    <i class="fas fa-key"></i>
                </div>
                <h1>Recuperar Senha</h1>
                <p>Digite seu e-mail cadastrado e enviaremos um código para redefinir sua senha</p>
            </div>

            <form id="form-email">
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        E-mail
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="form-control"
                           placeholder="seu@email.com"
                           required>
                </div>

                <button type="submit" class="btn-submit" id="btn-enviar">
                    <i class="fas fa-paper-plane"></i> Enviar Código
                </button>
            </form>

            <div id="msg-email"></div>

            <div class="back-to-login">
                <a href="<?php echo url('/loginForm'); ?>">
                    <i class="fas fa-arrow-left"></i> Voltar para o Login
                </a>
            </div>
        </div>
    </div>

    <!-- Modal para digitar código -->
    <div id="popup-codigo" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="fecharPopup()">&times;</button>

            <div class="modal-header">
                <h3>Digite o Código</h3>
                <p>Insira o código recebido no seu e-mail e defina uma nova senha</p>
            </div>

            <form id="form-codigo">
                <input type="hidden" name="email" id="popup-email">

                <div class="form-group">
                    <label for="codigo">
                        <i class="fas fa-lock"></i>
                        Código de Verificação
                    </label>
                    <input type="text"
                           name="codigo"
                           id="codigo"
                           class="form-control"
                           placeholder="Digite o código"
                           required>
                </div>

                <div class="form-group">
                    <label for="nova_senha">
                        <i class="fas fa-key"></i>
                        Nova Senha
                    </label>
                    <input type="password"
                           name="nova_senha"
                           id="nova_senha"
                           class="form-control"
                           placeholder="Digite sua nova senha"
                           required>
                </div>

                <button type="submit" class="btn-submit" id="btn-trocar">
                    <i class="fas fa-check"></i> Alterar Senha
                </button>
            </form>

            <div id="msg-codigo"></div>
            <div id="codigo-teste-modal"></div>
        </div>
    </div>


    <!-- Modal de sucesso -->
    <div id="popup-sucesso" class="modal-overlay">
        <div class="modal-content" style="text-align: center;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #B5E7A0, #86C67C); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fas fa-check" style="font-size: 40px; color: #fff;"></i>
            </div>
            <h3 style="color: #038654; margin-bottom: 15px;">Senha Alterada!</h3>
            <p style="color: #666; margin-bottom: 25px;">Sua senha foi redefinida com sucesso.</p>
            <button onclick="fecharPopupSucesso()" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Fazer Login
            </button>
        </div>
    </div>

    <!-- Footer -->
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

    <!-- Scripts -->
    <script src="<?php echo url('/views/js/jquery-3.3.1.min.js'); ?>"></script>
    <script>
        document.getElementById('footer-year').textContent = new Date().getFullYear();

        function fecharPopup() {
            document.getElementById('popup-codigo').style.display = 'none';
        }

        function fecharPopupSucesso() {
            window.location.href = "<?php echo url('/loginForm'); ?>";
        }

        // Envio do e-mail
        document.getElementById('form-email').onsubmit = function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const btn = document.getElementById('btn-enviar');
            const msgDiv = document.getElementById('msg-email');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

            fetch('<?php echo url('/enviarCodigo'); ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'email=' + encodeURIComponent(email)
            })
            .then(r => r.text())
            .then(codigo => {
                msgDiv.innerHTML = '<div class="message message-success"><i class="fas fa-check-circle"></i> Código enviado para o e-mail!</div>';
                document.getElementById('popup-email').value = email;
                document.getElementById('popup-codigo').style.display = 'flex';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Código';

                // Exibe código para teste dentro do modal (remover em produção)
                document.getElementById('codigo-teste-modal').innerHTML = '<div class="code-display"><i class="fas fa-info-circle"></i> Código de teste: ' + codigo + '</div>';
            })
            .catch(() => {
                msgDiv.innerHTML = '<div class="message message-error"><i class="fas fa-exclamation-circle"></i> Erro ao enviar código. Verifique o e-mail.</div>';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar Código';
            });
        };

        // Verificação do código e troca de senha
        document.getElementById('form-codigo').onsubmit = function(e) {
            e.preventDefault();
            const form = this;
            const dados = new FormData(form);
            const btn = document.getElementById('btn-trocar');
            const msgDiv = document.getElementById('msg-codigo');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verificando...';

            fetch('<?php echo url('/verificarCodigo'); ?>', {
                method: 'POST',
                body: new URLSearchParams([...dados])
            })
            .then(r => r.text())
            .then(msg => {
                if (msg.includes('sucesso')) {
                    fecharPopup();
                    document.getElementById('popup-sucesso').style.display = 'flex';
                } else {
                    msgDiv.innerHTML = '<div class="message message-error"><i class="fas fa-exclamation-circle"></i> ' + msg + '</div>';
                }
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check"></i> Alterar Senha';
            })
            .catch(() => {
                msgDiv.innerHTML = '<div class="message message-error"><i class="fas fa-exclamation-circle"></i> Erro ao redefinir senha.</div>';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check"></i> Alterar Senha';
            });
        };
    </script>

</body>
</html>
