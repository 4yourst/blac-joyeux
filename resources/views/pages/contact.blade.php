@extends('layouts.app')

@section('title', 'Contact — Blac Joyaux')
@section('meta_description', 'Contactez Blac Joyaux : showroom à Cocody Palmeraie (Abidjan), WhatsApp, et formulaire de contact. Livraison à Abidjan et en Côte d\'Ivoire.')

@section('content')

    {{-- En-tête --}}
    <section class="mx-auto max-w-3xl px-5 pt-12 text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Nous joindre</p>
        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight text-bj-navy sm:text-5xl">Contact</h1>
        <p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-bj-ink/75">
            Une question, un conseil avant achat ou l'envie de passer au showroom ? Écrivez-nous —
            nous répondons avec plaisir, en personne.
        </p>
    </section>

    {{-- Coordonnées + carte --}}
    <section class="mx-auto mt-12 max-w-5xl px-5">
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Coordonnées --}}
            <div class="rounded-3xl border border-bj-border bg-white p-7">
                <h2 class="font-display text-2xl font-semibold text-bj-navy">Le showroom</h2>

                <dl class="mt-6 space-y-4 text-sm">
                    <div class="flex items-start gap-3">
                        <dt class="w-24 shrink-0 text-xs font-medium uppercase tracking-widest text-bj-ink/60">Adresse</dt>
                        <dd class="text-bj-ink/80">Cocody Palmeraie, Abidjan — Côte d'Ivoire</dd>
                    </div>
                    <div class="flex items-start gap-3">
                        <dt class="w-24 shrink-0 text-xs font-medium uppercase tracking-widest text-bj-ink/60">Horaires</dt>
                        <dd class="text-bj-ink/80">Du lundi au samedi, 9h – 18h<br>Dimanche, sur rendez-vous</dd>
                    </div>
                    <div class="flex items-start gap-3">
                        <dt class="w-24 shrink-0 text-xs font-medium uppercase tracking-widest text-bj-ink/60">Téléphone</dt>
                        <dd class="text-bj-ink/80">+225 07 00 00 00 00</dd>
                    </div>
                </dl>

                <a href="https://wa.me/{{ config('blacjoyaux.whatsapp_number') }}?text={{ rawurlencode('Bonjour Blac Joyaux, j\'ai une question.') }}"
                   target="_blank" rel="noopener"
                   class="mt-7 inline-flex items-center gap-2 rounded-full bg-emerald-600 px-6 py-3 text-xs font-medium uppercase tracking-widest text-white transition hover:bg-emerald-700">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.82 9.82 0 0 0 1.599 5.408l-.999 3.648 3.899-1.003zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.767.967-.94 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
                    </svg>
                    Écrire sur WhatsApp
                </a>
            </div>

            {{-- Emplacement de la carte --}}
            <div class="relative min-h-64 overflow-hidden rounded-3xl border border-bj-border bg-bj-sand lg:min-h-full">
                <div class="absolute inset-0 flex flex-col items-center justify-center gap-3 bg-gradient-to-br from-bj-sand to-bj-cream text-bj-navy/60">
                    <svg class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="text-[10px] font-medium uppercase tracking-[0.3em]">Carte — Cocody Palmeraie</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Formulaire de contact --}}
    <section class="mx-auto mt-12 max-w-3xl px-5">
        <div class="rounded-3xl border border-bj-border bg-white p-7">
            <h2 class="font-display text-2xl font-semibold text-bj-navy">Écrivez-nous</h2>
            <p class="mt-2 text-sm text-bj-ink/60">Nous vous répondrons dans les meilleurs délais.</p>

            <form action="{{ route('contact.send') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Nom complet</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="+225 ..."
                           class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="message" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Message</label>
                    <textarea id="message" name="message" rows="5" required
                              class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">{{ old('message') }}</textarea>
                    @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-full bg-bj-navy px-7 py-4 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft sm:w-auto">
                    Envoyer le message
                </button>
            </form>
        </div>
    </section>

    {{-- Rappel livraison / paiement --}}
    <section class="mx-auto mt-12 max-w-5xl px-5 pb-4">
        <div class="grid gap-6 sm:grid-cols-2">
            <div class="rounded-2xl border border-bj-border bg-white/60 p-6">
                <h3 class="font-display text-xl font-semibold text-bj-navy">Livraison</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-bj-ink/70">
                    Abidjan (Cocody, Plateau, Marcory) en 1 jour, autres communes en 2 jours,
                    intérieur de la Côte d'Ivoire en 3 jours.
                </p>
            </div>
            <div class="rounded-2xl border border-bj-border bg-white/60 p-6">
                <h3 class="font-display text-xl font-semibold text-bj-navy">Paiement</h3>
                <p class="mt-3 text-[15px] leading-relaxed text-bj-ink/70">
                    Mobile Money (Wave, Orange Money, MTN, Moov) ou espèces à la livraison
                    en finalisant sur WhatsApp.
                </p>
            </div>
        </div>
    </section>

@endsection
