@extends('layouts.admin')

@section('title', 'Commande #'.$order->id)

@section('content')

    <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-bj-navy">
        &larr; Retour aux commandes
    </a>

    <div class="mt-4 flex flex-wrap items-center gap-3">
        <h1 class="font-display text-3xl font-semibold text-bj-navy">Commande #{{ $order->id }}</h1>
        @include('admin.partials.channel-badge', ['order' => $order])
    </div>
    <p class="mt-1 text-sm text-bj-ink/60">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Articles + totaux --}}
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Articles</h2>
                <ul class="mt-4 divide-y divide-bj-border">
                    @foreach ($order->items as $item)
                        <li class="flex items-center justify-between py-3 text-sm">
                            <span class="text-bj-ink/80">
                                {{ $item->quantity }} × {{ $item->product?->name ?? 'Produit supprimé' }}
                                <span class="text-bj-ink/50">({{ number_format($item->unit_price, 0, ',', ' ') }} FCFA l'unité)</span>
                            </span>
                            <span class="font-medium text-bj-navy">{{ number_format($item->unit_price * $item->quantity, 0, ',', ' ') }} FCFA</span>
                        </li>
                    @endforeach
                </ul>
                <dl class="mt-4 space-y-2 border-t border-bj-border pt-4 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-bj-ink/70">Livraison — {{ $order->deliveryOption->zone }} ({{ $order->deliveryOption->delay_days }} j)</dt>
                        <dd class="font-medium text-bj-navy">{{ number_format($order->deliveryOption->price, 0, ',', ' ') }} FCFA</dd>
                    </div>
                    <div class="flex justify-between border-t border-bj-border pt-3 text-base">
                        <dt class="font-semibold text-bj-navy">Total</dt>
                        <dd class="font-semibold text-bj-gold">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Coordonnées + voie --}}
        <div class="space-y-6">
            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Cliente</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Nom</dt>
                        <dd class="mt-0.5 text-bj-navy">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Téléphone</dt>
                        <dd class="mt-0.5 text-bj-navy">{{ $order->customer_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Adresse de livraison</dt>
                        <dd class="mt-0.5 text-bj-navy">{{ $order->customer_address }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Conversion</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Voie</dt>
                        <dd class="mt-0.5">@include('admin.partials.channel-badge', ['order' => $order])</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Moyen de paiement</dt>
                        <dd class="mt-0.5 text-bj-navy">{{ $order->paymentMethod?->name ?? '— (non défini)' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

    </div>

@endsection
