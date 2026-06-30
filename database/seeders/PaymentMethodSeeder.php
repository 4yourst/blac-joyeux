<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Moyens de paiement : Wave, Orange Money, MTN, Moov (mobile money simulé)
     * et espèces à la livraison (doc §4.1, §1.4).
     */
    public function run(): void
    {
        $methods = [
            ['name' => 'Wave', 'code' => 'wave', 'type' => 'mobile_money', 'is_active' => true],
            ['name' => 'Orange Money', 'code' => 'orange_money', 'type' => 'mobile_money', 'is_active' => true],
            ['name' => 'MTN Money', 'code' => 'mtn', 'type' => 'mobile_money', 'is_active' => true],
            ['name' => 'Moov Money', 'code' => 'moov', 'type' => 'mobile_money', 'is_active' => true],
            ['name' => 'Espèces à la livraison', 'code' => 'cash', 'type' => 'cash', 'is_active' => true],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
