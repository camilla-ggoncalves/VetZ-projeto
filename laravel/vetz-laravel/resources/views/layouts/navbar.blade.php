<!-- layouts/navbar.blade.php -->
<header class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a href="/" rel="home">
                    <img class="logomenu" src="{{ asset('images/logo_vetz.svg') }}" alt="VET Z" title="VetZ">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fas fa-bars"></i>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ml-auto left-menu">
                        <li><a href="/">HOME PAGE</a></li>
                        <li><a href="/sobre-nos">SOBRE NÓS</a></li>
                        <li><a href="/curiosidades">CURIOSIDADES</a></li>
                        <li><a href="/vacinacao">VACINAÇÃO</a></li>
                        <li>
                            @guest
                                <a href="/register" class="btn btn-menu" role="button">
                                    <span class="perfil-emoji" title="Perfil">👤</span>
                                    CADASTRO
                                </a>
                            @else
                                <a href="/profile" class="btn btn-menu" role="button">
                                    <img class="imgperfil" src="{{ asset('images/perfil') }}" alt="Perfil">
                                    PERFIL
                                </a>
                            @endguest
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </nav>
</header>
