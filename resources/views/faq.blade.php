@extends('layouts.app')

@section('title', 'Questions fréquentes — Blac Joyaux')
@section('meta_description', 'Livraison, paiement Mobile Money ou WhatsApp, entretien, conseils : toutes les réponses pour commander en confiance chez Blac Joyaux.')

{{-- Données structurées SEO : FAQPage (doc §10.2, SEO AI-First) --}}
@push('head')
@php
    $faqJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($faqs)->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer'],
            ],
        ])->all(),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($faqJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')

    <section class="mx-auto max-w-3xl px-5 pt-10">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Réassurance</p>
        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight text-bj-navy sm:text-5xl">Questions fréquentes</h1>
        <p class="mt-4 max-w-xl text-base leading-relaxed text-bj-ink/75">
            Tout ce qu'il faut savoir pour commander en toute confiance. Une autre question ?
            Écrivez-nous, nous sommes là pour vous accompagner.
        </p>

        {{-- Accordéon natif et accessible (déroulés de la FAQ, doc §2.2) --}}
        <div class="mt-10 space-y-3">
            @foreach ($faqs as $faq)
                <details class="group overflow-hidden rounded-2xl border border-bj-border bg-white">
                    <summary class="flex cursor-pointer items-center justify-between gap-4 px-5 py-4 font-medium text-bj-navy marker:content-none">
                        <span>{{ $faq['question'] }}</span>
                        <span class="shrink-0 text-bj-gold transition-transform duration-200 group-open:rotate-45">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </summary>
                    <div class="border-t border-bj-border px-5 py-4 text-sm leading-relaxed text-bj-ink/75">
                        {{ $faq['answer'] }}
                    </div>
                </details>
            @endforeach
        </div>

        {{-- Rappel des deux voies --}}
        <div class="mt-12 rounded-3xl bg-bj-navy p-7 text-bj-cream">
            <h2 class="font-display text-2xl font-semibold">Une question avant de commander ?</h2>
            <p class="mt-2 text-sm text-bj-cream/70">
                Choisissez le paiement Mobile Money pour aller vite, ou la conversation WhatsApp
                pour être conseillée et régler à la livraison.
            </p>
            <a href="{{ route('home') }}#collection"
               class="mt-5 inline-flex items-center rounded-full bg-bj-cream px-6 py-3 text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:bg-white">
                Découvrir la collection
            </a>
        </div>
    </section>

@endsection
