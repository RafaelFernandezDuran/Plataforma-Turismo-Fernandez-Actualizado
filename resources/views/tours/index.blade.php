<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours | Chanchamayo Tours</title>
    <meta name="description" content="Descubre experiencias únicas en Chanchamayo. Explora tours de aventura, cultura y naturaleza seleccionados para ti.">
    <meta property="og:title" content="Explora los mejores tours en Chanchamayo">
    <meta property="og:description" content="Planea tu próxima aventura con nuestra selección curada de tours inolvidables en Chanchamayo.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7cVUDTyh13jRaYf0cwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="{{ asset('css/chanchamayo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tours-fixed.css') }}">
</head>
@php
    $searchTerm = request('search');
    $activeFilters = collect([
        'search' => $searchTerm,
        'category' => request('category'),
        'price_max' => request('price_max'),
        'duration' => request('duration'),
        'difficulty' => request('difficulty'),
    ])->filter();
    $categoryName = $categories->firstWhere('slug', request('category'))?->name;
    $durationMap = [
        '1' => '1 día',
        '2' => '2 días',
        '3' => '3 días',
        '4' => '4+ días',
    ];
@endphp
<body class="tours-page page-with-navbar">
    @include('partials.site-header')

    <main>
        <section class="hero" id="experiencias">
            <div class="container hero-grid">
                <div class="hero-content">
                    <div class="hero-pretitle">Explora Chanchamayo</div>
                    <h1 class="hero-title">Tu próxima aventura comienza aquí</h1>
                    <p class="hero-description">
                        Encuentra tours diseñados por expertos locales, con rutas seguras, experiencias auténticas y la mejor selección de operadores certificados.
                    </p>
                    <div class="hero-metrics">
                        <div class="metric-card">
                            <span class="metric-value">{{ number_format($tours->total()) }}</span>
                            <span class="metric-label">Tours activos</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-value">{{ $categories->count() }}</span>
                            <span class="metric-label">Categorías</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-value">4.8</span>
                            <span class="metric-label">Satisfacción promedio</span>
                        </div>
                    </div>
                </div>

                <div class="hero-search">
                    <form method="GET" class="search-form" aria-label="Buscador de tours">
                        <label for="search-input" class="search-label">¿Qué experiencia buscas?</label>
                        <div class="search-input-wrapper">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input id="search-input" name="search" type="search" value="{{ $searchTerm }}" placeholder="Selva, rafting, café, cascadas..." autocomplete="off">
                            @if($activeFilters->isNotEmpty())
                                <button type="button" class="search-clear" aria-label="Limpiar búsqueda" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                        <div class="search-hints" id="search-hints" aria-live="polite">
                            <span class="search-hint">Aventura</span>
                            <span class="search-hint">Cataratas</span>
                            <span class="search-hint">Café</span>
                            <span class="search-hint">Selva</span>
                        </div>
                        <button type="submit" class="btn btn-primary search-submit">
                            <span>Buscar tours</span>
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </form>
                    <div class="trust-badges" aria-label="Beneficios principales">
                        <div class="trust-item"><i class="fas fa-shield-alt"></i> Operadores verificados</div>
                        <div class="trust-item"><i class="fas fa-leaf"></i> Turismo responsable</div>
                        <div class="trust-item"><i class="fas fa-headset"></i> Soporte 24/7</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="filters-section" aria-label="Filtros de búsqueda">
            <div class="container">
                <div class="filters-header">
                    <div class="filters-title">
                        <i class="fas fa-sliders-h" aria-hidden="true"></i>
                        <div>
                            <h2>Personaliza tu experiencia</h2>
                            <p>Refina los resultados según tus intereses y presupuesto</p>
                        </div>
                    </div>
                    <button class="filter-toggle" aria-expanded="false" aria-controls="filters-form">
                        <span>Filtros</span>
                        <span class="filter-count" id="active-filters-count"></span>
                        <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                </div>

                @if($activeFilters->isNotEmpty())
                    <div class="active-filters" role="status" aria-live="polite">
                        <span class="active-filters-label">Filtros aplicados:</span>
                        @if($searchTerm)
                            <span class="filter-chip">
                                <i class="fas fa-search"></i>
                                "{{ $searchTerm }}"
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="filter-chip-remove" aria-label="Quitar filtro de búsqueda">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="filter-chip">
                                <i class="fas fa-tag"></i>
                                {{ $categoryName ?? ucfirst(request('category')) }}
                                <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="filter-chip-remove" aria-label="Quitar filtro de categoría">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('price_max'))
                            <span class="filter-chip">
                                <i class="fas fa-wallet"></i>
                                Hasta S/ {{ number_format((int) request('price_max')) }}
                                <a href="{{ request()->fullUrlWithQuery(['price_max' => null]) }}" class="filter-chip-remove" aria-label="Quitar filtro de precio">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('duration'))
                            <span class="filter-chip">
                                <i class="fas fa-clock"></i>
                                {{ $durationMap[request('duration')] ?? request('duration').' días' }}
                                <a href="{{ request()->fullUrlWithQuery(['duration' => null]) }}" class="filter-chip-remove" aria-label="Quitar filtro de duración">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('difficulty'))
                            <span class="filter-chip">
                                <i class="fas fa-signal"></i>
                                {{ ucfirst(request('difficulty')) }}
                                <a href="{{ request()->fullUrlWithQuery(['difficulty' => null]) }}" class="filter-chip-remove" aria-label="Quitar filtro de dificultad">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif
                        <button class="clear-all-filters" onclick="window.location.href='{{ route('tours.index') }}'">
                            <i class="fas fa-times-circle"></i>
                            Limpiar todo
                        </button>
                    </div>
                @endif

                <form method="GET" class="filters-form" id="filters-form">
                    <input type="hidden" name="search" value="{{ $searchTerm }}">
                    <div class="filter-grid">
                        <div class="filter-group">
                            <label for="category-select" class="filter-label">Categoría</label>
                            <div class="select-wrapper">
                                <select name="category" id="category-select" class="filter-select">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label class="filter-label" for="priceSlider">Precio máximo (S/)</label>
                            <div class="price-slider">
                                <div class="price-input">
                                    <input type="range" id="priceSlider" name="price_range" min="0" max="500" step="10" value="{{ request('price_max', 250) }}" aria-describedby="priceValue">
                                    <div class="price-rail">
                                        <span>S/ 0</span>
                                        <span>S/ 500+</span>
                                    </div>
                                </div>
                                <div class="price-display">
                                    <span>Hasta</span>
                                    <strong id="priceValue">S/ {{ request('price_max', 250) }}</strong>
                                </div>
                                <input type="hidden" name="price_max" id="priceMaxInput" value="{{ request('price_max') }}">
                            </div>
                        </div>

                        <div class="filter-group">
                            <label for="duration-select" class="filter-label">Duración</label>
                            <div class="select-wrapper">
                                <select name="duration" id="duration-select" class="filter-select">
                                    <option value="">Cualquier duración</option>
                                    <option value="1" {{ request('duration') === '1' ? 'selected' : '' }}>1 día</option>
                                    <option value="2" {{ request('duration') === '2' ? 'selected' : '' }}>2 días</option>
                                    <option value="3" {{ request('duration') === '3' ? 'selected' : '' }}>3 días</option>
                                    <option value="4" {{ request('duration') === '4' ? 'selected' : '' }}>4+ días</option>
                                </select>
                                <i class="fas fa-chevron-down" aria-hidden="true"></i>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label for="difficulty-select" class="filter-label">Dificultad</label>
                            <div class="select-wrapper">
                                <select name="difficulty" id="difficulty-select" class="filter-select">
                                    <option value="">Todos los niveles</option>
                                    <option value="easy" {{ request('difficulty') === 'easy' ? 'selected' : '' }}>Fácil</option>
                                    <option value="moderate" {{ request('difficulty') === 'moderate' ? 'selected' : '' }}>Moderado</option>
                                    <option value="hard" {{ request('difficulty') === 'hard' ? 'selected' : '' }}>Difícil</option>
                                    <option value="expert" {{ request('difficulty') === 'expert' ? 'selected' : '' }}>Experto</option>
                                </select>
                                <i class="fas fa-chevron-down" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter" aria-hidden="true"></i>
                            Aplicar filtros
                        </button>
                        <a href="{{ route('tours.index') }}" class="btn btn-ghost">
                            <i class="fas fa-rotate-left" aria-hidden="true"></i>
                            Restablecer
                        </a>
                    </div>
                </form>
            </div>
        </section>

        <section class="tours-grid-section" role="main" aria-label="Resultados de tours">
            <div class="container">
                <div class="section-header">
                    <div class="results-info">
                        <h2 class="results-title">
                            @if($searchTerm)
                                Resultados para <em>{{ $searchTerm }}</em>
                            @else
                                Tours disponibles
                            @endif
                        </h2>
                        <span class="results-count" aria-live="polite">{{ $tours->total() }} tour{{ $tours->total() !== 1 ? 's' : '' }} encontrado{{ $tours->total() !== 1 ? 's' : '' }}</span>
                    </div>
                    <div class="sort-control">
                        <label for="sort-select" class="sort-label">Ordenar por</label>
                        <div class="select-wrapper">
                            <select id="sort-select" name="sort" class="sort-select">
                                <option value="featured" {{ request('sort', 'featured') === 'featured' ? 'selected' : '' }}>Destacados</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                <option value="duration_asc" {{ request('sort') === 'duration_asc' ? 'selected' : '' }}>Duración: Corta a Larga</option>
                                <option value="duration_desc" {{ request('sort') === 'duration_desc' ? 'selected' : '' }}>Duración: Larga a Corta</option>
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Más recientes</option>
                            </select>
                            <i class="fas fa-chevron-down" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                @if($tours->count() > 0)
                    <div class="tours-grid" role="list" data-tours-count="{{ $tours->count() }}">
                        @foreach($tours as $tour)
                            @php
                                $category = $tour->category;
                                $company = $tour->company;
                                $rating = rand(36, 50) / 10;
                                $fullStars = floor($rating);
                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                $resolvedCategoryName = optional($category)->name;
                                $resolvedCategoryIcon = optional($category)->icon;
                                $resolvedCompanyName = optional($company)->name;
                            @endphp
                            <article class="tour-card" role="listitem">
                                <div class="tour-card-media">
                                    @if($tour->optimized_image)
                                        <img src="{{ $tour->optimized_image }}" alt="{{ $tour->title }}" class="tour-image" loading="lazy" onerror="handleImageError(this)">
                                    @else
                                        <div class="tour-image-placeholder">
                                            <i class="fas {{ $resolvedCategoryIcon ?: 'fa-mountain' }}" aria-hidden="true"></i>
                                            <span>{{ $resolvedCategoryName ?: 'Aventura' }}</span>
                                        </div>
                                    @endif
                                    <div class="tour-badges" aria-label="Destacados del tour">
                                        @if($tour->is_featured)
                                            <span class="badge badge-featured"><i class="fas fa-star" aria-hidden="true"></i> Destacado</span>
                                        @endif
                                        @if($tour->discount_percentage)
                                            <span class="badge badge-discount"><i class="fas fa-tag" aria-hidden="true"></i> -{{ $tour->discount_percentage }}%</span>
                                        @endif
                                        <span class="badge badge-difficulty badge-{{ $tour->difficulty_level }}">
                                            <i class="fas fa-signal" aria-hidden="true"></i>
                                            {{ strtoupper($tour->difficulty_level) }}
                                        </span>
                                    </div>
                                    <div class="tour-quick-actions" aria-label="Acciones rápidas">
                                        <button class="action-btn favorite-btn" data-tour-id="{{ $tour->id }}" aria-label="Agregar {{ $tour->title }} a favoritos"><i class="far fa-heart"></i></button>
                                        <button class="action-btn share-btn" data-tour-slug="{{ $tour->slug }}" aria-label="Compartir {{ $tour->title }}"><i class="fas fa-share-alt"></i></button>
                                    </div>
                                </div>
                                <div class="tour-card-content">
                                    <div class="tour-card-header">
                                        <span class="tour-category"><i class="fas fa-tag"></i> {{ $resolvedCategoryName ?: 'Sin categoría' }}</span>
                                        <div class="tour-rating" aria-label="Calificación promedio {{ number_format($rating, 1) }}">
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $fullStars)
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i === $fullStars + 1 && $hasHalfStar)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="rating-score">{{ number_format($rating, 1) }}</span>
                                            <span class="rating-count">({{ rand(18, 95) }} reseñas)</span>
                                        </div>
                                    </div>

                                    <h3 class="tour-title">
                                        <a href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                                    </h3>

                                    <p class="tour-description">{{ Str::limit($tour->description, 140) }}</p>

                                    <ul class="tour-attributes" aria-label="Detalles del tour">
                                        <li>
                                            <i class="fas fa-clock" aria-hidden="true"></i>
                                            <span>{{ $tour->duration_days }} día{{ $tour->duration_days !== 1 ? 's' : '' }} • {{ $tour->duration_hours }} hora{{ $tour->duration_hours !== 1 ? 's' : '' }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-users" aria-hidden="true"></i>
                                            <span>{{ $tour->min_participants }}-{{ $tour->max_participants }} personas</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-building" aria-hidden="true"></i>
                                            <span>{{ $resolvedCompanyName ?: 'Operador certificado' }}</span>
                                        </li>
                                    </ul>

                                    <div class="tour-card-footer">
                                        <div class="tour-price">
                                            <span class="price-label">Desde</span>
                                            <span class="price-value">S/ {{ number_format($tour->price, 0) }}</span>
                                            <span class="price-note">por persona</span>
                                        </div>
                                        <div class="tour-actions-group">
                                            <button class="btn-heart" data-tour-id="{{ $tour->id }}" aria-label="Añadir tour a favoritos"><i class="far fa-heart"></i></button>
                                            <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-outline">Ver detalles</a>
                                            <a href="{{ route('tours.show', $tour->slug) }}" class="btn btn-primary">Reservar</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <nav class="pagination-wrapper" aria-label="Paginación">{{ $tours->appends(request()->query())->links() }}</nav>
                @else
                    <div class="no-results" role="status">
                        <div class="no-results-icon"><i class="fas fa-search"></i></div>
                        <h3>No encontramos resultados</h3>
                        <p>
                            @if($activeFilters->isNotEmpty())
                                Ajusta los filtros o explora otras categorías para encontrar más experiencias.
                            @else
                                Aún no tenemos tours disponibles. Vuelve pronto para descubrir nuevas aventuras.
                            @endif
                        </p>
                        <div class="no-results-actions">
                            <a href="{{ route('tours.index') }}" class="btn btn-primary"><i class="fas fa-compass"></i> Explorar todos los tours</a>
                            @if($activeFilters->isNotEmpty())
                                <button type="button" class="btn btn-ghost" onclick="history.back()"><i class="fas fa-arrow-left"></i> Regresar</button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="categories-section" id="categorias" aria-label="Categorías disponibles">
            <div class="container">
                <div class="section-header">
                    <div>
                        <h2 class="section-title">Explora por categoría</h2>
                        <p class="section-subtitle">Selecciona experiencias según tu estilo de viaje</p>
                    </div>
                    <a href="{{ route('tours.index') }}" class="link-all">Ver todos los tours <i class="fas fa-arrow-right"></i></a>
                </div>
                @php
                    $categoryIconFallbacks = [
                        'aventura-y-deportes-extremos' => 'fa-person-hiking',
                        'turismo-gastronomico' => 'fa-utensils',
                        'ecoturismo' => 'fa-seedling',
                        'turismo-cultural' => 'fa-landmark',
                        'caminatas-y-trekking' => 'fa-person-walking',
                        'relajacion-y-bienestar' => 'fa-spa',
                    ];
                @endphp
                <div class="categories-grid" role="list">
                    @foreach($categories as $category)
                        @php
                            $rawIcon = trim((string) ($category->icon ?? ''));
                            if ($rawIcon === '') {
                                $rawIcon = $categoryIconFallbacks[$category->slug] ?? 'fa-map-location-dot';
                            }
                            $iconTokens = preg_split('/\s+/', $rawIcon);
                            $stylePrefixes = ['fas', 'far', 'fal', 'fad', 'fab', 'fa-solid', 'fa-regular', 'fa-light', 'fa-thin', 'fa-duotone', 'fa-brands'];
                            $hasStylePrefix = false;
                            $normalizedTokens = [];

                            foreach ($iconTokens as $token) {
                                $token = trim($token);
                                if ($token === '') {
                                    continue;
                                }

                                if (in_array($token, $stylePrefixes, true)) {
                                    $hasStylePrefix = true;
                                    $normalizedTokens[] = $token;
                                    continue;
                                }

                                if (! Str::startsWith($token, 'fa-')) {
                                    $token = 'fa-' . $token;
                                }

                                $normalizedTokens[] = $token;
                            }

                            if (empty($normalizedTokens)) {
                                $normalizedTokens[] = 'fa-map-location-dot';
                                $hasStylePrefix = true;
                            }

                            if (! $hasStylePrefix) {
                                array_unshift($normalizedTokens, 'fas');
                            }

                            $iconClass = implode(' ', array_unique($normalizedTokens));
                        @endphp
                        <a href="{{ route('tours.index', ['category' => $category->slug]) }}" class="category-card" role="listitem" aria-label="Ver tours de {{ $category->name }}">
                            <div class="category-icon" style="background: {{ $category->color ?? 'var(--color-primary)' }}10; color: {{ $category->color ?? 'var(--color-primary)' }}">
                                <i class="{{ $iconClass }}" aria-hidden="true"></i>
                            </div>
                            <div class="category-info">
                                <h3>{{ $category->name }}</h3>
                                <p>{{ $category->description ?? 'Descubre experiencias inolvidables en esta categoría.' }}</p>
                                <span class="category-meta"><i class="fas fa-map-marker-alt"></i> <strong>{{ $category->tours_count ?? 0 }}</strong> tour{{ ($category->tours_count ?? 0) === 1 ? '' : 's' }}</span>
                            </div>
                            <span class="category-arrow"><i class="fas fa-arrow-right"></i></span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="cta-section" id="planifica">
            <div class="container cta-inner">
                <div class="cta-content">
                    <h2>¿Listo para planificar tu itinerario completo?</h2>
                    <p>Conecta con operadores locales verificados, recibe propuestas personalizadas y asegúrate de vivir una experiencia inolvidable en la selva central.</p>
                    <div class="cta-actions">
                        <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Crear cuenta</a>
                        <a href="#contacto" class="btn btn-outline"><i class="fas fa-comments"></i> Consultar con un experto</a>
                    </div>
                </div>
                <div class="cta-highlights">
                    <div class="highlight-item">
                        <i class="fas fa-hands-helping"></i>
                        <div>
                            <h4>Acompañamiento experto</h4>
                            <p>Te guiamos en cada paso para asegurar la mejor elección.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-leaf"></i>
                        <div>
                            <h4>Impacto positivo</h4>
                            <p>Apoyamos iniciativas de turismo sostenible en la región.</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <h4>Pagos seguros</h4>
                            <p>Procesos protegidos y transparencia total en los precios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer" id="contacto">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <h3>Chanchamayo Tours</h3>
                    <p>Descubre la magia de la selva central con experiencias curadas por expertos locales.</p>
                    <div class="footer-contact">
                        <a href="mailto:hola@chanchamayotours.com"><i class="fas fa-envelope"></i> hola@chanchamayotours.com</a>
                        <a href="tel:+51987654321"><i class="fas fa-phone"></i> +51 987 654 321</a>
                    </div>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h4>Descubre</h4>
                        <a href="{{ route('tours.index') }}">Todos los tours</a>
                        <a href="#categorias">Categorías</a>
                        <a href="#planifica">Planifica tu viaje</a>
                    </div>
                    <div class="footer-column">
                        <h4>Empresas</h4>
                        <a href="{{ route('company.register') }}">Registrar empresa</a>
                        <a href="{{ route('login') }}">Iniciar sesión</a>
                        <a href="#">Guía de buenas prácticas</a>
                    </div>
                    <div class="footer-column">
                        <h4>Legal</h4>
                        <a href="#">Términos y condiciones</a>
                        <a href="#">Política de privacidad</a>
                        <a href="#">Preguntas frecuentes</a>
                    </div>
                </div>
                <div class="footer-social">
                    <h4>Síguenos</h4>
                    <div class="social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ now()->year }} Chanchamayo Tours. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <div class="toast-container" id="toast-container" aria-live="assertive" aria-atomic="true"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;
            const header = document.getElementById('site-header');
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const navMenu = document.getElementById('main-navigation');
            const searchInput = document.getElementById('search-input');
            const searchHints = document.getElementById('search-hints');
            const filtersForm = document.getElementById('filters-form');
            const filterToggle = document.querySelector('.filter-toggle');
            const priceSlider = document.getElementById('priceSlider');
            const priceValue = document.getElementById('priceValue');
            const priceMaxInput = document.getElementById('priceMaxInput');
            const sortSelect = document.getElementById('sort-select');

            if (mobileMenuToggle && navMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
                    mobileMenuToggle.setAttribute('aria-expanded', String(!isExpanded));
                    navMenu.classList.toggle('active');
                    body.classList.toggle('menu-open');
                });
            }

            document.addEventListener('click', (event) => {
                if (mobileMenuToggle && !mobileMenuToggle.contains(event.target) && navMenu && !navMenu.contains(event.target)) {
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                    navMenu.classList.remove('active');
                    body.classList.remove('menu-open');
                }
            });

            let lastScrollTop = 0;
            window.addEventListener('scroll', function () {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                if (scrollTop > 120) {
                    header.classList.add('header-condensed');
                } else {
                    header.classList.remove('header-condensed');
                }
                lastScrollTop = scrollTop;
            }, { passive: true });

            if (filterToggle && filtersForm) {
                filterToggle.addEventListener('click', () => {
                    const isExpanded = filterToggle.getAttribute('aria-expanded') === 'true';
                    filterToggle.setAttribute('aria-expanded', String(!isExpanded));
                    filtersForm.classList.toggle('visible');
                });
            }

            if (priceSlider && priceValue && priceMaxInput) {
                const updateSlider = (value) => {
                    const parsed = Number(value);
                    const capped = parsed >= 500 ? '500+' : parsed;
                    priceValue.textContent = `S/ ${capped}`;
                    priceMaxInput.value = parsed >= 500 ? '' : parsed;
                    const percentage = Math.min((parsed / 500) * 100, 100);
                    priceSlider.style.setProperty('--slider-fill', `${percentage}%`);
                };

                const initialValue = priceSlider.value ? Number(priceSlider.value) : 250;
                priceSlider.value = initialValue;
                updateSlider(initialValue);

                priceSlider.addEventListener('input', (event) => updateSlider(event.target.value));
            }

            if (searchInput && searchHints) {
                searchInput.addEventListener('focus', () => searchHints.classList.add('visible'));
                searchInput.addEventListener('blur', () => setTimeout(() => searchHints.classList.remove('visible'), 150));
                searchHints.querySelectorAll('.search-hint').forEach((hint) => {
                    hint.addEventListener('mousedown', (event) => event.preventDefault());
                    hint.addEventListener('click', () => {
                        searchInput.value = hint.textContent.trim();
                        searchInput.focus();
                    });
                });
            }

            if (sortSelect) {
                sortSelect.addEventListener('change', () => {
                    const url = new URL(window.location.href);
                    const selected = sortSelect.value;
                    url.searchParams.set('sort', selected);
                    window.location.href = url.toString();
                });
            }

            const favoriteButtons = document.querySelectorAll('.favorite-btn, .btn-heart');
            favoriteButtons.forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    toggleFavorite(button);
                });
            });

            document.querySelectorAll('.share-btn').forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const tourSlug = button.dataset.tourSlug;
                    const card = button.closest('.tour-card');
                    const title = card ? card.querySelector('.tour-title a').textContent.trim() : 'Tour';
                    const shareUrl = `${window.location.origin}/tours/${tourSlug}`;

                    if (navigator.share) {
                        navigator.share({ title, url: shareUrl }).catch(() => showToast('No se pudo compartir', 'error'));
                    } else if (navigator.clipboard) {
                        navigator.clipboard.writeText(shareUrl).then(() => showToast('Enlace copiado al portapapeles')).catch(() => showToast('No se pudo copiar el enlace', 'error'));
                    }
                });
            });
        });

        function clearSearch() {
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        }

        function handleImageError(image) {
            const container = image.parentElement;
            image.remove();
            const placeholder = document.createElement('div');
            placeholder.className = 'tour-image-placeholder';
            placeholder.innerHTML = '<i class="fas fa-image"></i><span>Imagen no disponible</span>';
            container.prepend(placeholder);
        }

        function toggleFavorite(button) {
            const icon = button.querySelector('i');
            const isActive = icon.classList.contains('fas');
            button.classList.add('animate-heart');

            if (isActive) {
                icon.classList.replace('fas', 'far');
                button.classList.remove('active');
                showToast('Tour eliminado de favoritos', 'info');
            } else {
                icon.classList.replace('far', 'fas');
                button.classList.add('active');
                showToast('Tour agregado a favoritos', 'success');
            }

            setTimeout(() => button.classList.remove('animate-heart'), 300);
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) {
                return;
            }
            const iconMap = { success: 'fa-check', info: 'fa-info-circle', error: 'fa-exclamation-circle' };
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `<i class="fas ${iconMap[type] || iconMap.info}"></i><span>${message}</span>`;
            container.appendChild(toast);
            requestAnimationFrame(() => toast.classList.add('show'));
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3200);
        }
    </script>
</body>
</html>