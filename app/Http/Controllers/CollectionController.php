<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Page Collection : listing complet + recherche (nom/description) et filtres
     * combinables par type et par collection (lot 5 §4).
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $type = $request->query('type');
        $collection = $request->query('collection');

        $types = config('blacjoyaux.product_types');
        $collections = config('blacjoyaux.collections');

        // On ignore un type / une collection hors liste.
        $type = in_array($type, $types, true) ? $type : null;
        $collection = in_array($collection, $collections, true) ? $collection : null;

        $products = Product::where('is_available', true)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', '%'.$q.'%')
                        ->orWhere('description', 'like', '%'.$q.'%');
                });
            })
            ->when($type, fn ($query) => $query->where('type', $type))
            ->when($collection, fn ($query) => $query->where('collection', $collection))
            ->orderBy('name')
            ->get();

        return view('collection', [
            'products' => $products,
            'q' => $q,
            'type' => $type,
            'collection' => $collection,
            'types' => $types,
            'collections' => $collections,
            'hasFilters' => $q !== '' || $type !== null || $collection !== null,
        ]);
    }
}
