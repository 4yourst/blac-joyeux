<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\ProductGallery;

class ProductController extends Controller
{
    /**
     * Fiche produit enrichie : caractéristiques, storytelling et données
     * structurées SEO (doc §10.2).
     */
    public function show(Product $product)
    {
        // Suggestions : autres modèles disponibles de la collection.
        $suggestions = Product::where('is_available', true)
            ->whereKeyNot($product->getKey())
            ->take(2)
            ->get();

        return view('products.show', [
            'product' => $product,
            'suggestions' => $suggestions,
            'gallery' => ProductGallery::forProduct($product),
        ]);
    }
}
