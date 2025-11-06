<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'itinerary',
        'included_services',
        'excluded_services',
        'price',
        'child_price',
        'duration_days',
        'duration_hours',
        'min_participants',
        'max_participants',
        'difficulty_level',
        'gallery',
        'main_image',
        'latitude',
        'longitude',
        'meeting_points',
        'pickup_locations',
        'status',
        'is_featured',
        'rating',
        'total_reviews',
        'total_bookings',
        'views_count',
        'available_dates',
        'tags',
        'company_id',
        'tour_category_id',
    ];

    protected $casts = [
        'included_services' => 'array',
        'excluded_services' => 'array',
        'gallery' => 'array',
        'meeting_points' => 'array',
        'pickup_locations' => 'array',
        'available_dates' => 'array',
        'tags' => 'array',
        'price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_featured' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the company that owns the tour
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the category of the tour
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    /**
     * Get the bookings for the tour
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for the tour
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function recommendationStat()
    {
        return $this->hasOne(TourRecommendationStat::class);
    }

    /**
     * Scope for active tours
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for featured tours
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for tours by difficulty
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    /**
     * Scope for tours within price range
     */
    public function scopeInPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the main image URL
     */
    public function getMainImageUrlAttribute()
    {
        return $this->main_image ? asset('storage/' . $this->main_image) : null;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'S/ ' . number_format($this->price, 0);
    }

    /**
     * Get formatted child price
     */
    public function getFormattedChildPriceAttribute()
    {
        return $this->child_price ? 'S/ ' . number_format($this->child_price, 0) : null;
    }

    /**
     * Get difficulty level in Spanish
     */
    public function getDifficultyLevelSpanishAttribute()
    {
        $levels = [
            'easy' => 'Fácil',
            'moderate' => 'Moderado',
            'hard' => 'Difícil',
            'expert' => 'Experto'
        ];

        return $levels[$this->difficulty_level] ?? ucfirst($this->difficulty_level);
    }

    /**
     * Get status in Spanish
     */
    public function getStatusSpanishAttribute()
    {
        $statuses = [
            'active' => 'Activo',
            'inactive' => 'Inactivo',
            'draft' => 'Borrador'
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Check if tour has availability
     */
    public function hasAvailability()
    {
        return $this->status === 'active';
    }

    /**
     * Get average rating from reviews
     */
    public function calculateAverageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Update tour statistics
     */
    public function updateStatistics()
    {
        $this->update([
            'total_reviews' => $this->reviews()->count(),
            'rating' => $this->calculateAverageRating(),
            'total_bookings' => $this->bookings()->where('status', 'confirmed')->count(),
        ]);
    }

    /**
     * Get tour image URL or placeholder class
     */
    public function getImageUrlAttribute()
    {
        if ($this->main_image) {
            // Si es una URL externa, la devolvemos directamente
            if (filter_var($this->main_image, FILTER_VALIDATE_URL)) {
                return $this->main_image;
            }

            $normalizedPath = ltrim($this->main_image, '/');

            // Si la ruta apunta al directorio public, usamos asset directo
            if (str_starts_with($normalizedPath, 'images/')) {
                return asset($normalizedPath);
            }

            // Si es un archivo almacenado en storage/app/public
            return asset('storage/' . $normalizedPath);
        }
        
        return null;
    }

    /**
     * Get gallery image URLs with proper asset resolution
     */
    public function getGalleryUrlsAttribute(): array
    {
        if (!is_array($this->gallery) || empty($this->gallery)) {
            return [];
        }

        return collect($this->gallery)
            ->filter()
            ->map(function ($image) {
                if (filter_var($image, FILTER_VALIDATE_URL)) {
                    return $image;
                }

                $normalizedPath = ltrim($image, '/');

                if (str_starts_with($normalizedPath, 'images/')) {
                    return asset($normalizedPath);
                }

                return asset('storage/' . $normalizedPath);
            })
            ->values()
            ->all();
    }

    /**
     * Get optimized image URL with fallback
     */
    public function getOptimizedImageAttribute()
    {
        $imageUrl = $this->image_url;
        
        if ($imageUrl) {
            // Si es una URL de Unsplash, agregarle parámetros de optimización
            if (str_contains($imageUrl, 'unsplash.com')) {
                return $imageUrl . '&auto=format&fit=crop&w=800&h=600&q=80';
            }
            
            return $imageUrl;
        }
        
        return null;
    }

    /**
     * Get placeholder class based on category
     */
    public function getPlaceholderClassAttribute()
    {
        $categorySlug = strtolower($this->category->slug ?? 'default');
        
        return match($categorySlug) {
            'aventura', 'adventure' => 'aventura',
            'ecoturismo', 'eco', 'naturaleza' => 'ecoturismo', 
            'gastronomico', 'gastronomia', 'food' => 'gastronomico',
            'cultural', 'cultura', 'history' => 'cultural',
            'relax', 'wellness', 'spa' => 'relax',
            default => 'default'
        };
    }

    /**
     * Get icon class based on category
     */
    public function getIconClassAttribute()
    {
        $categorySlug = strtolower($this->category->slug ?? 'default');
        
        return match($categorySlug) {
            'aventura', 'adventure' => 'fa-mountain',
            'ecoturismo', 'eco', 'naturaleza' => 'fa-leaf',
            'gastronomico', 'gastronomia', 'food' => 'fa-utensils',
            'cultural', 'cultura', 'history' => 'fa-landmark',
            'relax', 'wellness', 'spa' => 'fa-spa',
            default => 'fa-map-marked-alt'
        };
    }
}
