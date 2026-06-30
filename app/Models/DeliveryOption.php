<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryOption extends Model
{
    protected $fillable = [
        'zone',
        'delay_days',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'delay_days' => 'integer',
            'price' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Une option de livraison concerne plusieurs commandes (doc §4.3).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
