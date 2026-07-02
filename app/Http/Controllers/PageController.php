<?php

namespace App\Http\Controllers;

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
}
