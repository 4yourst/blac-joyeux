@extends('layouts.app')

@section('title', 'Blac Joyaux — Maroquinerie ivoirienne | Collection Joyau de Bla')

@php
    // Visuels de décor (hero, héritage) : placeholders Unsplash locaux dans public/images/site.
    // À remplacer par les visuels définitifs de la créa.
@endphp

@section('content')

    {{-- ========================= HERO PLEINE LARGEUR ========================= --}}
    <section class="relative isolate flex min-h-[78vh] items-center overflow-hidden">
        <img src="{{ asset('images/site/hero.jpg') }}" alt="Sac à main Blac Joyaux" fetchpriority="high"
             class="absolute inset-0 -z-10 h-full w-full object-cover object-center">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-bj-navy/85 via-bj-navy/55 to-bj-navy/25"></div>

        <div class="mx-auto w-full max-w-5xl px-6 py-24">
            <div class="max-w-xl text-bj-cream">
                <p class="text-xs font-medium uppercase tracking-[0.35em] text-bj-gold-soft">Maison de maroquinerie ivoirienne</p>
                <h1 class="mt-5 font-display text-5xl font-semibold leading-[1.05] sm:text-6xl">
                    L'héritage<br>en main.
                </h1>
                <p class="mt-6 max-w-md text-base leading-relaxed text-bj-cream/85">
                    La collection Joyau de Bla, inspirée de la poupée de fécondité ashanti. Des sacs à main
                    d'exception, fabriqués en Côte d'Ivoire, pour la femme qui porte son histoire avec allure.
                </p>
                <a href="#creations"
                   class="mt-9 inline-flex items-center rounded-full bg-bj-cream px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:bg-white">
                    Découvrir la collection
                </a>
            </div>
        </div>
    </section>

    {{-- ========================= BANDEAU RÉASSURANCE ========================= --}}
    <section class="border-b border-bj-border bg-bj-cream">
        <div class="mx-auto grid max-w-5xl grid-cols-1 divide-y divide-bj-border px-6 sm:grid-cols-3 sm:divide-x sm:divide-y-0">
            <div class="px-4 py-6 text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Livraison 1 à 3 jours</p>
                <p class="mt-1 text-xs uppercase tracking-widest text-bj-ink/50">Abidjan &amp; intérieur</p>
            </div>
            <div class="px-4 py-6 text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Paiement au choix</p>
                <p class="mt-1 text-xs uppercase tracking-widest text-bj-ink/50">Mobile Money ou WhatsApp</p>
            </div>
            <div class="px-4 py-6 text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Fabrication ivoirienne</p>
                <p class="mt-1 text-xs uppercase tracking-widest text-bj-ink/50">Héritage Joyau de Bla</p>
            </div>
        </div>
    </section>

    {{-- ========================= NOS CRÉATIONS (SÉLECTION) ========================= --}}
    <section id="creations" class="mx-auto max-w-6xl px-6 pt-20">
        <div class="text-center">
            <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Nos créations</p>
            <h2 class="mt-3 font-display text-4xl font-semibold text-bj-navy">La collection</h2>
            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-bj-ink/70">
                Une sélection de nos pièces phares — découvrez l'ensemble du catalogue en boutique.
            </p>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-x-5 gap-y-10 lg:grid-cols-3">
            @foreach ($highlights as $product)
                @include('partials.collection-card', ['product' => $product])
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('collection') }}"
               class="inline-flex items-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Voir toute la collection
            </a>
        </div>
    </section>

    {{-- ========================= PIÈCE PHARE (ÉDITORIAL) ========================= --}}
    @if ($featured)
        <section class="mx-auto mt-24 max-w-6xl px-6">
            <div class="grid items-stretch overflow-hidden rounded-3xl border border-bj-border bg-white shadow-sm lg:grid-cols-2">
                <div class="relative min-h-72 lg:min-h-[32rem]">
                    <x-product-image :product="$featured" size="hero" />
                </div>
                <div class="flex flex-col justify-center p-10 sm:p-14">
                    <p class="text-[11px] font-medium uppercase tracking-[0.3em] text-bj-gold">Pièce phare</p>
                    <h2 class="mt-3 font-display text-4xl font-semibold text-bj-navy">{{ $featured->name }}</h2>
                    <p class="mt-5 text-[15px] leading-relaxed text-bj-ink/75">{{ $featured->description }}</p>
                    <p class="mt-6 text-2xl font-semibold text-bj-gold">{{ $featured->formatted_price }}</p>
                    <a href="{{ route('products.show', $featured) }}"
                       class="mt-8 inline-flex w-fit items-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                        Découvrir la pièce
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ========================= HÉRITAGE (SECTION SOMBRE) ========================= --}}
    <section class="mt-24 bg-bj-navy text-bj-cream">
        <div class="mx-auto grid max-w-6xl items-center gap-0 lg:grid-cols-2">
            <div class="relative min-h-72 lg:min-h-[34rem]">
                <img src="{{ asset('images/site/heritage.jpg') }}" alt="Savoir-faire maroquinier Blac Joyaux" loading="lazy"
                     class="absolute inset-0 h-full w-full object-cover">
            </div>
            <div class="px-6 py-16 sm:px-12 lg:py-20">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold-soft">Notre héritage</p>
                <h2 class="mt-3 font-display text-4xl font-semibold sm:text-5xl">Joyau de Bla</h2>
                <p class="mt-6 max-w-md text-[15px] leading-relaxed text-bj-cream/80">
                    Inspirée de la poupée de fécondité ashanti — symbole de vie, de transmission et de beauté —
                    la collection porte un récit plus grand que l'objet. Chaque sac est un bijou du quotidien,
                    pensé pour être transmis.
                </p>
                <a href="{{ route('about') }}"
                   class="mt-8 inline-flex items-center rounded-full border border-bj-cream/40 px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-cream hover:text-bj-navy">
                    Notre histoire
                </a>
            </div>
        </div>
    </section>

    {{-- ========================= CTA FINAL ========================= --}}
    <section class="mx-auto max-w-3xl px-6 py-24 text-center">
        <h2 class="font-display text-4xl font-semibold text-bj-navy">Portez votre histoire</h2>
        <p class="mx-auto mt-4 max-w-md text-sm leading-relaxed text-bj-ink/70">
            Découvrez la collection Joyau de Bla et trouvez la pièce qui vous ressemble.
        </p>
        <a href="{{ route('collection') }}"
           class="mt-8 inline-flex items-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Voir la collection
        </a>
    </section>

@endsection
