<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Collection capsule Joyau de Bla — 2 à 3 modèles, focus sur le sac de bureau (doc §10.1).
     * Prix dans la fourchette 40 000 à 100 000 FCFA (doc §1.1).
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Joyau de Bla — Sac de bureau',
                'slug' => 'joyau-de-bla-sac-de-bureau',
                'price' => 85000,
                'description' => "Le sac de bureau de la collection Joyau de Bla : une allure structurée et premium, pensée pour la femme cadre urbaine. Compartiment ordinateur, finitions soignées et cuir de qualité.",
                'story' => "Inspirée de la poupée de fécondité ashanti, la collection Joyau de Bla célèbre l'héritage culturel ivoirien. Le sac de bureau en est la pièce maîtresse : il accompagne la femme active dans son quotidien tout en portant un récit de transmission et d'élégance.",
                'dimensions' => '38 × 28 × 12 cm',
                'material' => 'Cuir pleine fleur',
                'care' => "Nettoyer avec un chiffon doux et sec. Éviter l'exposition prolongée au soleil.",
                'image' => 'products/joyau-de-bla-sac-de-bureau.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Joyau de Bla — Cabas',
                'slug' => 'joyau-de-bla-cabas',
                'price' => 65000,
                'description' => "Un cabas spacieux et élégant, parfait pour conjuguer style et praticité au quotidien.",
                'story' => "Le cabas Joyau de Bla prolonge l'esprit de la collection : un volume généreux au service d'une silhouette épurée, fidèle à l'identité de la marque.",
                'dimensions' => '40 × 32 × 15 cm',
                'material' => 'Cuir grainé',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/joyau-de-bla-cabas.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Joyau de Bla — Pochette',
                'slug' => 'joyau-de-bla-pochette',
                'price' => 40000,
                'description' => "Une pochette raffinée pour les sorties, déclinaison compacte de la collection Joyau de Bla.",
                'story' => "Compacte mais affirmée, la pochette Joyau de Bla incarne l'élégance discrète, à porter en soirée comme au bureau.",
                'dimensions' => '24 × 14 × 6 cm',
                'material' => 'Cuir lisse',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/joyau-de-bla-pochette.jpg',
                'is_available' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
