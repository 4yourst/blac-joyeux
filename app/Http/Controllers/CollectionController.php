<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CollectionController extends Controller
{
    /**
     * Page Collection : listing complet des produits.
     * La recherche et les filtres seront ajoutés à l'étape 4.
     */
    public function index()
    {
        $products = Product::where('is_available', true)->orderBy('name')->get();

        return view('collection', compact('products'));
    }
}
