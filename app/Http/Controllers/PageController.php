<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    /**
     * Page « Notre histoire » — récit de la marque et de la fondatrice.
     */
    public function about()
    {
        return view('pages.about');
    }
}
