<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private Cart $cart)
    {
    }

    /**
     * Page de finalisation : choix de la livraison + saisie des coordonnées (doc §3.2, §10.3).
     */
    public function create()
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index');
        }

        return view('checkout.create', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'deliveryOptions' => DeliveryOption::where('is_active', true)->orderBy('price')->get(),
        ]);
    }

    /**
     * Enregistre systématiquement la commande comme intention d'achat,
     * avant le choix de la voie de conversion (doc §3.2, §3.4).
     */
    public function store(Request $request)
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_address' => ['required', 'string', 'max:500'],
            'delivery_option_id' => ['required', 'exists:delivery_options,id'],
        ]);

        $deliveryOption = DeliveryOption::findOrFail($validated['delivery_option_id']);
        $items = $this->cart->items();
        $total = $this->cart->subtotal() + $deliveryOption->price;

        // Transaction : la commande et ses lignes sont enregistrées de façon atomique.
        $order = DB::transaction(function () use ($validated, $deliveryOption, $items, $total) {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'delivery_option_id' => $deliveryOption->id,
                'payment_method_id' => null,        // Défini plus tard (voie Mobile Money), nullable (doc §4.2)
                'total_amount' => $total,
                'conversion_channel' => null,       // Renseigné au choix de la voie (doc §3.2)
                'status' => 'pending',
            ]);

            foreach ($items as $line) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $line['product']->id,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['product']->price,
                ]);
            }

            return $order;
        });

        // L'intention est enregistrée : on vide le panier et on présente le choix de la voie.
        $this->cart->clear();

        return redirect()->route('checkout.conversion', $order);
    }

    /**
     * Choix de la voie de conversion (les deux voies seront câblées à l'étape suivante).
     */
    public function conversion(Order $order)
    {
        $order->load(['items.product', 'deliveryOption']);

        return view('checkout.conversion', compact('order'));
    }
}
