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
            <p class="mt-3 text-sm text-bj-ink/70">
                Votre paiement {{ $order->paymentMethod?->name }} a bien été reçu (simulation).<br>
                Votre commande <span class="font-semibold">#{{ $order->id }}</span> est confirmée.
            </p>
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

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}"
               class="inline-flex items-center rounded-full bg-bj-navy px-7 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Retour à la boutique
            </a>
        </div>
    </section>

@endsection
