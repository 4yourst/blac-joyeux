@extends('layouts.app')

@section('title', 'La collection — Blac Joyaux')
@section('meta_description', 'Découvrez toute la collection de sacs à main Blac Joyaux : Joyau de Bla et Collection DO, fabriqués en Côte d\'Ivoire.')

@section('content')

    {{-- En-tête --}}
    <section class="mx-auto max-w-3xl px-6 pt-12 text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Nos créations</p>
        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight text-bj-navy sm:text-5xl">La collection</h1>
        <p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-bj-ink/75">
            Chaque sac raconte une histoire, entre héritage ashanti et élégance contemporaine.
        </p>
    </section>

    {{-- Recherche + filtres --}}
    <section class="mx-auto max-w-6xl px-6 pt-10">
        <form method="GET" action="{{ route('collection') }}"
              class="flex flex-col gap-3 rounded-2xl border border-bj-border bg-white p-4 sm:flex-row sm:items-center">
            {{-- Recherche --}}
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-bj-ink/40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3m1.8-4.45a6.25 6.25 0 1 1-12.5 0 6.25 6.25 0 0 1 12.5 0Z" />
                </svg>
                <input type="search" name="q" value="{{ $q }}" placeholder="Rechercher un sac…"
                       class="w-full rounded-xl border border-bj-border bg-white py-3 pl-11 pr-4 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
            </div>

            {{-- Filtre type --}}
            <select name="type" onchange="this.form.submit()"
                    class="rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                <option value="">Tous les types</option>
                @foreach ($types as $t)
                    <option value="{{ $t }}" @selected($type === $t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>

            {{-- Filtre collection --}}
            <select name="collection" onchange="this.form.submit()"
                    class="rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                <option value="">Toutes les collections</option>
                @foreach ($collections as $c)
                    <option value="{{ $c }}" @selected($collection === $c)>{{ $c }}</option>
                @endforeach
            </select>

            <button type="submit"
                    class="rounded-full bg-bj-navy px-6 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Rechercher
            </button>
        </form>

        {{-- Compteur + réinitialiser --}}
        <div class="mt-5 flex items-center justify-between">
            <p class="text-sm text-bj-ink/60">{{ $products->count() }} résultat{{ $products->count() > 1 ? 's' : '' }}</p>
            @if ($hasFilters)
                <a href="{{ route('collection') }}" class="text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:text-bj-gold">
                    Réinitialiser
                </a>
            @endif
        </div>
    </section>

    {{-- Grille produits --}}
    <section class="mx-auto max-w-6xl px-6 pt-6 pb-4">
        @if ($products->isEmpty())
            <div class="rounded-2xl border border-bj-border bg-white p-12 text-center">
                <p class="font-display text-2xl font-semibold text-bj-navy">Aucun résultat</p>
                <p class="mx-auto mt-3 max-w-sm text-sm text-bj-ink/60">
                    Aucun sac ne correspond à votre recherche. Essayez d'autres mots-clés ou réinitialisez les filtres.
                </p>
                @if ($hasFilters)
                    <a href="{{ route('collection') }}"
                       class="mt-6 inline-flex items-center rounded-full bg-bj-navy px-6 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                        Voir toute la collection
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-2 gap-x-5 gap-y-10 lg:grid-cols-3">
                @foreach ($products as $product)
                    @include('partials.collection-card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </section>

@endsection
