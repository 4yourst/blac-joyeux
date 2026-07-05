<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DemoCatalogSeeder extends Seeder
{
    /**
     * Produits de démonstration pour étoffer le catalogue (lot 5 §2) — 9 modèles
     * répartis sur plusieurs types et deux collections, afin de tester filtres et
     * recherche. Prix réalistes (40 000 – 100 000 FCFA).
     *
     * Visuels : placeholders Unsplash (licence libre) — PAS les vrais produits
     * Blac Joyaux, à remplacer par les photos de la créa.
     *
     * updateOrCreate par slug : ré-exécutable sans créer de doublon.
     */
    public function run(): void
    {
        foreach ($this->products() as $data) {
            Product::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function products(): array
    {
        return [
            [
                'name' => 'Joyau de Bla — Sac soirée Éclat',
                'slug' => 'joyau-de-bla-soiree-eclat',
                'type' => 'soirée',
                'collection' => 'Joyau de Bla',
                'price' => 58000,
                'description' => "Un sac de soirée compact et raffiné, à la chaîne délicate. Juste ce qu'il faut pour l'essentiel, avec beaucoup d'allure.",
                'story' => "Éclat prolonge l'esprit Joyau de Bla dans la nuit : une pièce précieuse, pensée pour accompagner les moments qui comptent.",
                'dimensions' => '22 × 13 × 6 cm',
                'material' => 'Cuir lisse',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/catalog-03.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Joyau de Bla — Tote Ashanti',
                'slug' => 'joyau-de-bla-tote-ashanti',
                'type' => 'tote',
                'collection' => 'Joyau de Bla',
                'price' => 72000,
                'description' => "Un grand tote en cuir tressé, généreux et structuré, qui porte le quotidien avec élégance.",
                'story' => "Le tressage évoque le savoir-faire transmis de génération en génération — l'héritage ashanti, tissé dans la matière.",
                'dimensions' => '42 × 34 × 14 cm',
                'material' => 'Cuir tressé',
                'care' => 'Nettoyer avec un chiffon doux et sec. Éviter l\'humidité prolongée.',
                'image' => 'products/catalog-01.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Joyau de Bla — Pochette Perle',
                'slug' => 'joyau-de-bla-pochette-perle',
                'type' => 'pochette',
                'collection' => 'Joyau de Bla',
                'price' => 45000,
                'description' => "Une pochette bandoulière camel, douce et intemporelle, à porter du matin au soir.",
                'story' => "Perle incarne la simplicité précieuse : un compagnon discret qui ne quitte plus votre épaule.",
                'dimensions' => '24 × 16 × 7 cm',
                'material' => 'Cuir grainé',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/catalog-02.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Collection DO — Cartable Exécutif',
                'slug' => 'collection-do-cartable-executif',
                'type' => 'bureau',
                'collection' => 'Collection DO',
                'price' => 96000,
                'description' => "Un cartable structuré haut de gamme, pensé pour la femme de pouvoir : compartiment ordinateur, finitions impeccables.",
                'story' => "La Collection DO signe une ligne urbaine et affirmée. L'Exécutif en est la pièce d'autorité, sobre et magistrale.",
                'dimensions' => '39 × 29 × 12 cm',
                'material' => 'Cuir pleine fleur',
                'care' => "Nettoyer avec un chiffon doux et sec. Éviter l'exposition prolongée au soleil.",
                'image' => 'products/catalog-05.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Collection DO — Cabas Lagune',
                'slug' => 'collection-do-cabas-lagune',
                'type' => 'cabas',
                'collection' => 'Collection DO',
                'price' => 69000,
                'description' => "Un cabas épuré et léger, à la ligne moderne, idéal pour la ville comme pour l'escapade.",
                'story' => "Lagune respire la douceur d'Abidjan : un cabas clair et fluide, pour avancer léger.",
                'dimensions' => '40 × 33 × 15 cm',
                'material' => 'Cuir souple',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/catalog-06.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Collection DO — Pochette Nuit',
                'slug' => 'collection-do-pochette-nuit',
                'type' => 'soirée',
                'collection' => 'Collection DO',
                'price' => 52000,
                'description' => "Une pochette de soirée au motif délicat, pour une touche artistique qui capte le regard.",
                'story' => "Nuit ose la fantaisie maîtrisée : une pièce statement de la Collection DO, à la fois libre et élégante.",
                'dimensions' => '26 × 15 × 6 cm',
                'material' => 'Cuir imprimé',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/catalog-04.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Collection DO — Tote Abidjan',
                'slug' => 'collection-do-tote-abidjan',
                'type' => 'tote',
                'collection' => 'Collection DO',
                'price' => 64000,
                'description' => "Un tote spacieux en cuir tressé, robuste et raffiné, taillé pour le rythme de la ville.",
                'story' => "Abidjan porte le nom de la ville qui ne dort jamais : un tote qui suit toutes vos cadences.",
                'dimensions' => '43 × 35 × 15 cm',
                'material' => 'Cuir tressé',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/catalog-01.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Collection DO — Sac soirée Gala',
                'slug' => 'collection-do-soiree-gala',
                'type' => 'soirée',
                'collection' => 'Collection DO',
                'price' => 82000,
                'description' => "Un sac de soirée sophistiqué à la chaîne bijou, pour les grandes occasions.",
                'story' => "Gala est la pièce des soirs d'exception : discrète le jour, éblouissante la nuit.",
                'dimensions' => '23 × 14 × 6 cm',
                'material' => 'Cuir lisse',
                'care' => 'Nettoyer avec un chiffon doux et sec.',
                'image' => 'products/catalog-03.jpg',
                'is_available' => true,
            ],
            [
                'name' => 'Collection DO — Bureau Cadre',
                'slug' => 'collection-do-bureau-cadre',
                'type' => 'bureau',
                'collection' => 'Collection DO',
                'price' => 90000,
                'description' => "Un sac de bureau à l'allure affirmée, structuré et spacieux, pour porter vos journées avec assurance.",
                'story' => "Cadre accompagne les ambitions : une pièce de caractère, pensée pour durer.",
                'dimensions' => '38 × 28 × 12 cm',
                'material' => 'Cuir pleine fleur',
                'care' => "Nettoyer avec un chiffon doux et sec. Éviter l'exposition prolongée au soleil.",
                'image' => 'products/catalog-05.jpg',
                'is_available' => true,
            ],
        ];
    }
}
