<?php

namespace Database\Seeders;

use App\Models\DeliveryOption;
use Illuminate\Database\Seeder;

class DeliveryOptionSeeder extends Seeder
{
    /**
     * Options de livraison : zones, délais (1 à 3 jours) et tarifs (doc §4.1, §10.3).
     */
    public function run(): void
    {
        $options = [
            ['zone' => 'Abidjan — Cocody, Plateau, Marcory', 'delay_days' => 1, 'price' => 2000, 'is_active' => true],
            ['zone' => 'Abidjan — autres communes', 'delay_days' => 2, 'price' => 3000, 'is_active' => true],
            ['zone' => 'Intérieur de la Côte d\'Ivoire', 'delay_days' => 3, 'price' => 5000, 'is_active' => true],
        ];

        foreach ($options as $option) {
            DeliveryOption::create($option);
        }
    }
}
