<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QOSTO - Inicio</title>
    {{-- CSS personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/homep_style.css') }}">
    {{-- Lucide icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div class="home-container">
        <div class="content-wrapper">
            {{-- Barra superior con botón de logout --}}
            <div class="top-bar">
                
            </div>

            {{-- Área de marca --}}
            <div class="brand-area">
                <img src="{{ asset('/css/logo.png') }}" alt="Trabe Ingeniería" class="logo-img">
                <h1 class="main-title">QOSTO</h1>
                <p class="tagline">Tu puerta de acceso a la excelencia en construcción, diseño y arquitectura</p>
            </div>

            {{-- Grid de botones / tarjetas --}}
            <div class="buttons-grid">
                {{-- Cotizaciones --}}
                <a href="{{ route('cotizaciones') }}" class="card" data-path="/cotizaciones">
                    <div class="card-inner">
                        <div class="icon-bg gradient-1">
                            <i data-lucide="file-text" class="icon"></i>
                        </div>
                        <h2 class="card-title">Cotizaciones</h2>
                        <p class="card-desc">Obtén estimados de proyectos</p>
                        <div class="card-footer">
                            <span>Explorar</span>
                            <i data-lucide="arrow-right" class="arrow-icon"></i>
                        </div>
                    </div>
                </a>

                {{-- Proveedores --}}
                <a href="{{ route('proveedores') }}" class="card" data-path="suppliers">
                    <div class="card-inner">
                        <div class="icon-bg gradient-2">
                            <i data-lucide="package" class="icon"></i>
                        </div>
                        <h2 class="card-title">Proveedores</h2>
                        <p class="card-desc">Encuentra socios confiables</p>
                        <div class="card-footer">
                            <span>Explorar</span>
                            <i data-lucide="arrow-right" class="arrow-icon"></i>
                        </div>
                    </div>
                </a>

                {{-- Materiales --}}
                <a href="{{ route('materiales.index') }}" class="card" data-path="materials">
                    <div class="card-inner">
                        <div class="icon-bg gradient-1">
                            <i data-lucide="box" class="icon"></i>
                        </div>
                        <h2 class="card-title">Materiales</h2>
                        <p class="card-desc">Explora productos de calidad</p>
                        <div class="card-footer">
                            <span>Explorar</span>
                            <i data-lucide="arrow-right" class="arrow-icon"></i>
                        </div>
                    </div>
                </a>

                {{-- Mano de Obra --}}
                <a href="{{ route('mano.de.obra') }}" class="card" data-path="labour">
                    <div class="card-inner">
                        <div class="icon-bg gradient-2">
                            <i data-lucide="users" class="icon"></i>
                        </div>
                        <h2 class="card-title">Mano de Obra</h2>
                        <p class="card-desc">Contrata trabajadores calificados</p>
                        <div class="card-footer">
                            <span>Explorar</span>
                            <i data-lucide="arrow-right" class="arrow-icon"></i>
                        </div>
                    </div>
                </a>
                <!-- Clientes -->
                <a href="{{ route('clientes') }}" class="card" data-path="/clientes">
                    <div class="card-inner">
                        <div class="icon-bg gradient-2"> <!-- Puedes usar gradient-1 si no tienes más -->
                            <i data-lucide="users" class="icon"></i>
                        </div>
                        <h2 class="card-title">Clientes</h2>
                        <p class="card-desc">Administra tus clientes</p>
                        <div class="card-footer">
                            <span>Explorar</span>
                            <i data-lucide="arrow-right" class="arrow-icon"></i>
                        </div>
                    </div>
                </a>
                <!-- proyectos -->
                <a href="{{ route('proyectos.index') }}" class="card" data-path="/proyectos">
                    <div class="card-inner">
                        <div class="icon-bg gradient-2"> <!-- Puedes usar gradient-1 si no tienes más -->
                            <i data-lucide="briefcase" class="icon"></i>
                        </div>
                        <h2 class="card-title">Proyectos</h2>
                        <p class="card-desc">Administra tus proyectos</p>
                        <div class="card-footer">
                            <span>Explorar</span>
                            <i data-lucide="arrow-right" class="arrow-icon"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- Inicializar íconos de Lucide --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>