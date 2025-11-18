<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Empresa Turística - Chanchamayo Tours</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/chanchamayo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="registration-wrapper auth-wrapper">
        <div class="registration-container">
            <!-- Header -->
            <div class="registration-header">
                <div class="registration-header__content">
                    <h1>
                        Registro de Empresa Turística
                    </h1>
                    <p>
                        Únete a la red de turismo más importante de Chanchamayo
                    </p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" id="progressBar" style="width: 33.33%;"></div>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                </div>
                <div class="step-connector"></div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                </div>
                <div class="step-connector"></div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                </div>
            </div>

            <!-- Registration Form -->
            <form id="registrationForm" class="registration-body">
                @csrf
                
                <!-- Step 1: Información Básica -->
                <div class="step-content active" data-step="1">
                    <h3>
                        Información Básica de la Empresa
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Nombre Comercial</label>
                            <input type="text" name="name" class="form-input" placeholder="Ej: Aventuras Chanchamayo" required>
                            <div class="availability-check" id="nameCheck"></div>
                            <div class="error-message" id="nameError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">RUC</label>
                            <input type="text" name="ruc" class="form-input" placeholder="12345678901" maxlength="11" required>
                            <div class="availability-check" id="rucCheck"></div>
                            <div class="error-message" id="rucError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Email Corporativo</label>
                            <input type="email" name="email" class="form-input" placeholder="contacto@empresa.com" required>
                            <div class="availability-check" id="emailCheck"></div>
                            <div class="error-message" id="emailError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Teléfono Principal</label>
                            <input type="tel" name="phone" class="form-input" placeholder="+51 987 654 321" required>
                            <div class="error-message" id="phoneError"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Ubicación y contacto básico -->
                <div class="step-content" data-step="2">
                    <h3>
                        Ubicación y persona de contacto
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label required">Dirección Completa</label>
                            <input type="text" name="address" class="form-input" placeholder="Av. Principal 123, La Merced" required>
                            <div class="error-message" id="addressError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Ciudad</label>
                            <input type="text" name="city" class="form-input" placeholder="La Merced" required>
                            <div class="error-message" id="cityError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Región</label>
                            <select name="region" class="form-input form-select" required>
                                <option value="">Seleccionar región</option>
                                <option value="Junín">Junín</option>
                                <option value="Lima">Lima</option>
                                <option value="Cusco">Cusco</option>
                                <option value="Arequipa">Arequipa</option>
                                <option value="Loreto">Loreto</option>
                                <option value="San Martín">San Martín</option>
                                <option value="Ucayali">Ucayali</option>
                            </select>
                            <div class="error-message" id="regionError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Persona de Contacto</label>
                            <input type="text" name="contact_person" class="form-input" placeholder="Nombre y apellidos" required>
                            <div class="error-message" id="contact_personError"></div>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label required">Descripción breve de la empresa</label>
                            <textarea name="description" class="form-input form-textarea" placeholder="Cuéntanos en pocas líneas qué ofrece tu empresa" required minlength="40"></textarea>
                            <div class="error-message" id="descriptionError"></div>
                            <div class="step-helper">
                                Mínimo 40 caracteres. Podrás ampliar esta información más adelante.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 3: Crear cuenta -->
                <div class="step-content" data-step="3">
                    <h3>
                        Crear Cuenta de Usuario
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Email para Login</label>
                            <input type="email" name="user_email" class="form-input" placeholder="usuario@empresa.com" required>
                            <div class="error-message" id="user_emailError"></div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Contraseña</label>
                            <input type="password" name="user_password" class="form-input" placeholder="Mínimo 8 caracteres" required minlength="8">
                            <div class="error-message" id="user_passwordError"></div>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label required">Confirmar Contraseña</label>
                            <input type="password" name="user_password_confirmation" class="form-input" placeholder="Repetir contraseña" required>
                            <div class="error-message" id="user_password_confirmationError"></div>
                        </div>

                        <div class="form-group full-width form-group-spaced">
                            <label class="checkbox-item">
                                <input type="checkbox" name="terms_accepted" required>
                                <span>Acepto los <a href="/terms" target="_blank">Términos y Condiciones</a></span>
                            </label>
                            <div class="error-message" id="terms_acceptedError"></div>
                        </div>

                        <div class="form-group full-width">
                            <label class="checkbox-item">
                                <input type="checkbox" name="privacy_accepted" required>
                                <span>Acepto la <a href="/privacy" target="_blank">Política de Privacidad</a></span>
                            </label>
                            <div class="error-message" id="privacy_acceptedError"></div>
                        </div>
                    </div>

                    <div class="info-card">
                        <h4>
                            <i class="fas fa-info-circle"></i> Proceso de Revisión
                        </h4>
                        <ul>
                            <li>Tu registro será revisado por nuestro equipo en un plazo máximo de 48 horas</li>
                            <li>Recibirás notificaciones por email sobre el estado de tu solicitud</li>
                            <li>Una vez aprobado, podrás acceder al panel de administración</li>
                            <li>Podrás comenzar a publicar tours y gestionar reservas</li>
                        </ul>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)" style="display: none;">
                        <i class="fas fa-arrow-left"></i>
                        Anterior
                    </button>
                    
                    <div class="step-info" id="stepInfo">
                        Paso 1 de 3
                    </div>
                    
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="changeStep(1)">
                        Siguiente
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Variables globales
    let currentStep = 1;
    const totalSteps = 3;
        let stepData = {};

        // Configurar CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setupAvailabilityChecks();
        });

        // Configurar verificación de disponibilidad
        function setupAvailabilityChecks() {
            const fields = ['name', 'ruc', 'email'];
            
            fields.forEach(field => {
                const input = document.querySelector(`input[name="${field}"]`);
                const check = document.getElementById(`${field}Check`);
                
                if (input && check) {
                    let timeout;
                    
                    input.addEventListener('input', function() {
                        clearTimeout(timeout);
                        const value = this.value.trim();
                        
                        if (value.length > 2) {
                            check.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                            check.className = 'availability-check checking';
                            
                            timeout = setTimeout(() => {
                                checkAvailability(field, value);
                            }, 500);
                        } else {
                            check.innerHTML = '';
                            check.className = 'availability-check';
                        }
                    });
                }
            });
        }

        // Verificar disponibilidad
        async function checkAvailability(field, value) {
            try {
                const response = await fetch('/company/register/check-availability', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ field, value })
                });
                
                const result = await response.json();
                const check = document.getElementById(`${field}Check`);
                
                if (result.available) {
                    check.innerHTML = '<i class="fas fa-check"></i>';
                    check.className = 'availability-check available';
                } else {
                    check.innerHTML = '<i class="fas fa-times"></i>';
                    check.className = 'availability-check unavailable';
                }
            } catch (error) {
                console.error('Error checking availability:', error);
            }
        }

        // Cambiar paso
        async function changeStep(direction) {
            const newStep = currentStep + direction;
            
            if (direction > 0) {
                // Validar paso actual antes de continuar
                const isValid = await validateCurrentStep();
                if (!isValid) return;
            }
            
            if (newStep >= 1 && newStep <= totalSteps) {
                // Ocultar paso actual
                document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
                
                // Marcar como completado si vamos hacia adelante
                if (direction > 0) {
                    document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('completed');
                }
                
                // Mostrar nuevo paso
                currentStep = newStep;
                document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.add('active');
                document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('active');
                
                // Actualizar UI
                updateStepUI();
                updateProgressBar();
            }
        }

        // Actualizar UI del paso
        function updateStepUI() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const stepInfo = document.getElementById('stepInfo');
            
            // Botón anterior
            prevBtn.style.display = currentStep === 1 ? 'none' : 'inline-flex';
            
            // Botón siguiente/finalizar
            if (currentStep === totalSteps) {
                nextBtn.innerHTML = '<i class="fas fa-check"></i> Finalizar Registro';
                nextBtn.onclick = submitRegistration;
            } else {
                nextBtn.innerHTML = 'Siguiente <i class="fas fa-arrow-right"></i>';
                nextBtn.onclick = () => changeStep(1);
            }
            
            // Info del paso
            stepInfo.textContent = `Paso ${currentStep} de ${totalSteps}`;
        }

        // Actualizar barra de progreso
        function updateProgressBar() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('progressBar').style.width = `${progress}%`;
        }

        // Validar paso actual
        async function validateCurrentStep() {
            if (currentStep === totalSteps) {
                return true;
            }

            const formData = new FormData(document.getElementById('registrationForm'));
            formData.append('step', currentStep);
            
            // Limpiar errores previos
            clearErrors();
            
            try {
                const response = await fetch('/company/register', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    return true;
                } else {
                    showErrors(result.errors);
                    return false;
                }
            } catch (error) {
                console.error('Validation error:', error);
                showNotification('Error de conexión', 'error');
                return false;
            }
        }

        // Mostrar errores
        function showErrors(errors) {
            Object.keys(errors).forEach(field => {
                const errorDiv = document.getElementById(`${field}Error`);
                const input = document.querySelector(`[name="${field}"]`);
                
                if (errorDiv) {
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${errors[field][0]}`;
                }
                
                if (input) {
                    input.classList.add('error');
                }
            });
        }

        // Limpiar errores
        function clearErrors() {
            document.querySelectorAll('.error-message').forEach(div => {
                div.innerHTML = '';
            });
            
            document.querySelectorAll('.form-input.error').forEach(input => {
                input.classList.remove('error');
            });
        }

        // Finalizar registro
        async function submitRegistration() {
            const isValid = await validateCurrentStep();
            if (!isValid) return;
            
            const nextBtn = document.getElementById('nextBtn');
            const originalContent = nextBtn.innerHTML;
            
            // Mostrar loading
            nextBtn.disabled = true;
            nextBtn.innerHTML = '<div class="loading-spinner"></div> Procesando...';
            
            try {
                const formData = new FormData(document.getElementById('registrationForm'));
                formData.append('step', totalSteps);
                
                const response = await fetch('/company/register', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showNotification(result.message, 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect;
                    }, 2000);
                } else {
                    showErrors(result.errors);
                    showNotification(result.message || 'Error en el registro', 'error');
                }
            } catch (error) {
                console.error('Registration error:', error);
                showNotification('Error de conexión', 'error');
            } finally {
                nextBtn.disabled = false;
                nextBtn.innerHTML = originalContent;
            }
        }

        // Mostrar notificación
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 2rem;
                border-radius: 8px;
                color: white;
                font-weight: 600;
                z-index: 10000;
                transform: translateX(400px);
                transition: transform 0.3s ease;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            `;
            
            const colors = {
                success: 'linear-gradient(135deg, var(--verde-selva), var(--verde-claro))',
                error: 'linear-gradient(135deg, #ef4444, #dc2626)',
                info: 'linear-gradient(135deg, var(--azul-cielo), #0284c7)'
            };
            
            notification.style.background = colors[type] || colors.info;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }
    </script>
</body>
</html>