@extends('layouts.app')

@section('title', 'Choisir le mode de finalisation — Blac Joyaux')

@section('content')

    <section class="mx-auto max-w-3xl px-5 pt-10">
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            Votre commande <span class="font-semibold">#{{ $order->id }}</span> a bien été enregistrée.
        </div>

        <h1 class="mt-6 font-display text-4xl font-semibold text-bj-navy">Comment souhaitez-vous finaliser ?</h1>
        <p class="mt-2 text-sm text-bj-ink/70">Choisissez le paiement Mobile Money ou un échange direct sur WhatsApp.</p>

        {{-- Récapitulatif --}}
        <div class="mt-8 rounded-2xl border border-bj-border bg-white p-6">
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
                <div class="flex justify-between border-t border-bj-border pt-3 text-base">
                    <dt class="font-semibold text-bj-navy">Total</dt>
                    <dd class="font-semibold text-bj-gold">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</dd>
                </div>
            </dl>
            <div class="mt-5 border-t border-bj-border pt-4 text-sm text-bj-ink/70">
                <p><span class="font-medium text-bj-navy">{{ $order->customer_name }}</span> · {{ $order->customer_phone }}</p>
                <p class="mt-1">{{ $order->customer_address }}</p>
            </div>
        </div>

        {{-- Les deux voies de conversion (câblage à l'étape suivante, doc §10.4) --}}
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="rounded-2xl border border-bj-border bg-white p-6 text-center opacity-70">
                <p class="font-display text-xl font-semibold text-bj-navy">Paiement Mobile Money</p>
                <p class="mt-2 text-xs text-bj-ink/60">Wave, Orange Money, MTN, Moov</p>
                <span class="mt-4 inline-flex rounded-full bg-bj-sand px-4 py-2 text-[11px] uppercase tracking-widest text-bj-ink/50">Bientôt disponible</span>
            </div>
            <div class="rounded-2xl border border-bj-border bg-white p-6 text-center opacity-70">
                <p class="font-display text-xl font-semibold text-bj-navy">Finaliser sur WhatsApp</p>
                <p class="mt-2 text-xs text-bj-ink/60">Échange direct avec la marque</p>
                <span class="mt-4 inline-flex rounded-full bg-bj-sand px-4 py-2 text-[11px] uppercase tracking-widest text-bj-ink/50">Bientôt disponible</span>
            </div>
        </div>
    </section>

@endsection
