<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Liste des commandes (intentions d'achat), filtrable par statut (doc §10.5).
     */
    public function index(Request $request)
    {
        $filter = $request->query('statut');

        $orders = Order::with('deliveryOption')
            ->when(in_array($filter, ['pending', 'paid', 'whatsapp'], true), fn ($q) => $q->where('status', $filter))
            ->latest()
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filter' => $filter,
            'counts' => [
                'all' => Order::count(),
                'paid' => Order::where('status', 'paid')->count(),
                'whatsapp' => Order::where('status', 'whatsapp')->count(),
                'pending' => Order::where('status', 'pending')->count(),
            ],
        ]);
    }

    /**
     * Détail d'une commande (doc §10.5).
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'deliveryOption', 'paymentMethod']);

        return view('admin.orders.show', compact('order'));
    }
}
