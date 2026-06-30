<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOption;
use Illuminate\Http\Request;

class DeliveryOptionController extends Controller
{
    /**
     * Liste des options de livraison (doc §10.5).
     */
    public function index()
    {
        return view('admin.delivery-options.index', [
            'deliveryOptions' => DeliveryOption::orderBy('price')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.delivery-options.create', [
            'deliveryOption' => new DeliveryOption(['is_active' => true, 'delay_days' => 1]),
        ]);
    }

    public function store(Request $request)
    {
        DeliveryOption::create($this->validateData($request));

        return redirect()->route('admin.delivery-options.index')
            ->with('status', 'L\'option de livraison a été créée.');
    }

    public function edit(DeliveryOption $deliveryOption)
    {
        return view('admin.delivery-options.edit', compact('deliveryOption'));
    }

    public function update(Request $request, DeliveryOption $deliveryOption)
    {
        $deliveryOption->update($this->validateData($request));

        return redirect()->route('admin.delivery-options.index')
            ->with('status', 'L\'option de livraison a été mise à jour.');
    }

    public function destroy(DeliveryOption $deliveryOption)
    {
        // Une option rattachée à des commandes ne doit pas être supprimée (intégrité, doc §4.3).
        if ($deliveryOption->orders()->exists()) {
            return redirect()->route('admin.delivery-options.index')
                ->with('error', 'Cette option est utilisée par des commandes et ne peut pas être supprimée. Désactivez-la plutôt.');
        }

        $deliveryOption->delete();

        return redirect()->route('admin.delivery-options.index')
            ->with('status', 'L\'option de livraison a été supprimée.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'zone' => ['required', 'string', 'max:160'],
            'delay_days' => ['required', 'integer', 'min:1', 'max:30'],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'is_active' => ['required', 'boolean'],
        ]);
    }
}
