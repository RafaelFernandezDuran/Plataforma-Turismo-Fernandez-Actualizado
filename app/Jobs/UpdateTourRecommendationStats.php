<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourRecommendationStat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTourRecommendationStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tourId;

    public function __construct(int $tourId)
    {
        $this->tourId = $tourId;
    }

    public function handle(): void
    {
        $tour = Tour::query()->with('category')->find($this->tourId);

        if (!$tour) {
            return;
        }

        $bookingQuery = Booking::query()
            ->where('tour_id', $tour->id);

        $totals = (clone $bookingQuery)
            ->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as cancelled', [
                Booking::STATUS_COMPLETED,
                Booking::STATUS_CANCELLED,
            ])
            ->first();

        $averageRating = (float) ($tour->reviews()->avg('rating') ?? 0);

        TourRecommendationStat::query()->updateOrCreate(
            ['tour_id' => $tour->id],
            [
                'tour_category_id' => $tour->tour_category_id,
                'difficulty_level' => $tour->difficulty_level,
                'total_bookings' => (int) ($totals->total ?? 0),
                'completed_bookings' => (int) ($totals->completed ?? 0),
                'cancelled_bookings' => (int) ($totals->cancelled ?? 0),
                'average_rating' => round($averageRating, 2),
                'calculated_at' => now(),
            ]
        );
    }
}
