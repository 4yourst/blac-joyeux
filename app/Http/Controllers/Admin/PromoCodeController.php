<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    public function index()
    {
        return view('admin.promos.index', [
            'promos' => PromoCode::orderByDesc('ends_at')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.promos.create', [
            'promo' => new PromoCode([
                'is_active' => true,
                'discount_percent' => 30,
                'starts_at' => now(),
                'ends_at' => now()->addDays(7),
            ]),
        ]);
    }

    public function store(Request $request)
    {
        PromoCode::create($this->validateData($request));

        return redirect()->route('admin.promos.index')->with('status', 'Le code promo a été créé.');
    }

    public function edit(PromoCode $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    public function update(Request $request, PromoCode $promo)
    {
        $promo->update($this->validateData($request, $promo));

        return redirect()->route('admin.promos.index')->with('status', 'Le code promo a été mis à jour.');
    }

    public function destroy(PromoCode $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')->with('status', 'Le code promo a été supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request, ?PromoCode $promo = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:60', 'alpha_num', Rule::unique('promo_codes', 'code')->ignore($promo)],
            'discount_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
