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

    {{-- Grille produits --}}
    <section class="mx-auto max-w-6xl px-6 pt-12 pb-4">
        <p class="text-sm text-bj-ink/60">{{ $products->count() }} pièce{{ $products->count() > 1 ? 's' : '' }}</p>

        @if ($products->isEmpty())
            <p class="mt-8 rounded-2xl border border-bj-border bg-white p-10 text-center text-sm text-bj-ink/60">
                Aucun produit disponible pour le moment.
            </p>
        @else
            <div class="mt-6 grid grid-cols-2 gap-x-5 gap-y-10 lg:grid-cols-3">
                @foreach ($products as $product)
                    @include('partials.collection-card', ['product' => $product])
                @endforeach
            </div>
        @endif
    </section>

@endsection
