@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')

    <h1 class="font-display text-3xl font-semibold text-bj-navy">Commandes</h1>
    <p class="mt-1 text-sm text-bj-ink/60">Intentions d'achat enregistrées, avec leur voie de conversion.</p>

    {{-- Filtres par statut --}}
    @php
        $tabs = [
            null => ['Toutes', $counts['all']],
            'paid' => ['Mobile Money', $counts['paid']],
            'whatsapp' => ['WhatsApp', $counts['whatsapp']],
            'pending' => ['En attente', $counts['pending']],
        ];
    @endphp
    <div class="mt-6 flex flex-wrap gap-2">
        @foreach ($tabs as $value => [$label, $count])
            @php($active = $filter === $value)
            <a href="{{ route('admin.orders.index', $value ? ['statut' => $value] : []) }}"
               class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-xs font-medium uppercase tracking-widest transition
                      {{ $active ? 'border-bj-navy bg-bj-navy text-bj-cream' : 'border-bj-border bg-white text-bj-ink/70 hover:border-bj-navy' }}">
                {{ $label }}
                <span class="rounded-full {{ $active ? 'bg-white/20' : 'bg-bj-sand' }} px-1.5 py-0.5 text-[10px]">{{ $count }}</span>
            </a>
        @endforeach
    </div>

    @if ($orders->isEmpty())
        <p class="mt-8 rounded-2xl border border-bj-border bg-white p-6 text-sm text-bj-ink/60">Aucune commande pour ce filtre.</p>
    @else
        <div class="mt-6 overflow-hidden rounded-2xl border border-bj-border bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-bj-border bg-bj-sand/40 text-left text-xs uppercase tracking-widest text-bj-ink/50">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-center">Voie</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bj-border">
                    @foreach ($orders as $order)
                        <tr class="transition hover:bg-bj-cream/50">
                            <td class="px-4 py-3 font-medium text-bj-navy">#{{ $order->id }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-bj-navy">{{ $order->customer_name }}</p>
                                <p class="text-xs text-bj-ink/50">{{ $order->customer_phone }}</p>
                            </td>
                            <td class="px-4 py-3 text-bj-ink/70">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-center">@include('admin.partials.channel-badge', ['order' => $order])</td>
                            <td class="px-4 py-3 text-right font-medium text-bj-navy">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:text-bj-gold">Détail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
