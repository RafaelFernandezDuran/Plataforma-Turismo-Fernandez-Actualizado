<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chanchamayo Tours - Descubre la Selva Central del Perú</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Preload critical font -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&display=swap" as="style" crossorigin>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/chanchamayo.css') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading" id="loading">
        <div class="loading-spinner"></div>
    </div>

    @include('partials.site-header')

    <!-- Hero Section with Video -->
    <section class="hero">
        <video 
            class="hero-video" 
            id="heroVideo"
            autoplay 
            muted 
            loop 
            playsinline
            preload="metadata"
            disablePictureInPicture
            webkit-playsinline
            x5-playsinline
            aria-label="Video de fondo de Chanchamayo"
        >
            <source src="/videos/hero-background.mp4" type="video/mp4">
            <img 
                src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=1920&h=1080&fit=crop&crop=center" 
                alt="Cascada en la selva de Chanchamayo" 
                style="width: 100%; height: 100%; object-fit: cover;"
                loading="eager"
                decoding="sync"
            >
        </video>
        
        <div class="hero-content container" data-aos="fade-up" data-aos-duration="1500">
            <h1 class="title">
                Descubre la Magia de 
                <br><span class="highlight">Chanchamayo</span>
            </h1>
            <p class="muted">
                La selva central del Perú te espera con aventuras únicas, naturaleza exuberante y experiencias que cambiarán tu vida para siempre.
            </p>
            
            <div class="hero-buttons">
                <a href="/tours" class="btn-hero primary" aria-label="Explorar todos los tours disponibles">
                    <i class="fas fa-compass" aria-hidden="true"></i>
                    Explorar Tours
                </a>
                <a href="{{ route('accommodations.index') }}" class="btn-hero primary outline" aria-label="Ver alojamientos disponibles">
                    <i class="fas fa-bed" aria-hidden="true"></i>
                    Ver Alojamientos
                </a>
                <a href="#video-tour" class="btn-hero ghost" aria-label="Ver video promocional">
                    <i class="fas fa-play" aria-hidden="true"></i>
                    Ver Video Tour
                </a>
            </div>

            <!-- Buscador Pill Flotante -->
            <div class="search-pill" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input 
                    type="text" 
                    placeholder="¿Qué aventura buscas? Ej: Rafting, Cascadas, Café..."
                    aria-label="Buscar tours"
                >
                <button type="submit" class="search-btn" aria-label="Buscar">
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Métricas Compactas -->
            <div class="metrics-grid" data-aos="fade-up" data-aos-delay="600">
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-route" aria-hidden="true"></i>
                    </div>
                    <div class="metric-number counter" data-target="500">0</div>
                    <div class="metric-label">Tours Realizados</div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-users" aria-hidden="true"></i>
                    </div>
                    <div class="metric-number counter" data-target="1200">0</div>
                    <div class="metric-label">Clientes Felices</div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-building" aria-hidden="true"></i>
                    </div>
                    <div class="metric-number counter" data-target="25">0</div>
                    <div class="metric-label">Empresas Locales</div>
                </div>
            </div>
        </div>

        <div class="scroll-indicator" data-aos="fade-up" data-aos-delay="1000">
            <i class="fas fa-chevron-down" aria-hidden="true"></i>
            <p>Desliza para descubrir más</p>
        </div>
    </section>

    <!-- Grid de Categorías -->
    <section id="categorias" class="section">
        <div class="container">
            <div class="text-center" style="margin-bottom: 4rem;" data-aos="fade-up">
                <p class="eyebrow">Aventuras Únicas</p>
                <h2 class="title">Aventuras para Todos los Gustos</h2>
                <p class="muted prose" style="max-width: 600px; margin: 0 auto;">
                    Desde emocionantes deportes de aventura hasta relajantes tours culturales, encuentra tu experiencia perfecta
                </p>
            </div>

            <div class="categories-grid">
                <div class="category-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="category-badge trending">TRENDING</div>
                    <div class="category-icon">
                        <i class="fas fa-water" aria-hidden="true"></i>
                    </div>
                    <h3>Deportes Acuáticos</h3>
                    <p>Rafting, kayak y pesca en los ríos más cristalinos de la selva central</p>
                </div>

                <div class="category-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="category-badge popular">POPULAR</div>
                    <div class="category-icon">
                        <i class="fas fa-mountain" aria-hidden="true"></i>
                    </div>
                    <h3>Aventura Extrema</h3>
                    <p>Canopy, escalada y trekking para los más aventureros</p>
                </div>

                <div class="category-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="category-badge eco">ECO-FRIENDLY</div>
                    <div class="category-icon">
                        <i class="fas fa-leaf" aria-hidden="true"></i>
                    </div>
                    <h3>Naturaleza & Fauna</h3>
                    <p>Observación de aves, caminatas ecológicas y fotografía</p>
                </div>

                <div class="category-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="category-icon">
                        <i class="fas fa-seedling" aria-hidden="true"></i>
                    </div>
                    <h3>Turismo Rural</h3>
                    <p>Granjas de café, vivencias campestres y gastronomía local</p>
                </div>

                <div class="category-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="category-icon">
                        <i class="fas fa-camera" aria-hidden="true"></i>
                    </div>
                    <h3>Turismo Cultural</h3>
                    <p>Historia, tradiciones y artesanías de los pueblos locales</p>
                </div>

                <div class="category-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="category-icon">
                        <i class="fas fa-spa" aria-hidden="true"></i>
                    </div>
                    <h3>Relax & Bienestar</h3>
                    <p>Aguas termales, spas naturales y meditación en la selva</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cards de Tours Destacados -->
    <section class="section" style="background: var(--gris-claro);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 4rem;" data-aos="fade-up">
                <div class="inline-flex items-center gap-3" style="background: linear-gradient(135deg, var(--naranja-atardecer), var(--amarillo-dorado)); color: white; padding: 1rem 2rem; border-radius: 50px; margin-bottom: 2rem;">
                    <i class="fas fa-fire" style="animation: float 2s ease-in-out infinite;" aria-hidden="true"></i>
                    <span class="eyebrow" style="color: white;">¡OFERTAS FLASH!</span>
                    <span id="countdown" class="metric"></span>
                </div>
                <h2 class="title">Tours Destacados de la Semana</h2>
                <p class="muted">Las experiencias más populares seleccionadas por nuestros aventureros</p>
            </div>

            <div class="tours-grid">
                <article class="tour-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="tour-image">
                        <img 
                            src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400" 
                            alt="Rafting extremo en el río Perené"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="tour-eyebrow flash">FLASH SALE -30%</div>
                        <div class="tour-rating">
                            <span class="stars">★★★★★</span> 4.9 (127)
                        </div>
                    </div>
                    <div class="tour-content">
                        <header class="tour-header">
                            <h3 class="tour-title">Rafting Extremo en Río Perené</h3>
                        </header>
                        <p>Desciende los rápidos más emocionantes de la selva central con guías certificados</p>
                        
                        <div class="tour-meta">
                            <span class="tour-chip">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span class="metric">6</span> horas
                            </span>
                            <span class="tour-chip">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                Max <span class="metric">8</span> personas
                            </span>
                            <span class="tour-chip">
                                <i class="fas fa-shield-alt" aria-hidden="true"></i>
                                Seguro incluido
                            </span>
                        </div>
                        
                        <div class="tour-footer">
                            <div class="tour-price">
                                <span style="text-decoration: line-through; color: var(--gris-medio); font-size: 0.9rem;">S/ <span class="metric">280</span></span>
                                <span class="metric" style="font-size: 1.8rem; color: var(--verde-selva);">S/ 196</span>
                                <span style="font-size: 0.8rem; color: var(--gris-medio);">por persona</span>
                            </div>
                            <div class="tour-actions">
                                <button class="btn-heart" aria-label="Agregar a favoritos">
                                    <i class="far fa-heart" aria-hidden="true"></i>
                                </button>
                                <button class="btn-book">
                                    <i class="fas fa-bolt" aria-hidden="true"></i>
                                    Reservar Ahora
                                </button>
                            </div>
                        </div>
                        
                        <div class="tour-urgency">
                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                            Solo quedan <span class="metric">3</span> cupos disponibles
                        </div>
                    </div>
                </article>

                <article class="tour-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="tour-image">
                        <img 
                            src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400" 
                            alt="Catarata El Tirol y Aguas Termales"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="tour-rating">
                            <span class="stars">★★★★★</span> 5.0 (89)
                        </div>
                    </div>
                    <div class="tour-content">
                        <header class="tour-header">
                            <h3 class="tour-title">Catarata El Tirol & Aguas Termales</h3>
                        </header>
                        <p>Combina aventura y relajación en este tour completo por la naturaleza</p>
                        
                        <div class="tour-meta">
                            <span class="tour-chip">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span class="metric">8</span> horas
                            </span>
                            <span class="tour-chip">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                Max <span class="metric">12</span> personas
                            </span>
                            <span class="tour-chip">
                                <i class="fas fa-utensils" aria-hidden="true"></i>
                                Almuerzo incluido
                            </span>
                        </div>
                        
                        <div class="tour-footer">
                            <div class="tour-price">
                                <span class="metric" style="font-size: 1.8rem; color: var(--verde-selva);">S/ 150</span>
                                <span style="font-size: 0.8rem; color: var(--gris-medio);">por persona</span>
                            </div>
                            <div class="tour-actions">
                                <button class="btn-heart" aria-label="Agregar a favoritos">
                                    <i class="far fa-heart" aria-hidden="true"></i>
                                </button>
                                <button class="btn-book">Reservar Ahora</button>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="tour-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="tour-image">
                        <img 
                            src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400" 
                            alt="Ruta del Café Gourmet en Chanchamayo"
                            loading="lazy"
                            decoding="async"
                        >
                        <div class="tour-rating">
                            <span class="stars">★★★★☆</span> 4.8 (34)
                        </div>
                    </div>
                    <div class="tour-content">
                        <header class="tour-header">
                            <h3 class="tour-title">Ruta del Café Gourmet</h3>
                        </header>
                        <p>Descubre el proceso del café desde el grano hasta la taza en fincas locales</p>
                        
                        <div class="tour-meta">
                            <span class="tour-chip">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                <span class="metric">5</span> horas
                            </span>
                            <span class="tour-chip">
                                <i class="fas fa-users" aria-hidden="true"></i>
                                Max <span class="metric">15</span> personas
                            </span>
                            <span class="tour-chip">
                                <i class="fas fa-coffee" aria-hidden="true"></i>
                                Degustación incluida
                            </span>
                        </div>
                        
                        <div class="tour-footer">
                            <div class="tour-price">
                                <span class="metric" style="font-size: 1.8rem; color: var(--verde-selva);">S/ 120</span>
                                <span style="font-size: 0.8rem; color: var(--gris-medio);">por persona</span>
                            </div>
                            <div class="tour-actions">
                                <button class="btn-heart" aria-label="Agregar a favoritos">
                                    <i class="far fa-heart" aria-hidden="true"></i>
                                </button>
                                <button class="btn-book">Reservar Ahora</button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="text-center" style="margin-top: 3rem;">
                <a href="/tours" class="btn-cta" data-aos="fade-up">
                    <i class="fas fa-compass" aria-hidden="true"></i>
                    Ver Todos los Tours
                </a>
            </div>
        </div>
    </section>

    @php
        $accommodations = ($featuredAccommodations ?? collect());
    @endphp

    @if($accommodations->isNotEmpty())
        <section class="section" id="alojamientos" style="background: white;">
            <div class="container">
                <div class="text-center" style="margin-bottom: 3.5rem;" data-aos="fade-up">
                    <p class="eyebrow">Hospédate en la Selva</p>
                    <h2 class="title">Alojamientos Destacados</h2>
                    <p class="muted" style="max-width: 620px; margin: 0 auto;">
                        Descansa en ecolodges, hoteles boutique y casas rurales seleccionadas con las mejores reseñas.
                    </p>
                </div>

                <div class="accommodations-grid">
                    @foreach($accommodations as $accommodation)
                        @php
                            $imagePath = $accommodation->image_url
                                ?? asset('images/piramide-chanchamayo.jpg');
                        @endphp

                        <article class="accommodation-card" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                            <div class="accommodation-image">
                                <img 
                                    src="{{ $imagePath }}" 
                                    alt="Foto del alojamiento {{ $accommodation->name }}"
                                    loading="lazy"
                                    decoding="async"
                                >
                                <div class="accommodation-rating">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <span>{{ number_format($accommodation->rating ?? 0, 1) }}</span>
                                    <small>({{ $accommodation->total_reviews ?? 0 }})</small>
                                </div>
                            </div>

                            <div class="accommodation-content">
                                <h3 class="accommodation-title">{{ $accommodation->name }}</h3>
                                <p class="accommodation-location">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                    {{ $accommodation->city }}, {{ $accommodation->region }}
                                </p>
                                <p class="accommodation-description">
                                    {{ \Illuminate\Support\Str::limit($accommodation->description, 120) }}
                                </p>

                                <div class="accommodation-meta">
                                    <span class="accommodation-price">
                                        <span class="metric">S/ {{ number_format($accommodation->price_per_night, 2) }}</span>
                                        <small>por noche</small>
                                    </span>
                                    <a href="{{ route('accommodations.show', $accommodation) }}" class="btn-book" aria-label="Ver detalles del alojamiento {{ $accommodation->name }}">
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="text-center" style="margin-top: 3rem;">
                    <a href="{{ route('accommodations.index') }}" class="btn-cta" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-bed" aria-hidden="true"></i>
                        Ver todos los alojamientos
                    </a>
                </div>
            </div>
        </section>
    @else
        <section class="section" id="alojamientos">
            <div class="container">
                <div class="empty-state" data-aos="fade-up">
                    <p class="eyebrow">Hospédate en la Selva</p>
                    <h2 class="title">Muy pronto, alojamientos disponibles</h2>
                    <p class="muted" style="max-width: 620px; margin: 0 auto;">
                        Estamos trabajando con empresas locales para mostrarte opciones únicas donde descansar y conectarte con la naturaleza.
                    </p>
                    <a href="{{ route('accommodations.index') }}" class="btn-cta" style="margin-top: 2rem;">
                        Conoce más sobre nuestros alojamientos
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Fila de Logros (Gamificación) -->
    <section class="section cta-section">
        <div class="container text-center">
            <h2 class="title" data-aos="fade-up">
                🏆 Sistema de Logros Aventureros
            </h2>
            <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem; margin-bottom: 3rem;" data-aos="fade-up" data-aos-delay="100">
                Completa tours, escribe reseñas y desbloquea insignias exclusivas
            </p>

            <div class="achievements-container">
                <div class="achievements-grid">
                    <div class="achievement-card" data-aos="zoom-in" data-aos-delay="200">
                        <div class="achievement-icon unlocked">
                            <i class="fas fa-water" aria-hidden="true"></i>
                        </div>
                        <h4 class="achievement-title">Explorador Acuático</h4>
                        <p class="achievement-progress">Completa 3 tours acuáticos</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 66%;"></div>
                        </div>
                        <span class="achievement-progress"><span class="metric">2</span>/<span class="metric">3</span> tours</span>
                    </div>

                    <div class="achievement-card" data-aos="zoom-in" data-aos-delay="300">
                        <div class="achievement-icon unlocked">
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                        <h4 class="achievement-title">Crítico Experto</h4>
                        <p class="achievement-progress">Escribe 10 reseñas detalladas</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 100%;"></div>
                        </div>
                        <span class="achievement-progress">¡COMPLETADO!</span>
                    </div>

                    <div class="achievement-card" data-aos="zoom-in" data-aos-delay="400">
                        <div class="achievement-icon locked">
                            <i class="fas fa-mountain" aria-hidden="true"></i>
                        </div>
                        <h4 class="achievement-title">Conquistador de Cimas</h4>
                        <p class="achievement-progress">Completa 5 tours de montaña</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 20%;"></div>
                        </div>
                        <span class="achievement-progress"><span class="metric">1</span>/<span class="metric">5</span> tours</span>
                    </div>

                    <div class="achievement-card" data-aos="zoom-in" data-aos-delay="500">
                        <div class="achievement-icon locked">
                            <i class="fas fa-coffee" aria-hidden="true"></i>
                        </div>
                        <h4 class="achievement-title">Maestro Cafetero</h4>
                        <p class="achievement-progress">Completa todos los tours de café</p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 0%;"></div>
                        </div>
                        <span class="achievement-progress"><span class="metric">0</span>/<span class="metric">4</span> tours</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="section">
        <div class="container">
            <div class="text-center" style="margin-bottom: 4rem;" data-aos="fade-up">
                <p class="eyebrow">Testimonios Reales</p>
                <h2 class="title">Historias de Aventureros</h2>
                <p class="muted">Más de <span class="metric">1,200</span> viajeros han vivido experiencias únicas en Chanchamayo</p>
            </div>

            <div class="testimonials-grid">
                <article class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-stars">★★★★★</div>
                    <blockquote class="testimonial-quote">
                        "¡Increíble experiencia de rafting! Los guías súper profesionales y la naturaleza espectacular. Definitivamente volveré por más aventuras."
                    </blockquote>
                    <div class="testimonial-author">
                        <img 
                            class="testimonial-avatar" 
                            src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=60&h=60&fit=crop&crop=face" 
                            alt="Foto de perfil de María González"
                        >
                        <div class="testimonial-info">
                            <h4>María González</h4>
                            <span class="verified">✓ Viajero Verificado</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-stars">★★★★★</div>
                    <blockquote class="testimonial-quote">
                        "El tour del café cambió mi perspectiva sobre esta bebida. Aprendí tanto y la experiencia fue auténtica y educativa."
                    </blockquote>
                    <div class="testimonial-author">
                        <img 
                            class="testimonial-avatar" 
                            src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face" 
                            alt="Foto de perfil de Carlos Mendoza"
                        >
                        <div class="testimonial-info">
                            <h4>Carlos Mendoza</h4>
                            <span class="verified">✓ Viajero Verificado</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-stars">★★★★★</div>
                    <blockquote class="testimonial-quote">
                        "Las cataratas son impresionantes y el equipo local hace que te sientas como en familia. Una experiencia que recomiendo 100%."
                    </blockquote>
                    <div class="testimonial-author">
                        <img 
                            class="testimonial-avatar" 
                            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=60&h=60&fit=crop&crop=face" 
                            alt="Foto de perfil de Ana Lucía Torres"
                        >
                        <div class="testimonial-info">
                            <h4>Ana Lucía Torres</h4>
                            <span class="verified">✓ Viajero Verificado</span>
                        </div>
                    </div>
                </article>

                <article class="testimonial-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="testimonial-stars">★★★★★</div>
                    <blockquote class="testimonial-quote">
                        "La organización fue perfecta, desde el transporte hasta la comida. Una experiencia que superó todas mis expectativas."
                    </blockquote>
                    <div class="testimonial-author">
                        <img 
                            src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face" 
                            alt="Foto de perfil de Roberto Silva"
                            class="testimonial-avatar"
                        >
                        <div class="testimonial-info">
                            <h4>Roberto Silva</h4>
                            <span class="verified">✓ Viajero Verificado</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-section">
        <div class="container text-center">
            <div data-aos="zoom-in">
                <h2 class="cta-title">¿Listo para tu Próxima Aventura?</h2>
                <p style="font-size: 1.3rem; margin-bottom: 2rem; opacity: 0.95; max-width: 65ch; margin-inline: auto;">
                    Únete a miles de aventureros que ya descubrieron la magia de Chanchamayo
                </p>
                
                <ul class="cta-benefits">
                    <li>20% OFF en tu primer tour</li>
                    <li>Acceso a la app móvil exclusiva</li>
                    <li>Recomendaciones personalizadas</li>
                    <li>Soporte 24/7 durante tu viaje</li>
                </ul>

                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
                    <a href="/register" class="btn-cta-white">
                        <i class="fas fa-rocket" aria-hidden="true"></i>
                        Comenzar Aventura
                    </a>
                    <a href="/tours" class="btn-cta-white" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                        <i class="fas fa-binoculars" aria-hidden="true"></i>
                        Explorar Tours
                    </a>
                </div>

                <p style="font-size: 0.9rem; margin-top: 2rem; opacity: 0.8;">
                    ⏰ Oferta válida por tiempo limitado • 🔒 Registro 100% seguro • 🚫 Sin compromisos
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer section">
        <div class="container">
            <div class="footer-content">
                <div>
                    <a href="/" class="footer-logo">
                        <i class="fas fa-leaf" aria-hidden="true"></i>
                        Chanchamayo Tours
                    </a>
                    <p class="muted" style="margin-top: 1rem; max-width: 300px;">
                        Descubre la belleza natural de la selva central del Perú con tours auténticos y sostenibles.
                    </p>
                </div>
                
                <div>
                    <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--verde-selva);">Tours</h4>
                    <ul class="footer-links">
                        <li><a href="/tours/aventura">Aventura</a></li>
                        <li><a href="/tours/naturaleza">Naturaleza</a></li>
                        <li><a href="/tours/cultura">Cultura</a></li>
                        <li><a href="/tours/cafe">Ruta del Café</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--verde-selva);">Empresa</h4>
                    <ul class="footer-links">
                        <li><a href="/about">Nosotros</a></li>
                        <li><a href="/empresas">Empresas Asociadas</a></li>
                        <li><a href="/contact">Contacto</a></li>
                        <li><a href="/careers">Trabaja con Nosotros</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--verde-selva);">Legal</h4>
                    <ul class="footer-links">
                        <li><a href="/privacy">Privacidad</a></li>
                        <li><a href="/terms">Términos</a></li>
                        <li><a href="/cookies">Cookies</a></li>
                        <li><a href="/refunds">Reembolsos</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p class="muted">&copy; 2024 Chanchamayo Tours. Todos los derechos reservados.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS with reduced motion support
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        });

        // Loading Screen
        window.addEventListener('load', function() {
            const loading = document.getElementById('loading');
            setTimeout(() => {
                loading.classList.add('fade-out');
            }, 1500);
        });

        // Enhanced Video Handling
        const heroVideo = document.getElementById('heroVideo');
        const hero = document.querySelector('.hero');
        
        if (heroVideo) {
            let videoLoaded = false;
            let playAttempts = 0;
            const maxPlayAttempts = 10;
            
            // Aggressive autoplay function
            function forcePlay() {
                if (playAttempts < maxPlayAttempts) {
                    playAttempts++;
                    heroVideo.play().then(() => {
                        console.log(`✅ Video playing (attempt ${playAttempts})`);
                        videoLoaded = true;
                        heroVideo.style.opacity = '1';
                    }).catch(error => {
                        console.log(`🔄 Attempt ${playAttempts} failed:`, error.message);
                        setTimeout(forcePlay, 500);
                    });
                }
            }

            // Event listeners for video loading
            heroVideo.addEventListener('loadedmetadata', forcePlay);
            heroVideo.addEventListener('canplay', forcePlay);
            
            // Force play on user interaction
            document.addEventListener('click', forcePlay, { once: true });
            document.addEventListener('touchstart', forcePlay, { once: true });

            // Initial play attempt
            setTimeout(forcePlay, 500);
        }

        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 100;
                let current = 0;

                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });
        }

        // Intersection Observer for counters
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(animateCounters, 1000);
                    heroObserver.unobserve(entry.target);
                }
            });
        });

        if (document.querySelector('.hero')) {
            heroObserver.observe(document.querySelector('.hero'));
        }

        // Countdown Timer
        function updateCountdown() {
            const now = new Date().getTime();
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow.setHours(0, 0, 0, 0);
            const distance = tomorrow.getTime() - now;

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                countdownElement.innerHTML = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);

        // Search functionality
        const searchInput = document.querySelector('.search-pill input');
        const searchButton = document.querySelector('.search-btn');

        if (searchInput && searchButton) {
            const handleSearch = (e) => {
                e.preventDefault();
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `/tours?search=${encodeURIComponent(query)}`;
                }
            };

            searchButton.addEventListener('click', handleSearch);
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') handleSearch(e);
            });
        }

        // Wishlist functionality
        document.querySelectorAll('.btn-heart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const icon = this.querySelector('i');
                
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.classList.add('active');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.classList.remove('active');
                }
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Book tour functionality
        document.querySelectorAll('.btn-book').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const tourCard = this.closest('.tour-card');
                const tourTitle = tourCard.querySelector('.tour-title').textContent;
                
                // Here you would typically redirect to booking page
                console.log(`Booking tour: ${tourTitle}`);
                window.location.href = '/tours';
            });
        });
    </script>
</body>
</html>