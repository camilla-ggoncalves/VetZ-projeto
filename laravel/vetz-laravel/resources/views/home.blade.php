

@extends('layouts.app')

@section('content')
<!-- Begin Section 01 -->
<section class="section01" id="sec01">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="sec01titleh1">A verdadeira cura começa no respeito pela vida.</h1>
                <div class="col-lg-8 mx-auto">
                    <p class="sec01ph1">Gerencie todas as vacinações dos seus pets em um só lugar. Mantenha o histórico completo e nunca perca uma data importante.</p>
                    <div class="hero-buttons">
                        <a href="{{ route('register') }}" class="btn-hero">
                            <i class="fas fa-user-plus"></i> Começar Gratuitamente
                        </a>
                        <a href="{{ route('login') }}" class="btn-hero-outline">
                            <i class="fas fa-sign-in-alt"></i> Já tenho conta
                        </a>
                    </div>
                </div>
                <div class="product-cards">
                    <!-- Card 1 -->
                    <div class="product-card">
                        <a href="https://lista.mercadolivre.com.br/tapete-higienico-c%C3%A3o-e-gato?sb=all_mercadolibre#D[A:tapete%20higienico%20c%C3%A3o%20e%20gato]" target="_blank">
                            <img src="{{ asset('images/tapete_cao.jpg') }}" alt="Tapete higiênico para cães e gatos" class="product-img">
                            <h2 class="product-title">TAPETE</h2>
                        </a>
                    </div>
                    <!-- Card 2 -->
                    <div class="product-card">
                        <a href="https://lista.mercadolivre.com.br/ra%C3%A7%C3%A3o-c%C3%A3o-e-gato#D[A:ra%C3%A7%C3%A3o%20c%C3%A3o%20e%20gato]" target="_blank">
                            <img src="{{ asset('images/racao_cao.jpg') }}" alt="Ração para cães e gatos" class="product-img">
                            <h2 class="product-title">RAÇÃO</h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Row 1 -->
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-syringe feature-icon"></i>
                    <h4 class="sec01_1titles">Controle de Vacinação</h4>
                    <p class="sec01_01ph2">Mantenha o histórico completo de todas as vacinas dos seus pets, com datas e doses organizadas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-calendar-alt feature-icon"></i>
                    <h4 class="sec01_1titles">Lembretes Automáticos</h4>
                    <p class="sec01_01ph2">Nunca mais esqueça uma vacinação importante com nosso sistema de lembretes personalizados.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-paw feature-icon"></i>
                    <h4 class="sec01_1titles">Multi-Pets</h4>
                    <p class="sec01_01ph2">Gerencie quantos pets quiser em uma única conta. Cães, gatos ou outros animais de estimação.</p>
                </div>
            </div>
        </div>

        <!-- Features Row 2 -->
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-chart-line feature-icon"></i>
                    <h4 class="sec01_1titles">Relatórios Detalhados</h4>
                    <p class="sec01_01ph2">Visualize estatísticas e relatórios completos sobre a saúde preventiva dos seus pets.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-mobile-alt feature-icon"></i>
                    <h4 class="sec01_1titles">Acesso em Qualquer Lugar</h4>
                    <p class="sec01_01ph2">Use em qualquer dispositivo - computador, tablet ou smartphone. Seus dados sempre seguros.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <i class="fas fa-shield-alt feature-icon"></i>
                    <h4 class="sec01_1titles">Dados Seguros</h4>
                    <p class="sec01_01ph2">Seus dados e dos seus pets estão protegidos com a mais alta tecnologia de segurança.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Section 01.1 -->
@endsection
