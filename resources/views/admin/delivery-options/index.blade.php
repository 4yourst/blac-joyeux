@extends('layouts.admin')

@section('title', 'Livraisons')

@section('content')

    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bj-navy">Options de livraison</h1>
            <p class="mt-1 text-sm text-bj-ink/60">Zones, délais et tarifs proposés à la finalisation.</p>
        </div>
        <a href="{{ route('admin.delivery-options.create') }}"
           class="inline-flex items-center rounded-full bg-bj-navy px-5 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Nouvelle option
        </a>
    </div>

    @if ($deliveryOptions->isEmpty())
        <p class="mt-8 rounded-2xl border border-bj-border bg-white p-6 text-sm text-bj-ink/60">Aucune option de livraison.</p>
    @else
        <div class="mt-8 overflow-hidden rounded-2xl border border-bj-border bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-bj-border bg-bj-sand/40 text-left text-xs uppercase tracking-widest text-bj-ink/50">
                    <tr>
                        <th class="px-4 py-3">Zone</th>
                        <th class="px-4 py-3 text-center">Délai</th>
                        <th class="px-4 py-3 text-right">Tarif</th>
                        <th class="px-4 py-3 text-center">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bj-border">
                    @foreach ($deliveryOptions as $option)
                        <tr>
                            <td class="px-4 py-3 font-medium text-bj-navy">{{ $option->zone }}</td>
                            <td class="px-4 py-3 text-center text-bj-ink/80">{{ $option->delay_days }} j</td>
                            <td class="px-4 py-3 text-right font-medium text-bj-navy">{{ number_format($option->price, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-3 text-center">
                                @if ($option->is_active)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Active</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-bj-sand px-2.5 py-1 text-xs font-medium text-bj-ink/60">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.delivery-options.edit', $option) }}" class="text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:text-bj-gold">Modifier</a>
                                    <form action="{{ route('admin.delivery-options.destroy', $option) }}" method="POST"
                                          onsubmit="return confirm('Supprimer cette option de livraison ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium uppercase tracking-widest text-red-600 transition hover:text-red-800">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
