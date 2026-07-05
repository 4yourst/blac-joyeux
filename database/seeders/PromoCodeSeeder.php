<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Code promo de démonstration (lot 5 §10) — actif quelques jours pour tester
     * la bannière et l'application au panier.
     */
    public function run(): void
    {
        PromoCode::updateOrCreate(
            ['code' => 'BLAC30'],
            [
                'discount_percent' => 30,
                'starts_at' => now()->subDay(),
                'ends_at' => now()->addDays(5),
                'is_active' => true,
            ]
        );
    }
}
