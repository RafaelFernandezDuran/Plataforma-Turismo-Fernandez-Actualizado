<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Reserva #{{ $booking->booking_number }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1f2937; margin: 0; padding: 32px; font-size: 12px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h1 { margin: 0; font-size: 20px; color: #1d4ed8; }
        .meta { margin-top: 8px; font-size: 12px; color: #6b7280; }
        .section { margin-bottom: 20px; border: 1px solid #d1d5db; border-radius: 8px; overflow: hidden; }
        .section-title { background: #f3f4f6; padding: 12px 16px; font-weight: 600; font-size: 13px; }
        .section-body { padding: 16px; }
        .grid { display: flex; flex-wrap: wrap; gap: 16px; }
        .grid-item { flex: 1 1 45%; }
        .label { display: block; font-size: 11px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
        .value { font-size: 13px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px 12px; border-bottom: 1px solid #e5e7eb; font-size: 12px; }
        th { background: #f3f4f6; text-align: left; font-weight: 600; }
        .totals { margin-top: 12px; }
        .totals-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
        .totals-row:last-child { font-weight: 700; font-size: 14px; border-top: 1px solid #d1d5db; margin-top: 6px; padding-top: 10px; }
        .status { display: inline-block; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .status.pending { background: #fef3c7; color: #b45309; }
    .status.confirmed { background: #dcfce7; color: #166534; }
    .status.cancelled { background: #fee2e2; color: #b91c1c; }
    .status.completed { background: #dbeafe; color: #1d4ed8; }
    .status.paid { background: #dcfce7; color: #15803d; }
    .status.refunded { background: #ede9fe; color: #6d28d9; }
        .logo { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .logo img { height: 48px; }
        .tour-image { width: 100%; max-height: 180px; object-fit: cover; border-radius: 6px; margin-bottom: 12px; }
        .footer { margin-top: 32px; font-size: 11px; color: #6b7280; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprobante de Reserva</h1>
        <div class="meta">
            <div>Reserva #{{ $booking->booking_number }}</div>
            <div>Generado el {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="section-body">
            <div class="logo">
                <div>
                    <span class="label">Cliente</span>
                    <div class="value">{{ $booking->user->name }}</div>
                    <div style="font-size: 11px; color: #6b7280;">{{ $booking->user->email }}</div>
                </div>
                <div style="text-align: right;">
                    <span class="label">Estado</span><br>
                    <span class="status {{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                    <span class="status {{ $booking->payment_status }}">Pago: {{ ucfirst($booking->payment_status) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detalles del Tour</div>
        <div class="section-body">
            @if(!empty($tourImageData))
                <img src="{{ $tourImageData }}" alt="{{ $booking->tour->title }}" class="tour-image">
            @endif
            <div class="grid">
                <div class="grid-item">
                    <span class="label">Tour</span>
                    <div class="value">{{ $booking->tour->title }}</div>
                </div>
                <div class="grid-item">
                    <span class="label">Empresa</span>
                    <div class="value">{{ $booking->tour->company->name ?? 'N/D' }}</div>
                </div>
                <div class="grid-item">
                    <span class="label">Fecha del Tour</span>
                    <div class="value">{{ $booking->tour_date->format('d/m/Y') }}</div>
                </div>
                <div class="grid-item">
                    <span class="label">Duración</span>
                    <div class="value">{{ $booking->tour->duration_days }} día(s)</div>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Participantes</div>
        <div class="section-body">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Edad</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @if(is_array($booking->participant_details))
                        @foreach($booking->participant_details as $index => $participant)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $participant['name'] ?? 'Sin nombre' }}</td>
                                <td>{{ $participant['document'] ?? 'N/A' }}</td>
                                <td>{{ $participant['age'] ?? 'N/A' }}</td>
                                <td>
                                    {{ $index < $booking->adult_participants ? 'Adulto' : 'Niño' }}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center;">No hay detalles de participantes disponibles.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Resumen de Pago</div>
        <div class="section-body">
            <div class="totals">
                <div class="totals-row">
                    <span>Adultos ({{ $booking->adult_participants }} x S/ {{ number_format($booking->adult_price, 2) }})</span>
                    <span>S/ {{ number_format($booking->adult_participants * $booking->adult_price, 2) }}</span>
                </div>
                @if($booking->child_participants > 0)
                    <div class="totals-row">
                        <span>Niños ({{ $booking->child_participants }} x S/ {{ number_format($booking->child_price, 2) }})</span>
                        <span>S/ {{ number_format($booking->child_participants * $booking->child_price, 2) }}</span>
                    </div>
                @endif
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span>S/ {{ number_format($booking->subtotal, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span>Comisión (10%)</span>
                    <span>S/ {{ number_format($booking->commission, 2) }}</span>
                </div>
                <div class="totals-row">
                    <span>Total a Pagar</span>
                    <span>S/ {{ number_format($booking->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($booking->special_requests && is_array($booking->special_requests) && count($booking->special_requests) > 0)
        <div class="section">
            <div class="section-title">Solicitudes Especiales</div>
            <div class="section-body">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach($booking->special_requests as $request)
                        <li>{{ $request }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="section">
        <div class="section-title">Historial</div>
        <div class="section-body">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 40%;">Creada</td>
                        <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($booking->confirmed_at)
                        <tr>
                            <td>Confirmada</td>
                            <td>{{ $booking->confirmed_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endif
                    @if($booking->cancelled_at)
                        <tr>
                            <td>Cancelada</td>
                            <td>
                                {{ $booking->cancelled_at->format('d/m/Y H:i') }}
                                @if($booking->cancellation_reason)
                                    <br><small>Motivo: {{ $booking->cancellation_reason }}</small>
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Gracias por reservar con Chanchamayo Tours.</p>
        <p>Contacto: +51 999 888 777 · info@chanchamayotours.com</p>
    </div>
</body>
</html>
