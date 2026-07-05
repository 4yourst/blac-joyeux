<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'discount_percent',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_percent' => 'integer',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Codes actifs dont la fenêtre inclut l'instant présent.
     */
    public function scopeCurrentlyValid(Builder $query): Builder
    {
        $now = now();

        return $query->where('is_active', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now);
    }

    /**
     * Retourne un code valide correspondant (insensible à la casse), ou null.
     */
    public static function findValid(string $code): ?self
    {
        $code = mb_strtolower(trim($code));

        if ($code === '') {
            return null;
        }

        return static::query()
            ->whereRaw('LOWER(code) = ?', [$code])
            ->currentlyValid()
            ->first();
    }
}
