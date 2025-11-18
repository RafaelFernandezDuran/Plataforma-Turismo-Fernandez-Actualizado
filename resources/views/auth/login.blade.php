<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar sesión - Chanchamayo Tours</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos principales -->
    <link rel="stylesheet" href="{{ asset('css/chanchamayo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <section class="auth-hero">
                <div class="auth-hero__badge">
                    <i class="fas fa-mountain"></i> Chanchamayo Tours
                </div>
                <div>
                    <h1 class="auth-hero__title">Impulsa tu empresa turística con nosotros</h1>
                    <p class="auth-hero__copy">Accede a tu panel para gestionar tours, reservas y recomendaciones inteligentes en una interfaz diseñada para tu crecimiento.</p>
                </div>
                <ul class="auth-hero__benefits">
                    <li>
                        <span>
                            <strong>Panel intuitivo:</strong> controla tus tours, ventas y reseñas en un solo lugar.
                        </span>
                    </li>
                    <li>
                        <span>
                            <strong>Recomendaciones inteligentes:</strong> potencia tu visibilidad con métricas en tiempo real.
                        </span>
                    </li>
                    <li>
                        <span>
                            <strong>Soporte dedicado:</strong> nuestro equipo acompaña a tu empresa en cada paso.
                        </span>
                    </li>
                </ul>
                <div class="auth-hero__footer">
                    <span>¿Aún no eres parte de la comunidad?</span>
                    <a class="btn-link" href="{{ url('/company/register') }}">
                        Registra tu empresa
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </section>

            <section class="auth-form">
                <div class="auth-form__header">
                    <h1>Bienvenido de vuelta</h1>
                    <p>Ingresa tus credenciales para continuar y retomar la gestión de tus experiencias turísticas.</p>
                </div>

                @if (session('status'))
                    <div class="auth-status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label required">Correo electrónico</label>
                        <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label required">Contraseña</label>
                        <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-options">
                        <label class="auth-checkbox" for="remember_me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>

                    <div class="auth-form__actions">
                        <button type="submit" class="btn btn-primary">
                            Iniciar sesión
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <div class="auth-redirect">
                    ¿Necesitas crear una cuenta de empresa? <a href="{{ url('/company/register') }}">Regístrate aquí</a>
                </div>

                <p class="auth-footer-note">
                    ¿Problemas para acceder? Escríbenos a <strong>soporte@chanchamayotours.com</strong> y estaremos encantados de ayudarte.
                </p>
            </section>
        </div>
    </div>
</body>
</html>
