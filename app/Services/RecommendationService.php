<?php

namespace App\Services;

use App\Models\TourRecommendationStat;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    protected const CACHE_TTL_SECONDS = 1800; // 30 minutos

    public function forUser(User $user, int $limit = 4): Collection
    {
        if ($user->opt_out_recommendations ?? false) {
            return collect();
        }

        $cacheKey = $this->cacheKey($user->getKey(), $limit);

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($user, $limit) {
            $previousTourIds = $user->bookings()
                ->select('tour_id')
                ->pluck('tour_id')
                ->unique();

            $favoriteCategoryWeights = $this->favoriteCategoryWeights($user);

            $query = TourRecommendationStat::query()
                ->with(['tour.company', 'tour.category'])
                ->whereHas('tour', fn ($tourQuery) => $tourQuery->where('status', 'active'))
                ->whereNotIn('tour_id', $previousTourIds);

            if ($favoriteCategoryWeights->isNotEmpty()) {
                $query->whereIn('tour_category_id', $favoriteCategoryWeights->keys());
            }

            $stats = $query
                ->orderByDesc('completed_bookings')
                ->orderByDesc('average_rating')
                ->orderBy('cancelled_bookings')
                ->limit($limit * 2)
                ->get();

            $scored = $stats->map(function (TourRecommendationStat $stat) use ($favoriteCategoryWeights) {
                $categoryWeight = $favoriteCategoryWeights->get($stat->tour_category_id, 1);
                $score = (
                    ($stat->completed_bookings * 3)
                    + ($stat->total_bookings * 1.5)
                    + ($stat->average_rating * 2)
                    - ($stat->cancelled_bookings * 1.25)
                ) * $categoryWeight;

                return [
                    'stat' => $stat,
                    'score' => $score,
                ];
            })->sortByDesc('score')
              ->take($limit)
              ->values();

            return $scored->map(fn ($item) => $item['stat']->tour)->filter();
        });
    }

    public function invalidateForUser(int $userId): void
    {
        $keys = [4, 6, 8];

        foreach ($keys as $limit) {
            Cache::forget($this->cacheKey($userId, $limit));
        }
    }

    protected function cacheKey(int $userId, int $limit): string
    {
        return "recommendations:user:{$userId}:limit:{$limit}";
    }

    protected function favoriteCategoryWeights(User $user): Collection
    {
        $categories = $user->bookings()
            ->selectRaw('tours.tour_category_id, COUNT(*) as cnt')
            ->join('tours', 'bookings.tour_id', '=', 'tours.id')
            ->groupBy('tours.tour_category_id')
            ->orderByDesc('cnt')
            ->pluck('cnt', 'tours.tour_category_id');

        if ($categories->isEmpty()) {
            return collect();
        }

        $max = (float) $categories->max();

        return $categories->map(fn ($count) => $max ? round($count / $max, 2) + 0.5 : 1);
    }
}
