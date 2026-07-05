<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Accueil éditorial : best-seller mis en avant + sélection restreinte de coups
     * de cœur, renvoyant vers la page Collection pour le catalogue complet.
     */
    public function index()
    {
        $products = Product::where('is_available', true)->get();

        // Le sac de bureau est la pièce phare / best-seller.
        $featured = $products->firstWhere('slug', 'joyau-de-bla-sac-de-bureau') ?? $products->first();

        $others = $products->reject(fn ($product) => $featured && $product->is($featured));

        // Sélection curated de coups de cœur (ordre privilégié), complétée si besoin.
        $curated = ['joyau-de-bla-tote-ashanti', 'collection-do-cartable-executif', 'joyau-de-bla-pochette'];

        $highlights = $others->whereIn('slug', $curated)
            ->merge($others->whereNotIn('slug', $curated))
            ->unique('id')
            ->take(3)
            ->values();

        return view('home', compact('featured', 'highlights'));
    }
}
