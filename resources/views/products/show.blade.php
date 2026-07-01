@extends('layouts.app')

@section('title', $product->name.' — Blac Joyaux')
@section('meta_description', Str::limit(strip_tags($product->description), 155))

{{-- Données structurées SEO : Product + Offer (doc §10.2, SEO AI-First) --}}
@push('head')
@php
    $productImage = ($product->image && file_exists(public_path('images/'.$product->image)))
        ? asset('images/'.$product->image)
        : null;
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product->name,
        'description' => strip_tags($product->description),
        'brand' => ['@type' => 'Brand', 'name' => 'Blac Joyaux'],
        'category' => 'Maroquinerie',
        'offers' => [
            '@type' => 'Offer',
            'price' => $product->price,
            'priceCurrency' => 'XOF',
            'availability' => $product->is_available
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock',
            'url' => route('products.show', $product),
        ],
    ];
    if ($productImage) {
        $jsonLd['image'] = $productImage;
    }
    if ($product->material) {
        $jsonLd['material'] = $product->material;
    }
@endphp
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')

    <div class="mx-auto max-w-3xl px-5 pt-6">
        <a href="{{ route('home') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/60 transition hover:text-bj-navy">
            &larr; Retour à la collection
        </a>
    </div>

    <article class="mx-auto max-w-3xl px-5 pt-6">

        {{-- Visuel --}}
        <div class="overflow-hidden rounded-3xl border border-bj-border bg-bj-sand">
            <div class="aspect-[4/5] sm:aspect-[16/10]">
                <x-product-image :product="$product" size="hero" :eager="true" />
            </div>
        </div>

        {{-- En-tête produit --}}
        <header class="mt-8">
            <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Collection Joyau de Bla</p>
            <h1 class="mt-3 font-display text-4xl font-semibold leading-tight text-bj-navy">{{ $product->name }}</h1>

            <div class="mt-4 flex items-center gap-4">
                <span class="text-2xl font-semibold text-bj-gold">{{ $product->formatted_price }}</span>
                @if ($product->is_available)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> En stock
                    </span>
                @else
                    <span class="inline-flex items-center rounded-full bg-bj-sand px-3 py-1 text-xs font-medium text-bj-ink/60">
                        Indisponible
                    </span>
                @endif
            </div>

            <p class="mt-5 text-base leading-relaxed text-bj-ink/80">{{ $product->description }}</p>
        </header>

        {{-- Ajout au panier --}}
        <div class="mt-7">
            @if ($product->is_available)
                <form action="{{ route('cart.add', $product) }}" method="POST"
                      class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    @csrf
                    <label class="flex items-center gap-3 rounded-full border border-bj-border bg-white px-4 py-2">
                        <span class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Qté</span>
                        <select name="quantity" class="bg-transparent text-sm font-medium text-bj-navy focus:outline-none">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </label>
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-full bg-bj-navy px-7 py-4 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft sm:w-auto">
                        Ajouter au panier
                    </button>
                </form>
            @else
                <button type="button" disabled
                        class="inline-flex w-full cursor-not-allowed items-center justify-center rounded-full bg-bj-sand px-7 py-4 text-sm font-medium uppercase tracking-widest text-bj-ink/50 sm:w-auto">
                    Indisponible
                </button>
            @endif
        </div>

        {{-- Storytelling / héritage (doc §10.2) --}}
        @if ($product->story)
            <section class="mt-12 rounded-3xl bg-white p-7 ring-1 ring-bj-border">
                <h2 class="font-display text-2xl font-semibold text-bj-navy">L'histoire du modèle</h2>
                <p class="mt-4 text-[15px] leading-relaxed text-bj-ink/80">{{ $product->story }}</p>
            </section>
        @endif

        {{-- Caractéristiques (doc §10.2) --}}
        <section class="mt-10">
            <h2 class="font-display text-2xl font-semibold text-bj-navy">Caractéristiques</h2>
            <dl class="mt-5 divide-y divide-bj-border overflow-hidden rounded-2xl border border-bj-border bg-white">
                @foreach ([
                    'Dimensions' => $product->dimensions,
                    'Matière' => $product->material,
                    'Entretien' => $product->care,
                ] as $label => $value)
                    @if ($value)
                        <div class="flex flex-col gap-1 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                            <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">{{ $label }}</dt>
                            <dd class="text-sm text-bj-ink/85 sm:text-right">{{ $value }}</dd>
                        </div>
                    @endif
                @endforeach
                <div class="flex items-center justify-between px-5 py-4">
                    <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Prix</dt>
                    <dd class="text-sm font-semibold text-bj-gold">{{ $product->formatted_price }}</dd>
                </div>
            </dl>
        </section>

        {{-- Suggestions --}}
        @if ($suggestions->isNotEmpty())
            <section class="mt-14">
                <h2 class="font-display text-2xl font-semibold text-bj-navy">À découvrir aussi</h2>
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    @foreach ($suggestions as $suggestion)
                        @include('partials.product-card', ['product' => $suggestion])
                    @endforeach
                </div>
            </section>
        @endif

    </article>

@endsection
