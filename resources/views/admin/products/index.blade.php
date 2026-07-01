@extends('layouts.admin')

@section('title', 'Produits')

@section('content')

    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bj-navy">Produits</h1>
            <p class="mt-1 text-sm text-bj-ink/60">Gérez le catalogue de la collection.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center rounded-full bg-bj-navy px-5 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Nouveau produit
        </a>
    </div>

    @if ($products->isEmpty())
        <p class="mt-8 rounded-2xl border border-bj-border bg-white p-6 text-sm text-bj-ink/60">Aucun produit. Créez le premier.</p>
    @else
        <div class="mt-8 overflow-hidden rounded-2xl border border-bj-border bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-bj-border bg-bj-sand/40 text-left text-xs uppercase tracking-widest text-bj-ink/50">
                    <tr>
                        <th class="px-4 py-3">Produit</th>
                        <th class="px-4 py-3 text-right">Prix</th>
                        <th class="px-4 py-3 text-center">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bj-border">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 shrink-0 overflow-hidden rounded-lg">
                                        <x-product-image :product="$product" size="thumbnail" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-bj-navy">{{ $product->name }}</p>
                                        <p class="truncate text-xs text-bj-ink/50">/{{ $product->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-bj-navy">{{ $product->formatted_price }}</td>
                            <td class="px-4 py-3 text-center">
                                @if ($product->is_available)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">Disponible</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-bj-sand px-2.5 py-1 text-xs font-medium text-bj-ink/60">Indisponible</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:text-bj-gold">Modifier</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Supprimer « {{ $product->name }} » ?');">
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
