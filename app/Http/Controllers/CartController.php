<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private Cart $cart)
    {
    }

    /**
     * Affiche le panier.
     */
    public function index()
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    /**
     * Ajoute un produit au panier (génère une intention d'achat, doc §10.3).
     */
    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_available, 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $this->cart->add($product->id, $validated['quantity'] ?? 1);

        return redirect()
            ->route('cart.index')
            ->with('status', $product->name.' a été ajouté à votre panier.');
    }

    /**
     * Met à jour la quantité d'une ligne.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:20'],
        ]);

        $this->cart->update($product->id, $validated['quantity']);

        return redirect()->route('cart.index');
    }

    /**
     * Retire une ligne du panier.
     */
    public function remove(Product $product)
    {
        $this->cart->remove($product->id);

        return redirect()->route('cart.index');
    }
}
