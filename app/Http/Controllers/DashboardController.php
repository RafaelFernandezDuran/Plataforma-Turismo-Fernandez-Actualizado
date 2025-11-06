<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\RecommendationService;

class DashboardController extends Controller
{
    protected RecommendationService $recommendations;

    public function __construct(RecommendationService $recommendations)
    {
        $this->recommendations = $recommendations;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->user_type) {
            'company_admin' => redirect()->route('company.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'tourist' => $this->touristDashboard($user),
            default => $this->touristDashboard($user),
        };
    }

    protected function touristDashboard($user)
    {
        $bookingsBaseQuery = $user->bookings();

        $totalBookings = (clone $bookingsBaseQuery)->count();

        $completedTours = (clone $bookingsBaseQuery)
            ->where('status', Booking::STATUS_COMPLETED)
            ->count();

        $upcomingBookingsQuery = (clone $bookingsBaseQuery)
            ->whereDate('tour_date', '>=', now()->startOfDay());

        $upcomingBookingsCount = (clone $upcomingBookingsQuery)->count();

        $upcomingBookings = (clone $upcomingBookingsQuery)
            ->with(['tour.category', 'company'])
            ->orderBy('tour_date')
            ->limit(5)
            ->get();

        $recentBookings = (clone $bookingsBaseQuery)
            ->with(['tour.category', 'company'])
            ->latest()
            ->limit(5)
            ->get();

        $reviewsCount = $user->reviews()->count();

        $recentReviews = $user->reviews()
            ->with('tour')
            ->latest()
            ->limit(3)
            ->get();

        $recommendedTours = $this->recommendations->forUser($user, 4);

        $favoriteCategories = $user->bookings()
            ->join('tours', 'bookings.tour_id', '=', 'tours.id')
            ->join('tour_categories', 'tours.tour_category_id', '=', 'tour_categories.id')
            ->select(
                'tour_categories.id',
                'tour_categories.name',
                'tour_categories.color',
                DB::raw('COUNT(bookings.id) as total')
            )
            ->groupBy('tour_categories.id', 'tour_categories.name', 'tour_categories.color')
            ->orderByDesc('total')
            ->limit(3)
            ->get()
            ->map(fn ($row) => [
                'id' => $row->id,
                'name' => $row->name,
                'color' => $row->color ?? '#3B82F6',
                'count' => (int) $row->total,
            ]);

        $monthlyRaw = (clone $bookingsBaseQuery)
            ->selectRaw('DATE_FORMAT(tour_date, "%Y-%m") as month_key, COUNT(*) as total')
            ->where('tour_date', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->pluck('total', 'month_key');

        $monthlyTrend = collect(range(5, 0))->map(function ($monthsAgo) use ($monthlyRaw) {
            $date = Carbon::now()->subMonths($monthsAgo);
            $key = $date->format('Y-m');

            return [
                'label' => $date->locale(app()->getLocale())->isoFormat('MMM YYYY'),
                'value' => (int) ($monthlyRaw[$key] ?? 0),
            ];
        });

        $averageRating = round((float) $user->reviews()->avg('rating'), 1);

        $profileFieldLabels = [
            'phone' => 'Teléfono',
            'birth_date' => 'Fecha de nacimiento',
            'nationality' => 'Nacionalidad',
            'document_type' => 'Tipo de documento',
            'document_number' => 'Número de documento',
            'preferences' => 'Preferencias de viaje',
        ];

        $completedProfileFields = collect($profileFieldLabels)
            ->reject(function ($label, $field) use ($user) {
                $value = $user->{$field};
                return empty($value) || ($field === 'preferences' && empty($value ?? []));
            });

        $profileCompletion = $profileFieldLabels
            ? round(($completedProfileFields->count() / count($profileFieldLabels)) * 100)
            : 100;

        $missingProfileFields = collect($profileFieldLabels)
            ->keys()
            ->diff($completedProfileFields->keys())
            ->map(fn ($key) => $profileFieldLabels[$key])
            ->values();

        $nextBooking = $upcomingBookings->first();

        $savedPaymentMethod = null;

        if ($user->card_token && $user->card_last_four) {
            $savedPaymentMethod = [
                'brand' => $user->card_brand,
                'last_four' => $user->card_last_four,
                'expiry' => $user->card_expiry,
                'holder' => $user->card_holder,
                'saved_at' => $user->card_saved_at,
            ];
        }

        return view('dashboard.tourist', [
            'user' => $user,
            'statistics' => [
                'total_bookings' => $totalBookings,
                'upcoming_bookings' => $upcomingBookingsCount,
                'completed_tours' => $completedTours,
                'reviews_written' => $reviewsCount,
                'average_rating' => $averageRating,
            ],
            'upcomingBookings' => $upcomingBookings,
            'recentBookings' => $recentBookings,
            'recentReviews' => $recentReviews,
            'recommendedTours' => $recommendedTours,
            'favoriteCategories' => $favoriteCategories,
            'monthlyTrend' => $monthlyTrend,
            'profile' => [
                'completion' => $profileCompletion,
                'missing_fields' => $missingProfileFields,
            ],
            'nextBooking' => $nextBooking,
            'savedPaymentMethod' => $savedPaymentMethod,
        ]);
    }

    public function storeSavedPaymentMethod(Request $request)
    {
        $user = $request->user();

        $validated = $request->validateWithBag('paymentMethod', [
            'card_number' => ['required', 'regex:/^(?:\d[\s-]?){12,19}$/'],
            'card_holder_name' => ['required', 'string', 'max:120'],
            'card_expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
        ], [
            'card_number.required' => 'Ingresa el número de la tarjeta.',
            'card_number.regex' => 'El número de tarjeta debe contener entre 12 y 19 dígitos.',
            'card_holder_name.required' => 'Ingresa el nombre del titular.',
            'card_expiry.required' => 'Ingresa la fecha de expiración.',
            'card_expiry.regex' => 'La fecha de expiración debe tener el formato MM/AA.',
        ]);

        $digits = preg_replace('/[^0-9]/', '', $validated['card_number']);

        if (strlen($digits) < 12 || strlen($digits) > 19) {
            return back()->withErrors([
                'card_number' => 'El número de tarjeta debe contener entre 12 y 19 dígitos reales.',
            ], 'paymentMethod')->withInput();
        }

        $brand = $this->detectCardBrand($digits);
        $lastFour = substr($digits, -4);
        $expiry = $validated['card_expiry'];
        $holder = mb_strtoupper($validated['card_holder_name']);

        $previousToken = $user->card_token;

        $user->forceFill([
            'card_token' => 'tok_dash_' . strtoupper(Str::random(24)),
            'card_brand' => $brand,
            'card_last_four' => $lastFour,
            'card_expiry' => $expiry,
            'card_holder' => $holder,
            'card_saved_at' => now(),
        ])->save();

        $message = $previousToken ? 'Tarjeta actualizada correctamente.' : 'Tarjeta guardada para próximos pagos.';

        return redirect()
            ->route('dashboard')
            ->with('payment_method_notice', $message);
    }

    public function destroySavedPaymentMethod(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->forceFill([
                'card_token' => null,
                'card_brand' => null,
                'card_last_four' => null,
                'card_expiry' => null,
                'card_holder' => null,
                'card_saved_at' => null,
            ])->save();
        }

        return redirect()
            ->route('dashboard')
            ->with('payment_method_notice', 'Tu tarjeta guardada se eliminó de forma segura.');
    }

    protected function detectCardBrand(string $digits): string
    {
        return match (true) {
            str_starts_with($digits, '4') => 'VISA',
            preg_match('/^5[1-5]/', $digits) === 1 => 'MASTERCARD',
            preg_match('/^3[47]/', $digits) === 1 => 'AMEX',
            preg_match('/^6(?:011|5)/', $digits) === 1 => 'DISCOVER',
            preg_match('/^(30[0-5]|36|38|39)/', $digits) === 1 => 'DINERS',
            default => 'CARD',
        };
    }
}
