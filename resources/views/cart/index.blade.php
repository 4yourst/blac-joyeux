@extends('layouts.app')

@section('title', 'Mon panier — Blac Joyaux')

@section('content')

    <section class="mx-auto max-w-3xl px-5 pt-10">
        <h1 class="font-display text-4xl font-semibold text-bj-navy">Mon panier</h1>

        @if ($items->isEmpty())
            <div class="mt-8 rounded-3xl border border-bj-border bg-white p-10 text-center">
                <p class="text-sm text-bj-ink/70">Votre panier est vide.</p>
                <a href="{{ route('home') }}"
                   class="mt-6 inline-flex items-center rounded-full bg-bj-navy px-6 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                    Découvrir la collection
                </a>
            </div>
        @else
            <div class="mt-8 space-y-4">
                @foreach ($items as $line)
                    @php($product = $line['product'])
                    <div class="flex items-center gap-4 rounded-2xl border border-bj-border bg-white p-4">
                        {{-- Vignette --}}
                        <a href="{{ route('products.show', $product) }}" class="shrink-0">
                            @php($hasImage = $product->image && file_exists(public_path('images/'.$product->image)))
                            <div class="h-20 w-20 overflow-hidden rounded-xl bg-bj-sand">
                                @if ($hasImage)
                                    <img src="{{ asset('images/'.$product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-bj-navy to-bj-navy-soft">
                                        <span class="font-display text-lg font-semibold text-bj-cream">BJ</span>
                                    </div>
                                @endif
                            </div>
                        </a>

                        {{-- Détails --}}
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('products.show', $product) }}" class="font-display text-lg font-semibold text-bj-navy hover:underline">
                                {{ $product->name }}
                            </a>
                            <p class="mt-0.5 text-xs text-bj-ink/60">{{ $product->formatted_price }} l'unité</p>

                            <div class="mt-3 flex items-center gap-3">
                                {{-- Mise à jour de la quantité --}}
                                <form action="{{ route('cart.update', $product) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="quantity" onchange="this.form.submit()"
                                            class="rounded-lg border border-bj-border bg-white px-2 py-1 text-sm text-bj-navy focus:outline-none">
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}" @selected($i === $line['quantity'])>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </form>

                                {{-- Suppression --}}
                                <form action="{{ route('cart.remove', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-red-600">
                                        Retirer
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Sous-total ligne --}}
                        <div class="shrink-0 text-right">
                            <p class="text-sm font-semibold text-bj-navy">{{ number_format($line['line_total'], 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Récapitulatif --}}
            <div class="mt-8 rounded-2xl border border-bj-border bg-white p-6">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-bj-ink/70">Sous-total</span>
                    <span class="text-sm font-semibold text-bj-navy">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                </div>
                <p class="mt-1 text-xs text-bj-ink/50">Les frais de livraison seront calculés à l'étape suivante.</p>

                <a href="{{ route('checkout.create') }}"
                   class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-bj-navy px-7 py-4 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                    Finaliser ma commande
                </a>
            </div>
        @endif
    </section>

@endsection
