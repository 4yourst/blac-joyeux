@extends('layouts.app')

@section('title', 'Finaliser ma commande — Blac Joyaux')

@section('content')

    <section class="mx-auto max-w-3xl px-5 pt-10">
        <a href="{{ route('cart.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/60 transition hover:text-bj-navy">
            &larr; Retour au panier
        </a>
        <h1 class="mt-4 font-display text-4xl font-semibold text-bj-navy">Finaliser ma commande</h1>

        {{-- Code promo (formulaire distinct du formulaire de commande) --}}
        @if ($promo)
            <form action="{{ route('checkout.promo.remove') }}" method="POST"
                  class="mt-8 flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                @csrf
                @method('DELETE')
                <p class="text-sm text-emerald-800">
                    Code <span class="font-semibold">{{ $promo->code }}</span> appliqué — −{{ $promo->discount_percent }} %
                </p>
                <button type="submit" class="text-xs font-medium uppercase tracking-widest text-emerald-700 transition hover:text-emerald-900">
                    Retirer
                </button>
            </form>
        @else
            <form action="{{ route('checkout.promo.apply') }}" method="POST"
                  class="mt-8 flex flex-col gap-3 rounded-2xl border border-bj-border bg-white p-4 sm:flex-row sm:items-center">
                @csrf
                <label for="promo_code" class="sr-only">Code promo</label>
                <input type="text" id="promo_code" name="promo_code" value="{{ old('promo_code') }}" placeholder="Code promo"
                       class="flex-1 rounded-xl border border-bj-border bg-white px-4 py-3 text-sm uppercase text-bj-navy placeholder:normal-case focus:border-bj-navy focus:outline-none">
                <button type="submit" class="rounded-full bg-bj-navy px-6 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                    Appliquer
                </button>
            </form>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" class="mt-6 space-y-8">
            @csrf

            {{-- Récapitulatif des articles --}}
            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Votre commande</h2>
                <ul class="mt-4 space-y-2">
                    @foreach ($items as $line)
                        <li class="flex items-center justify-between text-sm">
                            <span class="text-bj-ink/80">{{ $line['quantity'] }} × {{ $line['product']->name }}</span>
                            <span class="font-medium text-bj-navy">{{ number_format($line['line_total'], 0, ',', ' ') }} FCFA</span>
                        </li>
                    @endforeach
                </ul>

                <dl class="mt-5 space-y-2 border-t border-bj-border pt-4 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-bj-ink/70">Sous-total</dt>
                        <dd class="font-medium text-bj-navy">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</dd>
                    </div>
                    @if ($discount > 0)
                        <div class="flex justify-between text-emerald-700">
                            <dt>Réduction @if ($promo)<span class="text-emerald-700/80">({{ $promo->code }} −{{ $promo->discount_percent }} %)</span>@endif</dt>
                            <dd class="font-medium">− {{ number_format($discount, 0, ',', ' ') }} FCFA</dd>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-bj-ink/70">Livraison</dt>
                        <dd class="font-medium text-bj-navy" data-recap-delivery>—</dd>
                    </div>
                    <div class="flex justify-between border-t border-bj-border pt-3 text-base">
                        <dt class="font-semibold text-bj-navy">Total</dt>
                        <dd class="font-semibold text-bj-gold" data-recap-total>—</dd>
                    </div>
                </dl>
            </div>

            {{-- Choix de la livraison --}}
            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Livraison</h2>
                <div class="mt-4 space-y-3">
                    @foreach ($deliveryOptions as $option)
                        <label class="flex cursor-pointer items-center justify-between gap-3 rounded-xl border border-bj-border p-4 transition has-[:checked]:border-bj-navy has-[:checked]:bg-bj-cream">
                            <span class="flex items-center gap-3">
                                <input type="radio" name="delivery_option_id" value="{{ $option->id }}"
                                       data-price="{{ $option->price }}"
                                       @checked(old('delivery_option_id', $deliveryOptions->first()->id) == $option->id)
                                       class="h-4 w-4 accent-bj-navy">
                                <span>
                                    <span class="block text-sm font-medium text-bj-navy">{{ $option->zone }}</span>
                                    <span class="block text-xs text-bj-ink/60">Livraison sous {{ $option->delay_days }} jour{{ $option->delay_days > 1 ? 's' : '' }}</span>
                                </span>
                            </span>
                            <span class="text-sm font-semibold text-bj-navy">{{ number_format($option->price, 0, ',', ' ') }} FCFA</span>
                        </label>
                    @endforeach
                </div>
                @error('delivery_option_id')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Coordonnées --}}
            <div class="rounded-2xl border border-bj-border bg-white p-6">
                <h2 class="font-display text-xl font-semibold text-bj-navy">Vos coordonnées</h2>
                <div class="mt-4 space-y-4">
                    <div>
                        <label for="customer_name" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Nom complet</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                               class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                        @error('customer_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="customer_phone" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Téléphone</label>
                        <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required
                               placeholder="+225 ..."
                               class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                        @error('customer_phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="customer_email" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">
                            E-mail <span class="normal-case tracking-normal text-bj-ink/50">(facultatif — pour recevoir la confirmation de commande)</span>
                        </label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}"
                               placeholder="vous@exemple.com"
                               class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                        @error('customer_email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="customer_address" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Adresse de livraison</label>
                        <textarea id="customer_address" name="customer_address" rows="3" required
                                  class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">{{ old('customer_address') }}</textarea>
                        @error('customer_address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-full bg-bj-navy px-7 py-4 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Enregistrer ma commande
            </button>
            <p class="text-center text-xs text-bj-ink/60">Vous choisirez ensuite votre mode de finalisation : Mobile Money ou WhatsApp.</p>
        </form>
    </section>

@endsection

@push('scripts')
<script>
    // Récapitulatif dynamique : met à jour la livraison et le total au choix de l'option (doc §2.2).
    (function () {
        const subtotal = {{ $subtotal }};
        const discount = {{ $discount }};
        const deliveryEl = document.querySelector('[data-recap-delivery]');
        const totalEl = document.querySelector('[data-recap-total]');
        const radios = document.querySelectorAll('input[name="delivery_option_id"]');

        const formatFcfa = (amount) => new Intl.NumberFormat('fr-FR').format(amount) + ' FCFA';

        function refresh() {
            const checked = document.querySelector('input[name="delivery_option_id"]:checked');
            const delivery = checked ? parseInt(checked.dataset.price, 10) : 0;
            deliveryEl.textContent = formatFcfa(delivery);
            totalEl.textContent = formatFcfa(Math.max(0, subtotal - discount + delivery));
        }

        radios.forEach((radio) => radio.addEventListener('change', refresh));
        refresh();
    })();
</script>
@endpush
