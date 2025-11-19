<?php
session_start();

// Garante que as variáveis sempre existam
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>Adoção - VetZ</title>

    <!-- CSS -->
    <link href="/projeto/vetz/views/css/bootstrap.min.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/style.css" rel="stylesheet">
    <link href="/projeto/vetz/views/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="images/logoPNG.png" rel="shortcut icon">
</head>

    <body>
        <!--Begin Header-->
        <header class="header">
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <nav class="navbar navbar-expand-lg">
        
                        <a href="index.html" rel="home">
                            <img class="logomenu" src="../views/images/logo_vetz.svg" alt="VET Z" title="VetZ">
                        </a>
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <i class="fas fa-bars"></i>
                            </span>
                        </button>
        
                        <div class="navbar-collapse collapse" id="navbarCollapse">
                            <ul class="navbar-nav ml-auto 1  left-menu">
                <ul class="navbar-nav ml-auto 1  left-menu">
                    <li><a href="/projeto/vetz/homepage">HOME PAGE</a></li>
                    <li><a href="/projeto/vetz/sobre-nos">SOBRE NÓS</a></li>
                    <li><a href="/projeto/vetz/curiosidades">CURIOSIDADES</a></li>
                    <li><a href="/projeto/vetz/recomendacoes">RECOMENDAÇÕES</a></li>
                    <li><a href="/projeto/vetz/cadastrar-vacina">VACINAÇÃO</a></li>
                    <li> <a class="btn btn-menu" href="/projeto/vetz/cadastrarForm" role="button">
                    <img class="imgperfil" src="/projeto/vetz/views/images/icone_perfil.png" alt="Perfil"> CADASTRO</a></li>
                </ul>
                            
                        </div>
                    </nav>
                </div> 
            </nav>
        </header>
        <!--End Header-->



        <!-- --------------- CONTEÚDO DA PÁGINA ----------------->

 <!-- Conteúdo Principal -->
        <section class="section08" id="sec08">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        
                <!-- conteudo da pagina começo -->
       
<!-- ================== ESTILO ESPECÍFICO VITdogs ================== -->
<!-- ================== ESTILO ESPECÍFICO VITdogs ================== -->
<style>
  /* Container específico para VITdogs */
  #vitdogs-container { 
    font-family: Arial, sans-serif; 
    background: #f3faed; 
    padding: 20px; 
    border-radius: 8px; 
  }
  #vitdogs-container h1 { 
    text-align: center; 
    color: #ff6f61; 
    margin-bottom: 15px; 
  }
  #vitdogs-container .filters { 
    display: flex; 
    justify-content: center; 
    gap: 10px; 
    flex-wrap: wrap; 
    margin-bottom: 20px; 
  }
  #vitdogs-container select { 
    padding: 5px; 
    font-size: 14px; 
  }

  /* estilos para deixar os selects com visual de botão */
  #vitdogs-container .filters .filter-btn {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  padding: 12px 24px;
  font-size: 15px;
  text-align: center; /* Centraliza o texto */
  border-radius:11,5px; /* 🔹 Bordas menos arredondadas */
  border: 2px solid #038654;
  background: #FEFFEF;
  color: #000;
  cursor: pointer;
  text-transform: uppercase;
  font-family: 'Poppins-Regular', Arial, sans-serif;
  margin: 0 8px;
  position: relative;
  min-width: 180px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  padding-left: 24px;
  padding-right: 24px;
}



  #vitdogs-container .filters .filter-btn:hover {
    border-color: #66bb6a;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-1px);
  }

  /* remove seta padrão no IE/Edge */
  #vitdogs-container .filters .filter-btn::-ms-expand {
    display: none;
  }

  /* Scrollbox para os pets */
  #vitdogs-container .pet-list { 
    display: flex; 
    flex-wrap: wrap; 
    gap: 20px; 
    justify-content: center; 
    max-height: 500px;
    overflow-y: scroll;   /* alterado de auto para scroll */
    padding-right: 10px;
    -ms-overflow-style: none;  /* esconde scrollbar no IE e Edge */
    scrollbar-width: none;     /* esconde scrollbar no Firefox */
  }

  /* Esconde a barra de rolagem no Chrome, Safari e Opera */
  #vitdogs-container .pet-list::-webkit-scrollbar {
    display: none;
  }

  #vitdogs-container .card { 
    background: #fff; 
    border-radius: 8px; 
    box-shadow: 0 2px 6px rgba(0,0,0,0.1); 
    width: 300px; 
    padding: 10px; 
    cursor: pointer; /* 🔹 AGORA É CLICÁVEL */
    transition: transform .2s;
  }
  #vitdogs-container .card:hover {
    transform: scale(1.03);
  }
  #vitdogs-container .card img { 
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
    border-radius: 5px; 
  }
  #vitdogs-container .card h3 { 
    margin: 10px 0 5px 0; 
  }
  #vitdogs-container .card p { 
    margin: 5px 0; 
    font-size: 14px; 
  }
</style>

                        <!-- ================== CONTEÚDO VITdogs ================== -->
                        <div id="vitdogs-container">
                          <div class="filters">
                            <select id="speciesFilter" class="filter-btn btn-menu">
                              <option value="">Todas as espécies</option>
                              <option value="dog">Cachorro</option>
                              <option value="cat">Gato</option>
                            </select>
                            <select id="ageFilter" class="filter-btn btn-menu">
                              <option value="">Todas as idades</option>
                              <option value="baby">Filhote</option>
                              <option value="young">Jovem</option>
                              <option value="adult">Adulto</option>
                              <option value="senior">Idoso</option>
                            </select>
                            <select id="genderFilter" class="filter-btn btn-menu">
                              <option value="">Todos os sexos</option>
                              <option value="male">Macho</option>
                              <option value="female">Fêmea</option>
                            </select>
                          </div>
                          <div class="pet-list" id="petList"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <!-- Begin footer-->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="footerp1">
                            Todos os direitos reservados <span id="footer-year"></span> © 2025 - VetZ </p>
                    </div>

                    <!-- <div class="col-md-1">
                        <p class="instagram">
                            <a><img href="#!" src="images/instagram.svg"></a>
                    </div>
                    <div class="col-md-1">
                        <p class="email">
                            <a><img href="#!" src="images/email.svg"></a>
                    </div> -->
                </div>
            </div>
        </div>
        <!--End footer-->


        <!-- Load JS =============================-->
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery.scrollTo-min.js"></script>
        <script src="js/jquery.nav.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>




<!-- dog -->