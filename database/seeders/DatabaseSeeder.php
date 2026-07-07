<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Support\ProductGallery;
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
            DemoCatalogSeeder::class,
            DeliveryOptionSeeder::class,
            PaymentMethodSeeder::class,
            PromoCodeSeeder::class,
        ]);

        // Chaque produit prend comme visuel la couverture de son dossier catalog-NN,
        // afin que vignettes panier/admin et SEO utilisent les vraies photos.
        $this->assignCatalogCovers();
    }

    private function assignCatalogCovers(): void
    {
        foreach (Product::all() as $product) {
            if ($cover = ProductGallery::coverPath($product)) {
                $product->update(['image' => $cover]);
            }
        }
    }
}
