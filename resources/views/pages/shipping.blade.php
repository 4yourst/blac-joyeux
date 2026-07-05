@extends('layouts.app')

@section('title', 'Livraison & Paiement — Blac Joyaux')
@section('meta_description', 'Zones et délais de livraison à Abidjan et en Côte d\'Ivoire, tarifs, et moyens de paiement acceptés (Mobile Money et espèces à la livraison) chez Blac Joyaux.')

@section('content')

    {{-- En-tête --}}
    <section class="mx-auto max-w-3xl px-5 pt-12 text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Commander en confiance</p>
        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight text-bj-navy sm:text-5xl">Livraison &amp; Paiement</h1>
        <p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-bj-ink/75">
            Des délais clairs, des tarifs affichés et plusieurs moyens de paiement : tout est pensé
            pour que votre commande se passe simplement, à Abidjan comme partout en Côte d'Ivoire.
        </p>
    </section>

    {{-- Livraison --}}
    <section class="mx-auto mt-14 max-w-3xl px-5">
        <h2 class="font-display text-3xl font-semibold text-bj-navy">Zones &amp; délais de livraison</h2>
        <p class="mt-2 text-sm text-bj-ink/70">Le délai et le tarif sont rappelés au moment de la finalisation.</p>

        <div class="mt-8 overflow-hidden rounded-2xl border border-bj-border bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-bj-border bg-bj-sand/40 text-left text-xs uppercase tracking-widest text-bj-ink/50">
                    <tr>
                        <th class="px-5 py-3">Zone</th>
                        <th class="px-5 py-3 text-center">Délai</th>
                        <th class="px-5 py-3 text-right">Tarif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bj-border">
                    @forelse ($deliveryOptions as $option)
                        <tr>
                            <td class="px-5 py-4 font-medium text-bj-navy">{{ $option->zone }}</td>
                            <td class="px-5 py-4 text-center text-bj-ink/80">
                                sous {{ $option->delay_days }} jour{{ $option->delay_days > 1 ? 's' : '' }}
                            </td>
                            <td class="px-5 py-4 text-right font-semibold text-bj-gold">{{ number_format($option->price, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-4 text-sm text-bj-ink/60">Options de livraison à venir.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Paiement — section sombre pleine largeur --}}
    <section class="mt-16 bg-bj-navy py-16 text-bj-cream sm:py-20">
        <div class="mx-auto max-w-3xl px-5">
            <h2 class="font-display text-3xl font-semibold sm:text-4xl">Moyens de paiement</h2>
            <p class="mt-2 text-sm text-bj-cream/70">Réglez comme il vous convient, en toute sécurité.</p>

            <div class="mt-8 grid gap-6 sm:grid-cols-2">
                {{-- Mobile Money --}}
                <div class="rounded-2xl bg-white/5 p-6 ring-1 ring-white/10">
                    <p class="text-[11px] font-medium uppercase tracking-[0.25em] text-bj-gold-soft">Paiement Mobile Money</p>
                    <h3 class="mt-2 font-display text-xl font-semibold">Rapide &amp; autonome</h3>
                    <ul class="mt-4 space-y-2 text-sm text-bj-cream/85">
                        @forelse ($mobileMethods as $method)
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-bj-gold-soft"></span>
                                {{ $method->name }}
                            </li>
                        @empty
                            <li class="text-bj-cream/60">Moyens Mobile Money à venir.</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Espèces / WhatsApp --}}
                <div class="rounded-2xl bg-white/5 p-6 ring-1 ring-white/10">
                    <p class="text-[11px] font-medium uppercase tracking-[0.25em] text-bj-gold-soft">À la livraison</p>
                    <h3 class="mt-2 font-display text-xl font-semibold">Payer en espèces</h3>
                    <ul class="mt-4 space-y-2 text-sm text-bj-cream/85">
                        @foreach ($cashMethods as $method)
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-bj-gold-soft"></span>
                                {{ $method->name }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-sm leading-relaxed text-bj-cream/70">
                        En finalisant votre commande sur WhatsApp, vous pouvez convenir d'un règlement
                        en espèces à la réception de votre sac.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Réassurance --}}
    <section class="mx-auto max-w-3xl px-5 py-16">
        <div class="grid gap-6 sm:grid-cols-3">
            <div class="text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Suivi personnalisé</p>
                <p class="mt-1 text-sm text-bj-ink/60">Un conseiller vous accompagne, avant et après l'achat.</p>
            </div>
            <div class="text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Adresse difficile ?</p>
                <p class="mt-1 text-sm text-bj-ink/60">Précisez-la sur WhatsApp, on trouve ensemble.</p>
            </div>
            <div class="text-center">
                <p class="font-display text-lg font-semibold text-bj-navy">Paiement flexible</p>
                <p class="mt-1 text-sm text-bj-ink/60">Mobile Money ou espèces à la livraison, au choix.</p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('collection') }}"
               class="inline-flex items-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Découvrir la collection
            </a>
            <p class="mt-4 text-sm text-bj-ink/60">
                Une question ? <a href="{{ route('contact') }}" class="font-medium text-bj-navy underline decoration-bj-gold underline-offset-4 transition hover:text-bj-gold">Contactez-nous</a>.
            </p>
        </div>
    </section>

@endsection
