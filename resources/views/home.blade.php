@extends('layouts.app')

@section('title', 'Blac Joyaux — Maroquinerie ivoirienne | Collection Joyau de Bla')

@php
    // Helper images (placeholders libres de droits Unsplash — à remplacer par les visuels de la créa).
    $ux = fn (string $id, int $w = 1200, ?int $h = null) =>
        'https://images.unsplash.com/photo-'.$id.'?auto=format&fit=crop&q=80&w='.$w.($h ? '&h='.$h : '');

    $heroImg = '1490481651871-ab68de25d43d';
    $featuredImg = '1566150905458-1bf1fc113f0d';
    $heritageImg = '1512201078372-9c6b2a0d528a';
    $gridImgs = [
        '1584917865442-de89df76afd3',
        '1566150905458-1bf1fc113f0d',
        '1548036328-c9fa89d128fa',
        '1591561954557-26941169b49e',
        '1571945153237-4929e783af4a',
        '1553062407-98eeb64c6a62',
    ];

    $allProducts = collect([$featured])->filter()->merge($others);
@endphp

@section('content')

    {{-- ========================= HERO PLEINE LARGEUR ========================= --}}
    <section class="relative isolate flex min-h-[78vh] items-center overflow-hidden">
        <img src="{{ $ux($heroImg, 1600) }}" alt="Élégance Blac Joyaux" fetchpriority="high"
             class="absolute inset-0 -z-10 h-full w-full object-cover object-center">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-bj-navy/85 via-bj-navy/55 to-bj-navy/20"></div>

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
                <a href="#collection"
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

    {{-- ========================= NOS CRÉATIONS (GRILLE) ========================= --}}
    <section id="collection" class="mx-auto max-w-6xl px-6 pt-20">
        <div class="text-center">
            <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Nos créations</p>
            <h2 class="mt-3 font-display text-4xl font-semibold text-bj-navy">La collection</h2>
            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-bj-ink/70">
                Des pièces essentielles, façonnées avec soin, à porter au quotidien comme aux grands jours.
            </p>
        </div>

        <div class="mt-12 grid grid-cols-2 gap-x-5 gap-y-10 lg:grid-cols-3">
            @foreach ($allProducts as $i => $product)
                <a href="{{ route('products.show', $product) }}" class="group block">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-2xl bg-bj-sand">
                        <img src="{{ $ux($gridImgs[$i % count($gridImgs)], 700) }}" alt="{{ $product->name }}" loading="lazy"
                             class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-[1.04]">
                        <span class="absolute left-3 top-3 rounded-full bg-bj-cream/90 px-3 py-1 text-[10px] font-medium uppercase tracking-widest text-bj-navy">
                            Joyau de Bla
                        </span>
                    </div>
                    <div class="mt-4 text-center">
                        <h3 class="font-display text-lg font-semibold text-bj-navy transition group-hover:text-bj-gold">{{ $product->name }}</h3>
                        <p class="mt-1 text-sm tracking-wide text-bj-ink/70">{{ $product->formatted_price }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ========================= PIÈCE PHARE (ÉDITORIAL) ========================= --}}
    @if ($featured)
        <section class="mx-auto mt-24 max-w-6xl px-6">
            <div class="grid items-stretch overflow-hidden rounded-3xl border border-bj-border bg-white shadow-sm lg:grid-cols-2">
                <div class="relative min-h-72 lg:min-h-[32rem]">
                    <img src="{{ $ux($featuredImg, 1000) }}" alt="{{ $featured->name }}" loading="lazy"
                         class="absolute inset-0 h-full w-full object-cover">
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
                <img src="{{ $ux($heritageImg, 1000) }}" alt="Savoir-faire Blac Joyaux" loading="lazy"
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
        <a href="#collection"
           class="mt-8 inline-flex items-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Voir la collection
        </a>
    </section>

@endsection
