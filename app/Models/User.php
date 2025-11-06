<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birth_date',
        'nationality',
        'document_type',
        'document_number',
        'user_type',
        'preferences',
    'opt_out_recommendations',
        'avatar',
        'language',
        'newsletter_subscription',
        'last_activity',
        'card_token',
        'card_brand',
        'card_last_four',
        'card_expiry',
        'card_holder',
        'card_saved_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'card_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'preferences' => 'array',
            'newsletter_subscription' => 'boolean',
            'opt_out_recommendations' => 'boolean',
            'last_activity' => 'datetime',
            'card_saved_at' => 'datetime',
        ];
    }

    // Relaciones
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopeTourists($query)
    {
        return $query->where('user_type', 'tourist');
    }

    public function scopeCompanyAdmins($query)
    {
        return $query->where('user_type', 'company_admin');
    }

    // Mutators
    public function getFullDocumentAttribute()
    {
        return $this->document_type . ': ' . $this->document_number;
    }
}
