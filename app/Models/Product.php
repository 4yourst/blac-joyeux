<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'story',
        'dimensions',
        'material',
        'care',
        'image',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Un produit figure dans plusieurs lignes de commande (doc §4.3).
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
