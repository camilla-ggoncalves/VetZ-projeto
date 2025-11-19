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
        <!--Begin Header-->
        <?php include __DIR__ . '/navbar.php'; ?>
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