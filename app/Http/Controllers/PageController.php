<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOption;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Page « Notre histoire » — récit de la marque et de la fondatrice.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Page « Contact ».
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Réception du formulaire de contact (envoi simulé : validation + confirmation,
     * sans e-mail réel — suffisant pour le prototype).
     */
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return redirect()->route('contact')
            ->with('status', 'Merci ! Votre message a bien été reçu. Nous vous recontactons très vite.');
    }

    /**
     * Page « Livraison & Paiement » — reprend les données réelles des tables
     * delivery_options et payment_methods (doc §10.3).
     */
    public function shipping()
    {
        return view('pages.shipping', [
            'deliveryOptions' => DeliveryOption::where('is_active', true)->orderBy('price')->get(),
            'mobileMethods' => PaymentMethod::where('is_active', true)->where('type', 'mobile_money')->get(),
            'cashMethods' => PaymentMethod::where('is_active', true)->where('type', 'cash')->get(),
        ]);
    }
}
