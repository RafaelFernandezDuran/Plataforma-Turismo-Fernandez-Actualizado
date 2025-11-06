<x-app-layout>
	@push('styles')
		@vite('resources/css/dashboard.css')
	@endpush

	<x-slot name="header">
		<div class="page-header">
			<h1>Tu panel de viajes</h1>
			<p>Consulta tus próximas experiencias, métricas clave y recomendaciones personalizadas.</p>
		</div>
	</x-slot>

	@php
		$statusMap = [
			'pending' => 'status-pill status-pill--pending',
			'processing' => 'status-pill status-pill--pending',
			'confirmed' => 'status-pill status-pill--confirmed',
			'completed' => 'status-pill status-pill--completed',
			'cancelled' => 'status-pill status-pill--cancelled',
			'canceled' => 'status-pill status-pill--canceled',
		];

		$totalBookings = $statistics['total_bookings'] ?? 0;
		$upcomingCount = $statistics['upcoming_bookings'] ?? 0;
		$completedCount = $statistics['completed_tours'] ?? 0;
		$reviewsWritten = $statistics['reviews_written'] ?? 0;
		$averageRating = number_format($statistics['average_rating'] ?? 0, 1);
		$profileCompletion = $profile['completion'] ?? 0;
		$missingFields = $profile['missing_fields'] ?? collect();
		$nextBooking = $upcomingBookings->first();
	@endphp

	<div class="dashboard">
		<div class="dashboard__container">
			<section>
				<h2 class="section-title">Resumen rápido</h2>
				<div class="summary-grid">
					<article class="summary-card">
						<span class="summary-card__label">Reservas totales</span>
						<span class="summary-card__value">{{ $totalBookings }}</span>
						<p class="summary-card__meta">Historial acumulado desde tu primera reserva.</p>
					</article>
					<article class="summary-card">
						<span class="summary-card__label">Próximas reservas</span>
						<span class="summary-card__value">{{ $upcomingCount }}</span>
						@if($nextBooking)
							<p class="summary-card__meta">Tu siguiente salida es el {{ optional($nextBooking->tour_date)->translatedFormat('d \d\e F, Y') }}.</p>
						@else
							<p class="summary-card__meta">Reserva una experiencia para activar este indicador.</p>
						@endif
					</article>
					<article class="summary-card">
						<span class="summary-card__label">Tours completados</span>
						<span class="summary-card__value">{{ $completedCount }}</span>
						<p class="summary-card__meta">Gracias por seguir viajando con nosotros.</p>
					</article>
					<article class="summary-card">
						<span class="summary-card__label">Valoración promedio</span>
						<span class="summary-card__value">{{ $averageRating }}</span>
						<p class="summary-card__meta">Basado en {{ $reviewsWritten }} reseña(s) que has dejado.</p>
					</article>
				</div>
			</section>

			<section class="tiled-card">
				<div class="card__header">
					<h3>Próximas actividades</h3>
					<a class="link-button" href="{{ route('bookings.index') }}">Ver todas tus reservas</a>
				</div>
				@if($upcomingBookings->isEmpty())
					<div class="empty-state">
						Aún no tienes salidas agendadas. Explora el catálogo de tours para planear tu próxima experiencia.
					</div>
				@else
					<div class="tile-list">
						@foreach($upcomingBookings as $booking)
							<article class="booking-tile">
								<div class="booking-tile__date">
									<span>{{ $booking->tour_date?->translatedFormat('d M Y') ?? 'Fecha por confirmar' }}</span>
									<span class="{{ $statusMap[strtolower($booking->status)] ?? 'status-pill' }}">{{ ucfirst($booking->status) }}</span>
								</div>
								<div class="booking-tile__body">
									<h4>{{ $booking->tour?->title ?? 'Tour por definir' }}</h4>
									<p>Operado por {{ $booking->company?->name ?? 'Empresa no registrada' }}</p>
									<p>Última actualización {{ $booking->updated_at?->diffForHumans() }}</p>
								</div>
							</article>
						@endforeach
					</div>
				@endif
			</section>

			<section class="table-card">
				<div class="card__header">
					<div>
						<h3>Historial reciente</h3>
						<p class="card__subtitle">Tus cinco reservas más recientes y su estado actual.</p>
					</div>
				</div>
				<div class="table-wrapper">
					<table class="data-table">
						<thead>
							<tr>
								<th>Tour</th>
								<th>Empresa</th>
								<th>Fecha</th>
								<th>Monto</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							@forelse($recentBookings as $booking)
								<tr>
									<td>
										<strong>{{ $booking->tour?->title ?? 'Tour por definir' }}</strong>
										<div class="card__subtitle">Creado {{ $booking->created_at?->diffForHumans() }}</div>
									</td>
									<td>{{ $booking->company?->name ?? 'Por confirmar' }}</td>
									<td>{{ $booking->tour_date?->translatedFormat('d M Y') ?? 'Pendiente' }}</td>
									<td>
										@if($booking->total_amount)
											S/ {{ number_format($booking->total_amount, 2) }}
										@else
											<span class="card__subtitle">Por confirmar</span>
										@endif
									</td>
									<td>
										<span class="{{ $statusMap[strtolower($booking->status)] ?? 'status-pill' }}">{{ ucfirst($booking->status) }}</span>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5">
										<div class="empty-state">No registramos reservas recientes. ¡Inicia una nueva aventura!</div>
									</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</section>

			<section>
				<div class="card__header">
					<h3>Tours recomendados para ti</h3>
					<a class="link-button" href="{{ route('tours.index') }}">Explorar catálogo completo</a>
				</div>
				@if($recommendedTours->isEmpty())
					<div class="empty-state">
						Aún no contamos con recomendaciones personalizadas. Completa tu perfil y realiza reservas para recibir sugerencias.
					</div>
				@else
					<div class="tour-grid">
						@foreach($recommendedTours as $tour)
							@php
								$imageUrl = $tour->optimized_image ?? $tour->image_url ?? 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=800&q=80';
							@endphp
							<article class="tour-card">
								<div class="tour-card__image">
									<img src="{{ $imageUrl }}" alt="Imagen del tour {{ $tour->title }}">
								</div>
								<div class="tour-card__body">
									<h4>{{ $tour->title }}</h4>
									<p>{{ $tour->category?->name ?? 'Categoría desconocida' }} • Operado por {{ $tour->company?->name ?? 'N/A' }}</p>
									<div class="tour-card__meta">
										<span>Desde <strong>S/ {{ number_format($tour->price, 2) }}</strong></span>
										<span>{{ ucfirst($tour->difficulty_level ?? 'n/a') }}</span>
									</div>
									<div class="tour-card__meta">
										<span>⭐ {{ number_format($tour->rating, 1) }} ({{ $tour->total_reviews }} reseñas)</span>
										<span>{{ $tour->duration_days }} día(s)</span>
									</div>
									<a class="button-secondary" href="{{ route('tours.show', $tour) }}">Ver detalles del tour</a>
								</div>
							</article>
						@endforeach
					</div>
				@endif
			</section>

			<section class="dashboard-grid-two-columns">
				<article class="card payment-card">
					<div class="card__header">
						<div>
							<h3>Método de pago guardado</h3>
							<p class="card__subtitle">Gestiona la tarjeta que usas para confirmar tus reservas.</p>
						</div>
						@if($savedPaymentMethod)
							<span class="pill">Terminada en {{ $savedPaymentMethod['last_four'] }}</span>
						@endif
					</div>

					@if(session('payment_method_notice'))
						<div class="empty-state" style="background: rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.25); color: #047857;">
							{{ session('payment_method_notice') }}
						</div>
					@endif

					@if($savedPaymentMethod)
						<div class="badge-list" style="margin-bottom: 1.2rem;">
							<span class="badge"><span class="badge__dot" style="background:#16a34a;"></span>{{ strtoupper($savedPaymentMethod['brand'] ?? 'Tarjeta') }}</span>
							<span class="badge"><span class="badge__dot" style="background:#10b981;"></span>Titular: {{ $savedPaymentMethod['holder'] ?? 'No registrado' }}</span>
							@if(!empty($savedPaymentMethod['expiry']))
								<span class="badge"><span class="badge__dot" style="background:#f97316;"></span>Expira {{ $savedPaymentMethod['expiry'] }}</span>
							@endif
							@if(!empty($savedPaymentMethod['saved_at']))
								<span class="badge"><span class="badge__dot" style="background:#0f766e;"></span>Guardada {{ $savedPaymentMethod['saved_at']->locale(app()->getLocale())->diffForHumans() }}</span>
							@endif
						</div>
						<form method="POST" action="{{ route('payment-method.destroy') }}" onsubmit="return confirm('¿Seguro que deseas eliminar la tarjeta almacenada?');" style="margin-bottom:1.5rem;">
							@csrf
							@method('DELETE')
							<button type="submit" class="button-secondary" style="color: var(--danger); border-color: rgba(239, 68, 68, 0.35); background: rgba(239, 68, 68, 0.12);">
								Eliminar tarjeta guardada
							</button>
						</form>
					@else
						<div class="empty-state" style="margin-bottom: 1.4rem;">
							Aún no guardas una tarjeta. Agrégala aquí para agilizar tus próximos pagos.
						</div>
					@endif

					<h4 class="section-title" style="margin-bottom: 0.8rem; font-size: 1rem;">{{ $savedPaymentMethod ? 'Actualizar tarjeta' : 'Guardar una nueva tarjeta' }}</h4>
					<p class="form-hint" style="margin-bottom: 1.2rem;">Conservamos solo un token cifrado, la marca y los últimos 4 dígitos. Jamás almacenamos el CVV.</p>

					<form method="POST" action="{{ route('payment-method.store') }}">
						@csrf
						<div class="form-control">
							<label for="dashboardCardNumber">Número de tarjeta</label>
							<input id="dashboardCardNumber" name="card_number" autocomplete="off" inputmode="numeric" maxlength="23" placeholder="0000 0000 0000 0000" value="{{ old('card_number') }}">
							@error('card_number', 'paymentMethod')
								<p class="error-text">{{ $message }}</p>
							@enderror
						</div>
						<div class="form-control">
							<label for="dashboardCardHolder">Nombre del titular</label>
							<input id="dashboardCardHolder" name="card_holder_name" maxlength="120" autocomplete="off" placeholder="Como aparece en la tarjeta" value="{{ old('card_holder_name', $savedPaymentMethod['holder'] ?? '') }}">
							@error('card_holder_name', 'paymentMethod')
								<p class="error-text">{{ $message }}</p>
							@enderror
						</div>
						<div class="form-control">
							<label for="dashboardCardExpiry">Expiración (MM/AA)</label>
							<input id="dashboardCardExpiry" name="card_expiry" inputmode="numeric" maxlength="5" autocomplete="off" placeholder="MM/AA" value="{{ old('card_expiry', $savedPaymentMethod['expiry'] ?? '') }}">
							@error('card_expiry', 'paymentMethod')
								<p class="error-text">{{ $message }}</p>
							@enderror
						</div>
						<div class="form-control" style="grid-column: 1 / -1;">
							<button type="submit" class="button-primary">{{ $savedPaymentMethod ? 'Actualizar tarjeta' : 'Guardar tarjeta' }}</button>
						</div>
					</form>
				</article>

				<article class="card profile-progress">
					<div class="card__header">
						<div>
							<h3>Completa tu perfil</h3>
							<p class="card__subtitle">Un perfil completo mejora la precisión de tus recomendaciones.</p>
						</div>
					</div>
					<div class="progress-bar">
						<div class="progress-bar__fill" style="width: {{ $profileCompletion }}%;"></div>
					</div>
					<p class="card__subtitle">Tu progreso actual es del {{ $profileCompletion }}%.</p>
					@if($missingFields->isNotEmpty())
						<div class="tiled-card" style="padding: 0; box-shadow: none; border: none; gap: 0.6rem;">
							<h4 class="section-title" style="font-size: 0.95rem; margin:0;">Campos pendientes</h4>
							<ul style="list-style: none; padding: 0; margin: 0; display: grid; gap: 0.4rem;">
								@foreach($missingFields as $field)
									<li class="badge" style="width: fit-content;">
										<span class="badge__dot" style="background: var(--accent);"></span>
										{{ $field }}
									</li>
								@endforeach
							</ul>
						</div>
					@else
						<div class="empty-state" style="background: rgba(22, 163, 74, 0.12); border-color: rgba(22, 163, 74, 0.25); color: #166534;">¡Excelente! Tu perfil está completo.</div>
					@endif
					<a class="button-secondary" href="{{ route('profile.edit') }}">Actualizar datos personales</a>
				</article>
			</section>

			<section class="dashboard-grid-two-columns">
				<article class="card">
					<div class="card__header">
						<div>
							<h3>Tus categorías favoritas</h3>
							<p class="card__subtitle">Según la frecuencia de tus reservas.</p>
						</div>
					</div>
					@if($favoriteCategories->isEmpty())
						<div class="empty-state">Aún no detectamos preferencias. Reserva algunos tours y te mostraremos tus categorías destacadas.</div>
					@else
						<div class="badge-list">
							@foreach($favoriteCategories as $category)
								<span class="badge">
									<span class="badge__dot" style="background: {{ $category['color'] }};"></span>
									{{ $category['name'] }} · {{ $category['count'] }} reserva(s)
								</span>
							@endforeach
						</div>
					@endif
				</article>

				<article class="card trend-card">
					<div class="card__header">
						<div>
							<h3>Tendencia de reservas</h3>
							<p class="card__subtitle">Comparativa de los últimos seis meses.</p>
						</div>
					</div>
					<div class="trend-chart">
						<canvas id="bookingsTrendChart"></canvas>
					</div>
				</article>
			</section>

			<section>
				<div class="card__header">
					<h3>Tus reseñas recientes</h3>
					<p class="card__subtitle">Comparte tus experiencias para ayudar a otros viajeros.</p>
				</div>
				@if($recentReviews->isEmpty())
					<div class="empty-state">Todavía no has publicado reseñas. Después de cada tour, deja tu opinión para mejorar tus recomendaciones.</div>
				@else
					<div class="review-grid">
						@foreach($recentReviews as $review)
							<article class="review-card">
								<div class="review-card__rating">⭐ {{ $review->rating }}/5</div>
								<h4>{{ $review->tour?->title ?? 'Tour' }}</h4>
								<p class="review-card__comment">{{ \Illuminate\Support\Str::limit($review->comment, 160, '...') }}</p>
								<span class="card__subtitle">Publicado {{ $review->created_at?->diffForHumans() }}</span>
							</article>
						@endforeach
					</div>
				@endif
			</section>
		</div>
	</div>
