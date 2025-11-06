<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourRecommendationStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'tour_category_id',
        'difficulty_level',
        'total_bookings',
        'completed_bookings',
        'cancelled_bookings',
        'average_rating',
        'calculated_at',
    ];

    protected $casts = [
        'calculated_at' => 'datetime',
        'average_rating' => 'float',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function category()
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }
}
