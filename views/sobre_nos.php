<?php $pageTitle = 'Sobre Nos - VetZ'; ?>
<?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Conteudo da Pagina -->

    <!-- Begin Section 02 -->
    <section class="section02" id="sec02">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h1 class="sec02titleh1">Bem-vindos!</h1>
                    <p class="sec02ph1">
                        Somos um grupo de estudantes do 3º ano do ensino medio, com foco em veterinaria e zootecnia. Nosso projeto, "Vetz", busca explorar de forma inovadora a relacao entre os animais, a saude deles e a acessibilidade.
                        com foco em areas como comportamento animal, controle de vacinacao e praticas de cuidado, unindo conhecimento e sensibilidade para transformar a forma como lidamos com os nossos animais.
                        Nosso objetivo e contribuir para o bem-estar dos animais, de forma que possamos juntar o carinho e cuidado por eles no VetZ.
                    </p>
                </div>
                <div class="col-md-5 text-center">
                    <img src="<?php echo url('/views/images/logo_vetz_2.png'); ?>" alt="Logo VetZ" class="img-fluid" style="max-width: 350px;">
                </div>
            </div>
        </div>
    </section>
    <!-- End Section 02 -->

    <!-- Begin Section 03 -->
    <section class="section03" id="sec03">
        <div class="container">
            <h2 class="sec03titleh2">Integrantes do Projeto</h2>

            <!-- Container para a primeira linha -->
            <div class="grid-container-line1">
                <div class="grid-item">
                    <img src="<?php echo url('/views/images/camilla_foto.png'); ?>" class="card-img-top" alt="Camilla">
                    <p class="sec03phinte">CAMILLA GARCEZ</p>
                </div>
                <div class="grid-item">
                    <img src="<?php echo url('/views/images/marcela_foto.jpg'); ?>" class="card-img-top" alt="Marcela">
                    <p class="sec03phinte">MARCELA SANCHES</p>
                </div>
                <div class="grid-item">
                    <img src="<?php echo url('/views/images/isadora_foto.png'); ?>" class="card-img-top" alt="Isadora">
                    <p class="sec03phinte">ISADORA MOREIRA</p>
                </div>
            </div>

            <!-- Container para a segunda linha -->
            <div class="grid-container-line2">
                <div class="grid-item-img1">
                    <img src="<?php echo url('/views/images/victor_hugo_foto.png'); ?>" class="card-img-top" alt="Victor">
                    <p class="sec03phinte">VICTOR M.</p>
                </div>
                <div class="grid-item-img2z">
                    <img src="<?php echo url('/views/images/alexandre_foto.jpeg'); ?>" class="card-img-top" alt="Guilherme">
                    <p class="sec03phinte">GUILHERME A.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Section 03 -->

<?php include __DIR__ . '/includes/footer.php'; ?>