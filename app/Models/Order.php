<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'customer_address',
        'delivery_option_id',
        'payment_method_id',
        'total_amount',
        'conversion_channel',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'integer',
        ];
    }

    /**
     * Une commande est rattachée à une option de livraison (doc §4.3).
     */
    public function deliveryOption(): BelongsTo
    {
        return $this->belongsTo(DeliveryOption::class);
    }

    /**
     * Une commande peut être rattachée à un moyen de paiement (nullable, doc §4.2).
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Une commande contient plusieurs lignes de commande (doc §4.3).
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
