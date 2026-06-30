<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
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
     * Choix de la voie de conversion (doc §10.4).
     */
    public function conversion(Order $order)
    {
        // Commande déjà finalisée par paiement : on présente directement la confirmation.
        if ($order->status === 'paid') {
            return redirect()->route('checkout.confirmation', $order);
        }

        $order->load(['items.product', 'deliveryOption']);

        return view('checkout.conversion', compact('order'));
    }

    /**
     * Voie A — écran de paiement Mobile Money simulé : choix de l'opérateur (doc §3.3, §10.4).
     */
    public function paymentCreate(Order $order)
    {
        if ($order->status === 'paid') {
            return redirect()->route('checkout.confirmation', $order);
        }

        $order->load(['items.product', 'deliveryOption']);

        return view('checkout.payment', [
            'order' => $order,
            'operators' => PaymentMethod::where('is_active', true)
                ->where('type', 'mobile_money')
                ->get(),
        ]);
    }

    /**
     * Voie A — traitement du paiement simulé : aucune transaction réelle (doc §3.3).
     */
    public function paymentStore(Request $request, Order $order)
    {
        if ($order->status === 'paid') {
            return redirect()->route('checkout.confirmation', $order);
        }

        $validated = $request->validate([
            'payment_method_id' => [
                'required',
                'exists:payment_methods,id',
            ],
        ]);

        $method = PaymentMethod::where('type', 'mobile_money')->findOrFail($validated['payment_method_id']);

        $order->update([
            'payment_method_id' => $method->id,
            'conversion_channel' => 'mobile_money',
            'status' => 'paid',
        ]);

        return redirect()->route('checkout.confirmation', $order);
    }

    /**
     * Voie A — page de confirmation du paiement simulé.
     */
    public function confirmation(Order $order)
    {
        $order->load(['items.product', 'deliveryOption', 'paymentMethod']);

        return view('checkout.confirmation', compact('order'));
    }

    /**
     * Voie B — redirection WhatsApp avec récapitulatif pré-rempli (doc §3.3, §10.4).
     */
    public function whatsapp(Order $order)
    {
        // La commande reste une intention : on trace seulement la voie empruntée.
        if ($order->status === 'pending') {
            $order->update([
                'conversion_channel' => 'whatsapp',
                'status' => 'whatsapp',
            ]);
        }

        $order->load(['items.product', 'deliveryOption']);

        $url = 'https://wa.me/'.config('blacjoyaux.whatsapp_number')
            .'?text='.rawurlencode($this->buildWhatsappMessage($order));

        return redirect()->away($url);
    }

    /**
     * Construit le message récapitulatif pré-rempli pour WhatsApp.
     */
    private function buildWhatsappMessage(Order $order): string
    {
        $lines = [
            'Bonjour Blac Joyaux, je souhaite finaliser ma commande #'.$order->id.' :',
            '',
        ];

        foreach ($order->items as $item) {
            $lines[] = '• '.$item->quantity.' × '.$item->product->name
                .' ('.number_format($item->unit_price, 0, ',', ' ').' FCFA)';
        }

        $lines[] = '';
        $lines[] = 'Livraison : '.$order->deliveryOption->zone
            .' ('.number_format($order->deliveryOption->price, 0, ',', ' ').' FCFA)';
        $lines[] = 'Total : '.number_format($order->total_amount, 0, ',', ' ').' FCFA';
        $lines[] = '';
        $lines[] = 'Nom : '.$order->customer_name;
        $lines[] = 'Téléphone : '.$order->customer_phone;
        $lines[] = 'Adresse : '.$order->customer_address;

        return implode("\n", $lines);
    }
}
