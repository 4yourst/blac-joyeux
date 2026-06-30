@extends('layouts.app')

@section('title', 'Blac Joyaux — Collection Joyau de Bla')

@section('content')

    {{-- Hero : focus sur le sac de bureau (doc §10.1) --}}
    <section class="mx-auto max-w-3xl px-5 pt-10 pb-14">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Collection Joyau de Bla</p>
        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight text-bj-navy sm:text-5xl">
            L'héritage ashanti,<br>porté avec élégance.
        </h1>
        <p class="mt-5 max-w-xl text-base leading-relaxed text-bj-ink/75">
            Des sacs à main qui allient un patrimoine culturel fort à une exigence d'élégance —
            pensés pour la femme active, à des prix maîtrisés.
        </p>

        @if ($featured)
            <div class="mt-10 overflow-hidden rounded-3xl border border-bj-border bg-white shadow-sm">
                <div class="grid sm:grid-cols-2">
                    <div class="relative aspect-square sm:aspect-auto">
                        @php
                            $heroImage = $featured->image ? public_path('images/'.$featured->image) : null;
                            $heroHasImage = $heroImage && file_exists($heroImage);
                        @endphp
                        @if ($heroHasImage)
                            <img src="{{ asset('images/'.$featured->image) }}" alt="{{ $featured->name }}"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full min-h-64 w-full flex-col items-center justify-center bg-gradient-to-br from-bj-navy to-bj-navy-soft text-bj-cream">
                                <span class="font-display text-6xl font-semibold">BJ</span>
                                <span class="mt-2 text-[10px] uppercase tracking-[0.3em] text-bj-gold-soft">Pièce phare</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col justify-center p-7">
                        <p class="text-[11px] font-medium uppercase tracking-[0.25em] text-bj-gold">Pièce phare</p>
                        <h2 class="mt-2 font-display text-2xl font-semibold text-bj-navy">{{ $featured->name }}</h2>
                        <p class="mt-3 text-sm leading-relaxed text-bj-ink/70">{{ $featured->description }}</p>
                        <p class="mt-5 text-lg font-semibold text-bj-gold">{{ $featured->formatted_price }}</p>
                        <a href="{{ route('products.show', $featured) }}"
                           class="mt-6 inline-flex w-fit items-center rounded-full bg-bj-navy px-6 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                            Découvrir
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{-- Réassurance (doc §10.1) --}}
    <section class="border-y border-bj-border bg-white/60">
        <div class="mx-auto grid max-w-3xl grid-cols-1 gap-px px-5 py-2 sm:grid-cols-3">
            <div class="px-2 py-5 text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Livraison 1 à 3 jours</p>
                <p class="mt-1 text-xs text-bj-ink/60">Abidjan et intérieur</p>
            </div>
            <div class="px-2 py-5 text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Paiement au choix</p>
                <p class="mt-1 text-xs text-bj-ink/60">Mobile Money ou WhatsApp</p>
            </div>
            <div class="px-2 py-5 text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Fabrication ivoirienne</p>
                <p class="mt-1 text-xs text-bj-ink/60">Héritage Joyau de Bla</p>
            </div>
        </div>
    </section>

    {{-- Collection capsule --}}
    <section id="collection" class="mx-auto max-w-3xl px-5 pt-14">
        <h2 class="font-display text-3xl font-semibold text-bj-navy">La collection</h2>
        <p class="mt-2 text-sm text-bj-ink/70">Une capsule de pièces essentielles, à porter au quotidien.</p>

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
            @forelse ($others as $product)
                @include('partials.product-card', ['product' => $product])
            @empty
                <p class="text-sm text-bj-ink/60">Aucun autre modèle disponible pour le moment.</p>
            @endforelse
        </div>
    </section>

@endsection
