<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Un moyen de paiement règle plusieurs commandes (doc §4.3).
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
