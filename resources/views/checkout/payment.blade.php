@extends('layouts.app')

@section('title', 'Paiement Mobile Money — Blac Joyaux')

@section('content')

    <section class="mx-auto max-w-3xl px-5 pt-10">
        <a href="{{ route('checkout.conversion', $order) }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/60 transition hover:text-bj-navy">
            &larr; Retour aux modes de finalisation
        </a>
        <h1 class="mt-4 font-display text-4xl font-semibold text-bj-navy">Paiement Mobile Money</h1>

        {{-- Montant à régler --}}
        <div class="mt-8 rounded-2xl bg-bj-navy p-6 text-bj-cream">
            <p class="text-xs uppercase tracking-[0.25em] text-bj-gold-soft">Montant à régler</p>
            <p class="mt-2 font-display text-4xl font-semibold">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
            <p class="mt-2 text-xs text-bj-cream/60">Commande #{{ $order->id }} · {{ $order->customer_name }}</p>
        </div>

        <form action="{{ route('checkout.payment.store', $order) }}" method="POST" class="mt-6">
            @csrf

            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Choisissez votre opérateur</h2>
                <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach ($operators as $index => $operator)
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-bj-border p-4 transition has-[:checked]:border-bj-navy has-[:checked]:bg-bj-cream">
                            <input type="radio" name="payment_method_id" value="{{ $operator->id }}"
                                   @checked($index === 0)
                                   class="h-4 w-4 accent-bj-navy">
                            <span class="text-sm font-medium text-bj-navy">{{ $operator->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('payment_method_id')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 rounded-xl border border-bj-border bg-bj-sand/40 px-4 py-3 text-xs text-bj-ink/60">
                Paiement simulé — aucune transaction réelle n'est déclenchée (prototype, doc §3.3).
            </div>

            <button type="submit"
                    class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-bj-navy px-7 py-4 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Confirmer le paiement
            </button>
        </form>
    </section>

@endsection
