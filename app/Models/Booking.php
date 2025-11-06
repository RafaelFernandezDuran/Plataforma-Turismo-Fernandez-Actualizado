<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'tour_id',
        'company_id',
        'tour_date',
        'adult_participants',
        'child_participants',
        'adult_price',
        'child_price',
        'subtotal',
        'commission',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'participant_details',
        'special_requests',
        'notes',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason'
    ];

    protected $casts = [
        'tour_date' => 'date',
        'adult_price' => 'decimal:2',
        'child_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'commission' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'participant_details' => 'array',
        'special_requests' => 'array',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    // Relaciones
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Estados de reserva
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    // Estados de pago
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    // Helpers
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_CONFIRMED => 'badge-success',
            self::STATUS_CANCELLED => 'badge-danger',
            self::STATUS_COMPLETED => 'badge-info',
            default => 'badge-secondary'
        };
    }

    public function getPaymentStatusBadgeClass()
    {
        return match($this->payment_status) {
            self::PAYMENT_PENDING => 'badge-warning',
            self::PAYMENT_PAID => 'badge-success',
            self::PAYMENT_REFUNDED => 'badge-info',
            default => 'badge-secondary'
        };
    }
}
