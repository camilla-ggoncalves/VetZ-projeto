<?php $pageTitle = 'Videos - VetZ'; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Loader CSS -->
    <style>
        .loader-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            padding: 40px;
        }

        .loader {
            width: 60px;
            height: 60px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #038654;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-text {
            margin-top: 20px;
            color: #666;
            font-size: 16px;
            font-weight: 500;
        }

        .content-hidden {
            display: none !important;
        }
    </style>

    <!-- Conteudo principal -->
    <main>
        <section class="youtube-section">
            <!-- Loader -->
            <div id="videos-loader" class="loader-container">
                <div class="loader"></div>
                <div class="loader-text">Carregando videos...</div>
            </div>

            <!-- Conteudo (inicialmente oculto) -->
            <div id="videos-content" class="content-hidden">
                <h2>Videos</h2>

                <div class="video-buttons">
                    <button class="recentes active">MAIS RECENTES</button>
                    <button class="antigos">MAIS ANTIGOS</button>
                </div>

                <div id="recentes" class="video-grid ativo">
                    <!-- Os videos serao carregados aqui via JavaScript -->
                </div>

                <div id="antigos" class="video-grid">
                    <!-- Os videos serao carregados aqui via JavaScript -->
                </div>
            </div>
        </section>
    </main>

    <!-- Begin footer-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="footerp1">
                        Todos os direitos reservados <span id="footer-year"></span> - VetZ </p>
                </div>
            </div>
        </div>
    </div>
    <!--End footer-->

    <!-- Scripts -->
    <script src="https://apis.google.com/js/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo url('/views/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.scrollTo-min.js'); ?>"></script>
    <script src="<?php echo url('/views/js/jquery.nav.js'); ?>"></script>
    <script src="<?php echo url('/views/js/scripts.js'); ?>"></script>

    <script>
        document.getElementById('footer-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