</x-app-layout>

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" integrity="sha384-17PCze6+Us8aq7eu+6jkws/hAu8CvaGfpEgqs3vSVUZZdxZdflPaMTGKBhF0s18P" crossorigin="anonymous"></script>
	<script>
		const trendCanvas = document.getElementById('bookingsTrendChart');
		if (trendCanvas) {
			const trendData = @json($monthlyTrend);
			const labels = trendData.map(point => point.label);
			const values = trendData.map(point => point.value);

			const context = trendCanvas.getContext('2d');
			const gradient = context.createLinearGradient(0, 0, 0, 280);
			gradient.addColorStop(0, 'rgba(22, 163, 74, 0.38)');
			gradient.addColorStop(1, 'rgba(22, 163, 74, 0)');

			new Chart(context, {
				type: 'line',
				data: {
					labels,
					datasets: [{
						label: 'Reservas por mes',
						data: values,
						borderColor: 'rgba(22, 163, 74, 1)',
						backgroundColor: gradient,
						pointBackgroundColor: '#16a34a',
						pointBorderColor: '#16a34a',
						borderWidth: 2,
						fill: true,
						tension: 0.38,
					}],
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					scales: {
						y: {
							beginAtZero: true,
							ticks: {
								precision: 0,
								color: '#4b5563',
								font: { size: 12 },
							},
							grid: {
								color: 'rgba(34, 197, 94, 0.12)',
							},
						},
						x: {
							ticks: {
								color: '#4b5563',
								font: { size: 12 },
							},
							grid: { display: false },
						},
					},
					plugins: {
						legend: { display: false },
						tooltip: {
							backgroundColor: '#111827',
							cornerRadius: 8,
							padding: 10,
							callbacks: {
								label: (context) => ` ${context.parsed.y} reserva(s)`
							}
						}
					}
				}
			});
		}

		const cardNumberInput = document.getElementById('dashboardCardNumber');
		const cardExpiryInput = document.getElementById('dashboardCardExpiry');
		const cardHolderInput = document.getElementById('dashboardCardHolder');

		if (cardNumberInput) {
			const formatNumber = (value) => value
				.replace(/[^0-9]/g, '')
				.slice(0, 19)
				.replace(/(.{4})/g, '$1 ')
				.trim();

			cardNumberInput.addEventListener('input', (event) => {
				event.target.value = formatNumber(event.target.value);
			});
		}

		if (cardExpiryInput) {
			cardExpiryInput.addEventListener('input', (event) => {
				const digits = event.target.value.replace(/[^0-9]/g, '').slice(0, 4);
				event.target.value = digits.length <= 2 ? digits : `${digits.slice(0, 2)}/${digits.slice(2)}`;
			});
		}

		if (cardHolderInput) {
			cardHolderInput.addEventListener('input', (event) => {
				event.target.value = event.target.value.toUpperCase();
			});
		}
	</script>
@endpush

