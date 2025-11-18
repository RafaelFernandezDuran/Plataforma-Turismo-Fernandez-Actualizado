<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear cuenta - Chanchamayo Tours</title>

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
                    <i class="fas fa-route"></i> Explora Perú
                </div>
                <div>
                    <h1 class="auth-hero__title">Vive experiencias inolvidables en Chanchamayo</h1>
                    <p class="auth-hero__copy">Crea tu cuenta y descubre tours, alojamientos y actividades diseñadas para viajeros que buscan conectar con la selva central.</p>
                </div>
                <ul class="auth-hero__benefits">
                    <li>
                        <span>
                            <strong>Recomendaciones a medida:</strong> recibe propuestas según tus intereses y temporada.
                        </span>
                    </li>
                    <li>
                        <span>
                            <strong>Reservas seguras:</strong> gestiona tus pagos y vouchers desde un panel unificado.
                        </span>
                    </li>
                    <li>
                        <span>
                            <strong>Comunidad auténtica:</strong> comparte reseñas y ayuda a otros viajeros a decidir.
                        </span>
                    </li>
                </ul>
                <div class="auth-hero__footer">
                    <span>¿Representas una empresa turística?</span>
                    <a class="btn-link" href="{{ url('/company/register') }}">
                        Registra tu empresa
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </section>

            <section class="auth-form">
                <div class="auth-form__header">
                    <h1>Crear una nueva cuenta</h1>
                    <p>Completa tus datos para comenzar a planificar viajes y guardar tus experiencias favoritas.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label required">Nombre completo</label>
                            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label required">Correo electrónico</label>
                            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                            @error('email')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Teléfono (opcional)</label>
                            <input id="phone" class="form-input" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                            @error('phone')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="user_type" class="form-label required">Tipo de usuario</label>
                            <select id="user_type" name="user_type" class="form-input form-select" required>
                                <option value="tourist" {{ old('user_type', 'tourist') == 'tourist' ? 'selected' : '' }}>Turista</option>
                                <option value="company_admin" {{ old('user_type') == 'company_admin' ? 'selected' : '' }}>Administrador de empresa</option>
                            </select>
                            @error('user_type')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nationality" class="form-label">Nacionalidad</label>
                            <select id="nationality" name="nationality" class="form-input form-select">
                                <option value="PER" {{ old('nationality', 'PER') == 'PER' ? 'selected' : '' }}>Peruana</option>
                                <option value="USA" {{ old('nationality') == 'USA' ? 'selected' : '' }}>Estadounidense</option>
                                <option value="ARG" {{ old('nationality') == 'ARG' ? 'selected' : '' }}>Argentina</option>
                                <option value="CHL" {{ old('nationality') == 'CHL' ? 'selected' : '' }}>Chilena</option>
                                <option value="COL" {{ old('nationality') == 'COL' ? 'selected' : '' }}>Colombiana</option>
                                <option value="BRA" {{ old('nationality') == 'BRA' ? 'selected' : '' }}>Brasileña</option>
                                <option value="ECU" {{ old('nationality') == 'ECU' ? 'selected' : '' }}>Ecuatoriana</option>
                                <option value="BOL" {{ old('nationality') == 'BOL' ? 'selected' : '' }}>Boliviana</option>
                                <option value="ESP" {{ old('nationality') == 'ESP' ? 'selected' : '' }}>Española</option>
                                <option value="FRA" {{ old('nationality') == 'FRA' ? 'selected' : '' }}>Francesa</option>
                                <option value="DEU" {{ old('nationality') == 'DEU' ? 'selected' : '' }}>Alemana</option>
                                <option value="GBR" {{ old('nationality') == 'GBR' ? 'selected' : '' }}>Británica</option>
                                <option value="other" {{ old('nationality') == 'other' ? 'selected' : '' }}>Otra</option>
                            </select>
                            <div class="form-helper">Selecciona "Otra" si tu nacionalidad no aparece en la lista.</div>
                            @error('nationality')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label required">Contraseña</label>
                            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password">
                            <div class="form-helper">Debe tener al menos 8 caracteres combinando letras y números.</div>
                            @error('password')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label required">Confirmar contraseña</label>
                            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="auth-form__actions">
                        <button type="submit" class="btn btn-primary">
                            Crear cuenta
                            <i class="fas fa-user-plus"></i>
                        </button>
                        <a class="btn btn-secondary" href="{{ route('login') }}">
                            Ya tengo una cuenta
                        </a>
                    </div>
                </form>

                <p class="auth-footer-note">
                    Al registrarte aceptas nuestros <a href="/terms" target="_blank">Términos y Condiciones</a> y reconoces haber leído la <a href="/privacy" target="_blank">Política de Privacidad</a>.
                </p>
            </section>
        </div>
    </div>
</body>
</html>
