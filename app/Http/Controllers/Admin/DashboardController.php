<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOption;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Tableau de bord de l'espace d'administration (doc §10.5).
     */
    public function index()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'deliveryCount' => DeliveryOption::count(),
            'orderCount' => Order::count(),
            'paidCount' => Order::where('status', 'paid')->count(),
            'whatsappCount' => Order::where('status', 'whatsapp')->count(),
            'pendingCount' => Order::where('status', 'pending')->count(),
            'recentOrders' => Order::latest()->take(5)->get(),
        ]);
    }
}
