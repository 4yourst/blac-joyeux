@extends('layouts.app')

@section('title', 'Commande confirmée — Blac Joyaux')

@section('content')

    <section class="mx-auto max-w-3xl px-5 pt-12">
        <div class="rounded-3xl border border-bj-border bg-white p-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50">
                <svg class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h1 class="mt-6 font-display text-3xl font-semibold text-bj-navy">Merci, {{ $order->customer_name }} !</h1>
            <p class="mt-3 text-[15px] text-bj-ink/75">
                Votre paiement {{ $order->paymentMethod?->name }} a bien été reçu (simulation).<br>
                Votre commande <span class="font-semibold text-bj-navy">#{{ $order->id }}</span> est
                <span class="font-semibold text-bj-navy">enregistrée</span> et
                <span class="font-semibold text-bj-navy">en cours de traitement</span>.
            </p>
            @if ($order->customer_email)
                <p class="mt-2 text-sm text-bj-ink/60">Une confirmation vous sera envoyée à {{ $order->customer_email }}.</p>
            @endif
        </div>

        {{-- Délai de livraison estimé selon la zone choisie --}}
        @php
            $delay = $order->deliveryOption->delay_days;
            $estimatedDate = $order->created_at->copy()->addDays($delay);
        @endphp
        <div class="mt-6 rounded-2xl border border-bj-border bg-bj-cream p-6">
            <div class="flex items-start gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-bj-navy text-bj-cream">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-6.75M18.75 5.25v.75a.75.75 0 0 1-.75.75H15a.75.75 0 0 1-.75-.75V5.25m4.5 0V4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75v.75" />
                    </svg>
                </div>
                <div>
                    <p class="font-display text-lg font-semibold text-bj-navy">
                        Livraison estimée sous {{ $delay }} jour{{ $delay > 1 ? 's' : '' }}
                    </p>
                    <p class="mt-1 text-[15px] text-bj-ink/75">
                        Aux alentours du <span class="font-semibold text-bj-navy">{{ $estimatedDate->translatedFormat('l j F') }}</span>,
                        à {{ $order->deliveryOption->zone }}.
                    </p>
                </div>
            </div>
        </div>

        {{-- Récapitulatif --}}
        <div class="mt-6 rounded-2xl border border-bj-border bg-white p-6">
            <h2 class="font-display text-xl font-semibold text-bj-navy">Récapitulatif</h2>
            <ul class="mt-4 space-y-2">
                @foreach ($order->items as $item)
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-bj-ink/80">{{ $item->quantity }} × {{ $item->product->name }}</span>
                        <span class="font-medium text-bj-navy">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} FCFA</span>
                    </li>
                @endforeach
            </ul>
            <dl class="mt-5 space-y-2 border-t border-bj-border pt-4 text-sm">
                <div class="flex justify-between">
                    <dt class="text-bj-ink/70">Livraison — {{ $order->deliveryOption->zone }}</dt>
                    <dd class="font-medium text-bj-navy">{{ number_format($order->deliveryOption->price, 0, ',', ' ') }} FCFA</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-bj-ink/70">Mode de paiement</dt>
                    <dd class="font-medium text-bj-navy">{{ $order->paymentMethod?->name ?? '—' }}</dd>
                </div>
                <div class="flex justify-between border-t border-bj-border pt-3 text-base">
                    <dt class="font-semibold text-bj-navy">Total payé</dt>
                    <dd class="font-semibold text-bj-gold">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</dd>
                </div>
            </dl>
            <p class="mt-5 border-t border-bj-border pt-4 text-sm text-bj-ink/70">
                Livraison à : {{ $order->customer_address }} · {{ $order->customer_phone }}
            </p>
        </div>

        {{-- Prochaines étapes + contact --}}
        <div class="mt-6 rounded-2xl border border-bj-border bg-white p-6">
            <h2 class="font-display text-xl font-semibold text-bj-navy">Et maintenant ?</h2>
            <ol class="mt-4 space-y-3">
                <li class="flex items-start gap-3 text-[15px] text-bj-ink/80">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-bj-sand text-xs font-semibold text-bj-navy">1</span>
                    Nous préparons votre commande avec soin.
                </li>
                <li class="flex items-start gap-3 text-[15px] text-bj-ink/80">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-bj-sand text-xs font-semibold text-bj-navy">2</span>
                    Vous êtes livrée à l'adresse indiquée, sous {{ $delay }} jour{{ $delay > 1 ? 's' : '' }}.
                </li>
                <li class="flex items-start gap-3 text-[15px] text-bj-ink/80">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-bj-sand text-xs font-semibold text-bj-navy">3</span>
                    Une question sur votre commande ? Notre équipe reste joignable sur WhatsApp.
                </li>
            </ol>

            <a href="https://wa.me/{{ config('blacjoyaux.whatsapp_number') }}?text={{ rawurlencode('Bonjour Blac Joyaux, j\'ai une question concernant ma commande #'.$order->id.'.') }}"
               target="_blank" rel="noopener"
               class="mt-6 inline-flex items-center gap-2 rounded-full bg-emerald-600 px-6 py-3 text-xs font-medium uppercase tracking-widest text-white transition hover:bg-emerald-700">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.82 9.82 0 0 0 1.599 5.408l-.999 3.648 3.899-1.003z"/>
                </svg>
                Nous contacter sur WhatsApp
            </a>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}"
               class="inline-flex items-center rounded-full bg-bj-navy px-7 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Retour à la boutique
            </a>
        </div>
    </section>

@endsection
