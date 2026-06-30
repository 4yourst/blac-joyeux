<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Page d'accueil / vitrine : mise en avant de la collection capsule
     * avec un focus sur le sac de bureau (doc §10.1).
     */
    public function index()
    {
        $products = Product::where('is_available', true)->get();

        // Le sac de bureau est la pièce mise en avant (doc §10.1).
        $featured = $products->firstWhere('slug', 'joyau-de-bla-sac-de-bureau') ?? $products->first();

        // Les autres modèles de la collection capsule.
        $others = $products->reject(fn ($product) => $featured && $product->is($featured))->values();

        return view('home', compact('featured', 'others'));
    }
}
