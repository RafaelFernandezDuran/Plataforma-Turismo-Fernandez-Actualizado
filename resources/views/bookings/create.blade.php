<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Tour - {{ $tour->title }} - Chanchamayo Tours</title>
    <link rel="stylesheet" href="{{ asset('css/chanchamayo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tours-index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="description" content="Reserva tu tour {{ $tour->title }} en Chanchamayo Tours">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .booking-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .booking-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 24px 48px -32px rgba(76, 29, 149, 0.45);
        }

        .tour-summary {
            display: flex;
            gap: 1.75rem;
            align-items: center;
        }

        .tour-image-small {
            width: clamp(180px, 32vw, 260px);
            aspect-ratio: 4 / 3;
            border-radius: 18px;
            object-fit: cover;
            object-position: center;
            box-shadow: 0 20px 40px -30px rgba(15, 23, 42, 0.55);
            border: 3px solid rgba(255, 255, 255, 0.45);
        }

        .tour-info {
            flex: 1;
        }

        .tour-info h1 {
            font-size: clamp(1.6rem, 3vw, 2.25rem);
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .tour-details {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem 1.5rem;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            opacity: 0.85;
        }

        .tour-details span {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }

        .tour-price {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.55rem 1rem;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .payment-simulation {
            background: #ffffff;
            border: 2px solid rgba(99, 102, 241, 0.16);
            border-radius: 18px;
            padding: 1.75rem;
            margin-bottom: 2rem;
            box-shadow: 0 28px 56px -40px rgba(67, 56, 202, 0.5);
        }

        .saved-card-banner {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
            margin-bottom: 1.25rem;
            padding: 0.85rem 1rem;
            border-radius: 14px;
            border: 1px solid rgba(56, 189, 248, 0.35);
            background: rgba(191, 219, 254, 0.35);
            color: #1e3a8a;
        }

        .saved-card-banner strong {
            font-weight: 700;
        }

        .saved-card-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .manage-saved-card {
            font-weight: 600;
            color: #1d4ed8;
            text-decoration: underline;
        }

        .payment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            gap: 1rem;
        }

        .payment-header h3 {
            margin: 0;
            color: #312e81;
            font-size: 1.25rem;
        }

        .badge-simulation {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.9rem;
            border-radius: 999px;
            background: rgba(129, 140, 248, 0.15);
            color: #312e81;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .payment-note {
            margin-bottom: 1.25rem;
            color: #4338ca;
            font-size: 0.95rem;
            line-height: 1.55;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: minmax(0, 44%) minmax(0, 56%);
            gap: 1.6rem;
            align-items: stretch;
        }

        .card-preview {
            position: relative;
            padding: 1.75rem;
            border-radius: 18px;
            background: linear-gradient(140deg, #4c1d95 0%, #6366f1 52%, #9333ea 100%);
            color: #ffffff;
            box-shadow: 0 26px 48px -30px rgba(76, 29, 149, 0.55);
            min-height: 220px;
            overflow: hidden;
        }

        .card-preview::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.25), transparent 55%);
            pointer-events: none;
        }

        .card-chip {
            width: 52px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, #facc15, #f59e0b);
            margin-bottom: 2rem;
        }

        .card-number {
            font-size: 1.35rem;
            letter-spacing: 0.18em;
            margin-bottom: 1.75rem;
            font-weight: 600;
        }

        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            gap: 1rem;
        }

        .card-meta strong {
            display: block;
            font-size: 1rem;
            letter-spacing: 0.08em;
        }

        .card-brand {
            position: absolute;
            bottom: 1.3rem;
            right: 1.6rem;
            font-weight: 700;
            letter-spacing: 0.28em;
            font-size: 0.95rem;
        }

        .card-form .form-group label {
            color: #4338ca;
        }

        .payment-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
        }

        .btn-simulate {
            margin-top: 1.25rem;
            width: 100%;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 0.95rem 1.25rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            justify-content: center;
            gap: 0.6rem;
            align-items: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-simulate:disabled {
            cursor: not-allowed;
            opacity: 0.65;
        }

        .btn-simulate:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 38px -25px rgba(124, 58, 237, 0.45);
        }

        .payment-status {
            display: none;
            margin-top: 1rem;
            padding: 0.85rem 1.1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .payment-status.visible {
            display: block;
        }

        .payment-status.processing {
            background: rgba(59, 130, 246, 0.12);
            color: #1d4ed8;
        }

        .payment-status.success {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        .payment-status.error {
            background: rgba(248, 113, 113, 0.12);
            color: #b91c1c;
        }

        .payment-security {
            margin-top: 0.75rem;
            color: #4b5563;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .security-checklist {
            margin-top: 1.15rem;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }

        .security-step {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
            color: #4b5563;
            padding: 0.45rem 0.6rem;
            border-radius: 0.85rem;
            background: rgba(99, 102, 241, 0.06);
            border: 1px solid transparent;
            transition: all 0.25s ease;
        }

        .security-step i {
            color: #4f46e5;
            font-size: 0.95rem;
        }

        .security-step.active {
            border-color: rgba(99, 102, 241, 0.45);
            background: rgba(99, 102, 241, 0.12);
            color: #312e81;
        }

        .security-step.completed {
            border-color: rgba(36, 197, 118, 0.6);
            background: rgba(16, 185, 129, 0.08);
            color: #065f46;
        }

        .security-step.completed i {
            color: #059669;
        }

        .save-card-toggle {
            margin-top: 1.25rem;
            padding: 0.9rem 1rem;
            border-radius: 12px;
            background: rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.18);
        }

        .save-card-checkbox {
            display: flex;
            gap: 0.65rem;
            align-items: center;
            font-weight: 600;
            color: #312e81;
        }

        .save-card-checkbox input {
            width: 18px;
            height: 18px;
            accent-color: #4f46e5;
        }

        .save-card-hint {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            color: #4b5563;
            line-height: 1.4;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section h3 {
            color: #2d3748;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .participant-card {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .participant-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .participant-number {
            background: #667eea;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .remove-participant {
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .add-participant {
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .price-summary {
            background: #f0f9ff;
            border: 2px solid #0ea5e9;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .price-total {
            border-top: 2px solid #e5e7eb;
            padding-top: 1rem;
            font-weight: 700;
            font-size: 1.2rem;
            color: #1f2937;
        }

        .btn-book {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s ease;
        }

        .btn-book:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            display: inline-block;
            margin-right: 1rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .tour-summary {
                flex-direction: column;
                text-align: center;
            }

            .tour-image-small {
                width: min(240px, 100%);
            }

            .tour-details {
                justify-content: center;
            }

            .booking-container {
                padding: 1rem;
            }

            .payment-grid {
                grid-template-columns: 1fr;
            }

            .payment-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .payment-note {
                font-size: 0.9rem;
            }

            .card-preview {
                min-height: 200px;
            }

            .payment-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="page-with-navbar booking-create-page">
    @include('partials.site-header')

    <div class="booking-container">
        <div class="booking-header">
        <div class="tour-summary">
            @php
                $tourImage = $tour->image_url;
            @endphp
            @if($tourImage)
                <img src="{{ $tourImage }}"
                     alt="{{ $tour->title }}"
                     class="tour-image-small">
            @else
                <div class="tour-image-placeholder" style="width: 80px; height: 80px;">
                    <i class="fas fa-mountain"></i>
                </div>
            @endif
            
            <div class="tour-info">
                <h1>{{ $tour->title }}</h1>
                <div class="tour-details">
                    <span><i class="fas fa-clock"></i> {{ $tour->duration_days }} días</span>
                    <span><i class="fas fa-users"></i> {{ $tour->min_participants }} - {{ $tour->max_participants }} personas</span>
                </div>
                <div class="tour-price">
                    Desde S/ {{ number_format($tour->price, 0) }} por persona
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('bookings.store') }}" method="POST" class="booking-form" id="bookingForm">
        @csrf
        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
        <input type="hidden" name="payment_method" id="paymentMethodInput" value="card_simulation">
        <input type="hidden" name="payment_status" id="paymentStatusInput" value="{{ old('payment_status', 'pending') }}">
        <input type="hidden" name="payment_reference" id="paymentReferenceInput" value="{{ old('payment_reference') }}">
        <input type="hidden" name="card_brand" id="cardBrandInput" value="{{ old('card_brand', $savedCard['brand'] ?? '') }}">
        <input type="hidden" name="card_last_four" id="cardLastFourInput" value="{{ old('card_last_four', $savedCard['last_four'] ?? '') }}">
        <input type="hidden" name="card_expiry" id="cardExpiryHiddenInput" value="{{ old('card_expiry', $savedCard['expiry'] ?? '') }}">
        <input type="hidden" name="card_holder_name" id="cardHolderHiddenInput" value="{{ old('card_holder_name', $savedCard['holder'] ?? '') }}">
        <input type="hidden" name="use_saved_card" id="useSavedCardInput" value="{{ old('use_saved_card', !empty($savedCard['last_four']) ? 1 : 0) }}">

        <!-- Fecha del Tour -->
        <div class="form-section">
            <h3><i class="fas fa-calendar"></i> Fecha del Tour</h3>
            <div class="form-group">
                <label for="tour_date">Selecciona la fecha *</label>
                <input type="date" 
                       id="tour_date" 
                       name="tour_date" 
                       class="form-control" 
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       value="{{ old('tour_date') }}" 
                       required>
                @error('tour_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Participantes -->
        <div class="form-section">
            <h3><i class="fas fa-users"></i> Número de Participantes</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="adult_participants">Adultos *</label>
                    <input type="number" 
                           id="adult_participants" 
                           name="adult_participants" 
                           class="form-control" 
                           min="1" 
                           max="{{ $tour->max_participants }}"
                           value="{{ old('adult_participants', 1) }}" 
                           required>
                    @error('adult_participants')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="child_participants">Niños (opcional)</label>
                    <input type="number" 
                           id="child_participants" 
                           name="child_participants" 
                           class="form-control" 
                           min="0" 
                           max="10"
                           value="{{ old('child_participants', 0) }}">
                    @error('child_participants')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Detalles de Participantes -->
        <div class="form-section">
            <h3><i class="fas fa-id-card"></i> Detalles de los Participantes</h3>
            <div id="participants-container">
                <!-- Los participantes se agregarán aquí dinámicamente -->
            </div>
        </div>

        <!-- Solicitudes Especiales -->
        <div class="form-section">
            <h3><i class="fas fa-comment"></i> Solicitudes Especiales</h3>
            <div class="form-group">
                <label for="special_requests">¿Tienes alguna solicitud especial? (opcional)</label>
                <textarea id="special_requests" 
                          name="special_requests" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Ejemplo: Vegetariano, alergias alimentarias, necesidades de accesibilidad, etc.">{{ old('special_requests') }}</textarea>
                @error('special_requests')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Resumen de Precios -->
        <div class="price-summary">
            <h3><i class="fas fa-calculator"></i> Resumen de Precios</h3>
            <div class="price-row" id="adult-price-row">
                <span>Adultos (<span id="adult-count">1</span> x S/ {{ number_format($tour->price, 0) }})</span>
                <span id="adult-total">S/ {{ number_format($tour->price, 0) }}</span>
            </div>
            <div class="price-row" id="child-price-row" style="display: none;">
                <span>Niños (<span id="child-count">0</span> x S/ {{ number_format($tour->child_price ?? $tour->price * 0.7, 0) }})</span>
                <span id="child-total">S/ 0</span>
            </div>
            <div class="price-row">
                <span>Comisión de plataforma (10%)</span>
                <span id="commission">S/ {{ number_format($tour->price * 0.1, 0) }}</span>
            </div>
            <div class="price-row price-total">
                <span>Total a Pagar</span>
                <span id="total-price">S/ {{ number_format($tour->price * 1.1, 0) }}</span>
            </div>
        </div>

        <!-- Pago con tarjeta -->
        <div class="payment-simulation" aria-labelledby="paymentGatewayTitle">
            <div class="payment-header">
                <h3 id="paymentGatewayTitle"><i class="fas fa-credit-card"></i> Pago con Tarjeta</h3>
                <span class="badge-simulation"><i class="fas fa-lock"></i> Pasarela cifrada</span>
            </div>
            <p class="payment-note">Procesamos tu transacción mediante tokenización instantánea, monitoreo antifraude y autenticación 3‑D Secure para garantizar la integridad de los fondos.</p>
            @if(!empty($savedCard['last_four'] ?? null))
                <div class="saved-card-banner">
                    <div>
                        <strong>Tarjeta guardada:</strong>
                        {{ strtoupper($savedCard['brand'] ?? 'Tarjeta') }} terminada en {{ $savedCard['last_four'] }}
                        @if(!empty($savedCard['expiry']))
                            · expira {{ $savedCard['expiry'] }}
                        @endif
                    </div>
                    <div class="saved-card-meta">
                        <span>Resguardada {{ optional($savedCard['saved_at'])->locale(app()->getLocale())->diffForHumans() ?? 'recientemente' }}</span>
                        <a href="{{ route('dashboard') }}" class="manage-saved-card">Gestionar desde el panel</a>
                        <button type="button" id="toggleCardModeButton" class="inline-flex items-center gap-2 rounded-lg border border-blue-600 bg-white px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-50">
                            Usar otra tarjeta
                        </button>
                    </div>
                    <div id="savedCardConfirmation" class="mt-2 text-xs font-semibold text-blue-900">
                        Esta reserva utilizará automáticamente tu tarjeta guardada. Podrás cambiarla cuando lo necesites.
                    </div>
                </div>
            @endif
            <div class="payment-grid" id="manualCardSection">
                <div class="card-preview" role="img" aria-label="Tarjeta de crédito simulada">
                    <div class="card-chip"></div>
                    <div class="card-number" id="cardPreviewNumber">0000 0000 0000 0000</div>
                    <div class="card-meta">
                        <div>
                            <span>Titular</span>
                            <strong id="cardPreviewHolder">NOMBRE TITULAR</strong>
                        </div>
                        <div>
                            <span>Expira</span>
                            <strong id="cardPreviewExpiry">MM/AA</strong>
                        </div>
                    </div>
                    <div class="card-brand" id="cardPreviewBrand">CARD</div>
                </div>
                <div class="card-form">
                    <div class="form-group">
                        <label for="card_number">Número de tarjeta</label>
                        <input type="text"
                               id="card_number"
                               class="form-control"
                               placeholder="1234 5678 9012 3456"
                               inputmode="numeric"
                               autocomplete="off"
                               maxlength="19">
                    </div>
                    <div class="form-group">
                        <label for="card_holder">Nombre del titular</label>
                        <input type="text"
                               id="card_holder"
                               class="form-control"
                               placeholder="Como aparece en la tarjeta"
                               autocomplete="off"
                               maxlength="40">
                    </div>
                    <div class="form-row payment-row">
                        <div class="form-group">
                            <label for="card_expiry">Expiración</label>
                            <input type="text"
                                   id="card_expiry"
                                   class="form-control"
                                   placeholder="MM/AA"
                                   inputmode="numeric"
                                   autocomplete="off"
                                   maxlength="5">
                        </div>
                        <div class="form-group">
                            <label for="card_cvv">CVV</label>
                            <input type="password"
                                   id="card_cvv"
                                   class="form-control"
                                   placeholder="123"
                                   inputmode="numeric"
                                   autocomplete="off"
                                   maxlength="4">
                        </div>
                    </div>
                    <div class="save-card-toggle" id="saveCardWrapper">
                        <label class="save-card-checkbox" for="saveCardToggle">
                            <input type="checkbox" name="save_card" id="saveCardToggle" value="1" {{ old('save_card') ? 'checked' : '' }}>
                            Guardar esta tarjeta para pagos futuros
                        </label>
                        <p class="save-card-hint">Solo retenemos un token cifrado, la marca y los últimos 4 dígitos para que puedas autorizar tus próximas reservas más rápido.</p>
                        @if(!empty($savedCard['last_four'] ?? null))
                            <p class="save-card-hint">Si confirmas, sustituiremos la tarjeta guardada actualmente.</p>
                        @endif
                    </div>
                    <button type="button" class="btn-simulate" id="simulatePayment">
                        <i class="fas fa-shield-halved"></i> Autorizar pago
                    </button>
                    <div class="payment-status" id="paymentStatus" aria-live="polite"></div>
                    <div class="payment-security">
                        <i class="fas fa-shield-alt"></i>
                        Pasarela certificada PCI DSS, cifrado AES-256 y monitoreo continuo contra fraude.
                    </div>
                    <ul class="security-checklist" id="securityChecklist">
                        <li class="security-step"><i class="fas fa-lock"></i> Cifrado SSL/TLS 256-bit establecido</li>
                        <li class="security-step"><i class="fas fa-fingerprint"></i> Tokenización dinámica y scoring antifraude</li>
                        <li class="security-step"><i class="fas fa-user-check"></i> Autenticación reforzada 3-D Secure</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="form-actions">
            <a href="{{ route('tours.show', $tour) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Tour
            </a>
            <button type="submit" class="btn-book">
                <i class="fas fa-credit-card"></i> Confirmar Reserva
            </button>
        </div>
    </form>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adultInput = document.getElementById('adult_participants');
    const childInput = document.getElementById('child_participants');
    const participantsContainer = document.getElementById('participants-container');
    
    const adultPrice = {{ $tour->price }};
    const childPrice = {{ $tour->child_price ?? $tour->price * 0.7 }};

    const cardNumberInput = document.getElementById('card_number');
    const cardHolderInput = document.getElementById('card_holder');
    const cardExpiryInput = document.getElementById('card_expiry');
    const cardCvvInput = document.getElementById('card_cvv');
    const cardPreviewNumber = document.getElementById('cardPreviewNumber');
    const cardPreviewHolder = document.getElementById('cardPreviewHolder');
    const cardPreviewExpiry = document.getElementById('cardPreviewExpiry');
    const cardPreviewBrand = document.getElementById('cardPreviewBrand');
    const simulateButton = document.getElementById('simulatePayment');
    const paymentStatusBanner = document.getElementById('paymentStatus');
    const paymentReferenceInput = document.getElementById('paymentReferenceInput');
    const paymentStatusInputField = document.getElementById('paymentStatusInput');
    const cardBrandHiddenInput = document.getElementById('cardBrandInput');
    const cardLastFourHiddenInput = document.getElementById('cardLastFourInput');
    const cardExpiryHiddenInput = document.getElementById('cardExpiryHiddenInput');
    const cardHolderHiddenInput = document.getElementById('cardHolderHiddenInput');
    const useSavedCardInput = document.getElementById('useSavedCardInput');
    const manualCardSection = document.getElementById('manualCardSection');
    const toggleCardModeButton = document.getElementById('toggleCardModeButton');
    const savedCardConfirmation = document.getElementById('savedCardConfirmation');
    const saveCardWrapper = document.getElementById('saveCardWrapper');
    const saveCardToggle = document.getElementById('saveCardToggle');

    const savedCardData = @json($savedCard);
    const hasSavedCard = Boolean(savedCardData && savedCardData.last_four);

    let usingSavedCard = hasSavedCard && (!useSavedCardInput || useSavedCardInput.value === '1');

    const CARD_NUMBER_PLACEHOLDER = '0000 0000 0000 0000';
    const CARD_HOLDER_PLACEHOLDER = 'NOMBRE TITULAR';
    const CARD_EXPIRY_PLACEHOLDER = 'MM/AA';
    
    function updateParticipants() {
        const adults = parseInt(adultInput.value) || 1;
        const children = parseInt(childInput.value) || 0;
        const total = adults + children;
        
        // Limpiar contenedor
        participantsContainer.innerHTML = '';
        
        // Crear campos para cada participante
        for (let i = 0; i < total; i++) {
            const isChild = i >= adults;
            const participantDiv = document.createElement('div');
            participantDiv.className = 'participant-card';
            participantDiv.innerHTML = `
                <div class="participant-header">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div class="participant-number">${i + 1}</div>
                        <h4>Participante ${i + 1} ${isChild ? '(Niño)' : '(Adulto)'}</h4>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nombre Completo *</label>
                        <input type="text" 
                               name="participant_details[${i}][name]" 
                               class="form-control" 
                               required>
                    </div>
                    <div class="form-group">
                        <label>Documento de Identidad *</label>
                        <input type="text" 
                               name="participant_details[${i}][document]" 
                               class="form-control" 
                               required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Edad *</label>
                        <input type="number" 
                               name="participant_details[${i}][age]" 
                               class="form-control" 
                               min="1" 
                               max="100"
                               value="${isChild ? '10' : '25'}"
                               required>
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                        <input type="text" 
                               class="form-control" 
                               value="${isChild ? 'Niño' : 'Adulto'}" 
                               readonly>
                    </div>
                </div>
            `;
            participantsContainer.appendChild(participantDiv);
        }
        
        // Actualizar precios
        updatePricing();
    }
    
    function updatePricing() {
        const adults = parseInt(adultInput.value) || 1;
        const children = parseInt(childInput.value) || 0;
        
        const adultTotal = adults * adultPrice;
        const childTotal = children * childPrice;
        const subtotal = adultTotal + childTotal;
        const commission = subtotal * 0.1;
        const total = subtotal + commission;
        
        // Actualizar elementos del DOM
        document.getElementById('adult-count').textContent = adults;
        document.getElementById('adult-total').textContent = `S/ ${adultTotal.toLocaleString()}`;
        
        const childRow = document.getElementById('child-price-row');
        if (children > 0) {
            childRow.style.display = 'flex';
            document.getElementById('child-count').textContent = children;
            document.getElementById('child-total').textContent = `S/ ${childTotal.toLocaleString()}`;
        } else {
            childRow.style.display = 'none';
        }
        
        document.getElementById('commission').textContent = `S/ ${commission.toLocaleString()}`;
        document.getElementById('total-price').textContent = `S/ ${total.toLocaleString()}`;
    }
    
    // Event listeners
    adultInput.addEventListener('change', updateParticipants);
    childInput.addEventListener('change', updateParticipants);
    
    // Inicializar
    updateParticipants();

        function formatCardNumber(value) {
            return value.replace(/\D/g, '').slice(0, 16).replace(/(\d{4})/g, '$1 ').trim();
        }

        function detectCardBrand(number) {
            if (/^4/.test(number)) return 'VISA';
            if (/^5[1-5]/.test(number)) return 'MASTERCARD';
            if (/^3[47]/.test(number)) return 'AMEX';
            if (/^6(?:011|5)/.test(number)) return 'DISCOVER';
            return 'CARD';
        }

        function formatExpiry(value) {
            const sanitized = value.replace(/\D/g, '').slice(0, 4);
            if (sanitized.length <= 2) {
                return sanitized;
            }
            return `${sanitized.slice(0, 2)}/${sanitized.slice(2)}`;
        }

        function generateReference(prefix = 'SIM') {
            const random = Math.random().toString(36).slice(2, 8).toUpperCase();
            const timestamp = Date.now().toString(36).toUpperCase();
            return `${prefix}-${timestamp}${random}`;
        }

        function resetPaymentStatus() {
            if (!paymentStatusBanner) {
                return;
            }
            paymentStatusBanner.textContent = '';
            paymentStatusBanner.className = 'payment-status';
            if (paymentStatusInputField) {
                paymentStatusInputField.value = 'pending';
            }
            if (paymentReferenceInput) {
                paymentReferenceInput.value = '';
            }
        }

        function setPaymentStatus(state, message) {
            if (!paymentStatusBanner) {
                return;
            }
            paymentStatusBanner.textContent = message;
            paymentStatusBanner.className = `payment-status ${state} visible`;
        }

        function updateCardMode() {
            if (!hasSavedCard) {
                usingSavedCard = false;
                if (useSavedCardInput) {
                    useSavedCardInput.value = '0';
                }
                return;
            }

            if (usingSavedCard) {
                if (manualCardSection) {
                    manualCardSection.style.display = 'none';
                }
                if (saveCardWrapper) {
                    saveCardWrapper.style.display = 'none';
                }
                if (simulateButton) {
                    simulateButton.style.display = 'none';
                    simulateButton.disabled = false;
                }
                if (paymentStatusBanner) {
                    paymentStatusBanner.style.display = 'none';
                    paymentStatusBanner.textContent = '';
                }
                if (toggleCardModeButton) {
                    toggleCardModeButton.textContent = 'Usar otra tarjeta';
                }
                if (savedCardConfirmation) {
                    savedCardConfirmation.style.display = 'block';
                }
                if (useSavedCardInput) {
                    useSavedCardInput.value = '1';
                }
                if (paymentStatusInputField) {
                    paymentStatusInputField.value = 'paid';
                }
                if (paymentReferenceInput && !paymentReferenceInput.value) {
                    paymentReferenceInput.value = generateReference('SAVED');
                }
                if (cardBrandHiddenInput) {
                    cardBrandHiddenInput.value = (savedCardData?.brand || 'CARD').toUpperCase();
                }
                if (cardLastFourHiddenInput) {
                    cardLastFourHiddenInput.value = savedCardData?.last_four || '';
                }
                if (cardHolderHiddenInput) {
                    cardHolderHiddenInput.value = (savedCardData?.holder || '').toUpperCase();
                }
                if (cardExpiryHiddenInput) {
                    cardExpiryHiddenInput.value = savedCardData?.expiry || '';
                }
                if (cardPreviewNumber) {
                    cardPreviewNumber.textContent = savedCardData?.last_four
                        ? `**** **** **** ${savedCardData.last_four}`
                        : CARD_NUMBER_PLACEHOLDER;
                }
                if (cardPreviewHolder) {
                    cardPreviewHolder.textContent = (savedCardData?.holder || CARD_HOLDER_PLACEHOLDER).toUpperCase();
                }
                if (cardPreviewExpiry) {
                    cardPreviewExpiry.textContent = savedCardData?.expiry || CARD_EXPIRY_PLACEHOLDER;
                }
                if (cardPreviewBrand) {
                    cardPreviewBrand.textContent = (savedCardData?.brand || 'CARD').toUpperCase();
                }
                if (saveCardToggle) {
                    saveCardToggle.checked = false;
                    saveCardToggle.disabled = true;
                }
                if (cardNumberInput) {
                    cardNumberInput.value = '';
                }
                if (cardHolderInput) {
                    cardHolderInput.value = '';
                }
                if (cardExpiryInput) {
                    cardExpiryInput.value = '';
                }
                if (cardCvvInput) {
                    cardCvvInput.value = '';
                }
            } else {
                if (manualCardSection) {
                    manualCardSection.style.display = '';
                }
                if (saveCardWrapper) {
                    saveCardWrapper.style.display = '';
                }
                if (simulateButton) {
                    simulateButton.style.display = '';
                    simulateButton.disabled = false;
                }
                if (paymentStatusBanner) {
                    paymentStatusBanner.style.display = '';
                    resetPaymentStatus();
                }
                if (toggleCardModeButton) {
                    toggleCardModeButton.textContent = 'Volver a tarjeta guardada';
                }
                if (savedCardConfirmation) {
                    savedCardConfirmation.style.display = 'none';
                }
                if (useSavedCardInput) {
                    useSavedCardInput.value = '0';
                }
                if (paymentStatusInputField) {
                    paymentStatusInputField.value = 'pending';
                }
                if (paymentReferenceInput) {
                    paymentReferenceInput.value = '';
                }
                if (cardBrandHiddenInput) {
                    cardBrandHiddenInput.value = '';
                }
                if (cardLastFourHiddenInput) {
                    cardLastFourHiddenInput.value = '';
                }
                if (cardHolderHiddenInput && (!cardHolderInput || !cardHolderInput.value)) {
                    cardHolderHiddenInput.value = '';
                }
                if (cardExpiryHiddenInput && (!cardExpiryInput || !cardExpiryInput.value)) {
                    cardExpiryHiddenInput.value = '';
                }
                if (cardPreviewNumber && (!cardNumberInput || !cardNumberInput.value)) {
                    cardPreviewNumber.textContent = CARD_NUMBER_PLACEHOLDER;
                }
                if (cardPreviewHolder && (!cardHolderInput || !cardHolderInput.value)) {
                    cardPreviewHolder.textContent = CARD_HOLDER_PLACEHOLDER;
                }
                if (cardPreviewExpiry && (!cardExpiryInput || !cardExpiryInput.value)) {
                    cardPreviewExpiry.textContent = CARD_EXPIRY_PLACEHOLDER;
                }
                if (cardPreviewBrand && (!cardBrandHiddenInput || !cardBrandHiddenInput.value)) {
                    cardPreviewBrand.textContent = 'CARD';
                }
                if (saveCardToggle) {
                    saveCardToggle.disabled = false;
                }
            }
        }

        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', (event) => {
                const formatted = formatCardNumber(event.target.value);
                event.target.value = formatted;
                const digits = formatted.replace(/\s/g, '');
                if (cardPreviewNumber) {
                    cardPreviewNumber.textContent = formatted || CARD_NUMBER_PLACEHOLDER;
                }
                const brand = detectCardBrand(digits);
                if (cardPreviewBrand) {
                    cardPreviewBrand.textContent = digits ? brand : 'CARD';
                }
                if (cardBrandHiddenInput) {
                    cardBrandHiddenInput.value = digits.length >= 4 ? brand : '';
                }
                if (cardLastFourHiddenInput) {
                    cardLastFourHiddenInput.value = digits.length >= 4 ? digits.slice(-4) : '';
                }
                resetPaymentStatus();
            });
        }

        if (cardHolderInput) {
            cardHolderInput.addEventListener('input', (event) => {
                const value = event.target.value.toUpperCase();
                event.target.value = value;
                if (cardPreviewHolder) {
                    cardPreviewHolder.textContent = value || CARD_HOLDER_PLACEHOLDER;
                }
                if (cardHolderHiddenInput) {
                    cardHolderHiddenInput.value = value || '';
                }
                resetPaymentStatus();
            });
        }

        if (cardExpiryInput) {
            cardExpiryInput.addEventListener('input', (event) => {
                const formatted = formatExpiry(event.target.value);
                event.target.value = formatted;
                if (cardPreviewExpiry) {
                    cardPreviewExpiry.textContent = formatted || CARD_EXPIRY_PLACEHOLDER;
                }
                if (cardExpiryHiddenInput) {
                    cardExpiryHiddenInput.value = /^(0[1-9]|1[0-2])\/[0-9]{2}$/.test(formatted) ? formatted : '';
                }
                resetPaymentStatus();
            });
        }

        if (cardCvvInput) {
            cardCvvInput.addEventListener('input', (event) => {
                event.target.value = event.target.value.replace(/\D/g, '').slice(0, 4);
                resetPaymentStatus();
            });
        }

        if (simulateButton) {
            simulateButton.addEventListener('click', () => {
                if (!cardNumberInput || !cardHolderInput || !cardExpiryInput) {
                    return;
                }

                const number = cardNumberInput.value.replace(/\s/g, '');
                const holder = cardHolderInput.value.trim();
                const expiry = cardExpiryInput.value.trim();

                if (number.length < 16 || holder.length < 4 || !/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
                    setPaymentStatus('error', 'Verifica los datos de la tarjeta para continuar con la simulación.');
                    return;
                }

                simulateButton.disabled = true;
                setPaymentStatus('processing', 'Procesando simulación de pago...');

                setTimeout(() => {
                    const reference = generateReference('SIM');
                    if (paymentReferenceInput) {
                        paymentReferenceInput.value = reference;
                    }
                    if (paymentStatusInputField) {
                        paymentStatusInputField.value = 'paid';
                    }
                    setPaymentStatus('success', `Pago simulado exitosamente. Referencia ${reference}. Ahora puedes confirmar la reserva.`);
                    simulateButton.disabled = false;
                }, 1200);
            });
        }

        if (toggleCardModeButton) {
            toggleCardModeButton.addEventListener('click', () => {
                usingSavedCard = !usingSavedCard;
                updateCardMode();
            });
        }

        updateCardMode();
});
</script>

</body>
</html>