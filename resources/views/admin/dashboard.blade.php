@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

    <h1 class="font-display text-3xl font-semibold text-bj-navy">Tableau de bord</h1>
    <p class="mt-1 text-sm text-bj-ink/60">Vue d'ensemble de la boutique Blac Joyaux.</p>

    {{-- Indicateurs --}}
    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-bj-border bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Produits</p>
            <p class="mt-2 font-display text-3xl font-semibold text-bj-navy">{{ $productCount }}</p>
        </div>
        <div class="rounded-2xl border border-bj-border bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Options de livraison</p>
            <p class="mt-2 font-display text-3xl font-semibold text-bj-navy">{{ $deliveryCount }}</p>
        </div>
        <div class="rounded-2xl border border-bj-border bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Commandes</p>
            <p class="mt-2 font-display text-3xl font-semibold text-bj-navy">{{ $orderCount }}</p>
        </div>
    </div>

    {{-- Répartition des commandes par voie --}}
    <h2 class="mt-10 font-display text-2xl font-semibold text-bj-navy">Répartition des commandes</h2>
    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-bj-border bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Paiement Mobile Money</p>
            <p class="mt-2 text-2xl font-semibold text-bj-navy">{{ $paidCount }}</p>
        </div>
        <div class="rounded-2xl border border-bj-border bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">Conversion WhatsApp</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $whatsappCount }}</p>
        </div>
        <div class="rounded-2xl border border-bj-border bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-widest text-bj-ink/50">En attente</p>
            <p class="mt-2 text-2xl font-semibold text-bj-gold">{{ $pendingCount }}</p>
        </div>
    </div>

    {{-- Dernières commandes --}}
    <h2 class="mt-10 font-display text-2xl font-semibold text-bj-navy">Dernières commandes</h2>
    @if ($recentOrders->isEmpty())
        <p class="mt-4 rounded-2xl border border-bj-border bg-white p-6 text-sm text-bj-ink/60">Aucune commande pour le moment.</p>
    @else
        <div class="mt-4 overflow-hidden rounded-2xl border border-bj-border bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-bj-border bg-bj-sand/40 text-left text-xs uppercase tracking-widest text-bj-ink/50">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Voie</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bj-border">
                    @foreach ($recentOrders as $order)
                        <tr class="transition hover:bg-bj-cream/50">
                            <td class="px-4 py-3 font-medium text-bj-navy">
                                <a href="{{ route('admin.orders.show', $order) }}" class="transition hover:text-bj-gold">#{{ $order->id }}</a>
                            </td>
                            <td class="px-4 py-3 text-bj-ink/80">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3">
                                @include('admin.partials.channel-badge', ['order' => $order])
                            </td>
                            <td class="px-4 py-3 text-right font-medium text-bj-navy">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
