<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/produits/{product}', [ProductController::class, 'show'])->name('products.show');

// Panier
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/panier/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/panier/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Finalisation de commande
Route::get('/commande', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/commande', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/commande/{order}/finalisation', [CheckoutController::class, 'conversion'])->name('checkout.conversion');

// Voie A — Paiement Mobile Money simulé
Route::get('/commande/{order}/paiement', [CheckoutController::class, 'paymentCreate'])->name('checkout.payment');
Route::post('/commande/{order}/paiement', [CheckoutController::class, 'paymentStore'])->name('checkout.payment.store');
Route::get('/commande/{order}/confirmation', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Voie B — Redirection WhatsApp
Route::post('/commande/{order}/whatsapp', [CheckoutController::class, 'whatsapp'])->name('checkout.whatsapp');

// Espace d'administration — protégé par le middleware auth (doc §5.1)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
