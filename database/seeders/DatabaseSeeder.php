<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Compte administrateur de démonstration (back-office, doc §5.1)
        User::firstOrCreate(
            ['email' => 'admin@blacjoyaux.ci'],
            [
                'name' => 'Administrateur Blac Joyaux',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            ProductSeeder::class,
            DeliveryOptionSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
