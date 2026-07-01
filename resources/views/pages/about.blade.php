@extends('layouts.app')

@section('title', 'Notre histoire — Blac Joyaux')
@section('meta_description', 'Blac Joyaux, maison de maroquinerie ivoirienne fondée par Manuela Kouadio. Découvrez la collection Joyau de Bla, inspirée de la poupée de fécondité ashanti.')

@section('content')

    {{-- En-tête --}}
    <section class="mx-auto max-w-3xl px-5 pt-12 text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">La maison</p>
        <h1 class="mt-4 font-display text-4xl font-semibold leading-tight text-bj-navy sm:text-5xl">Notre histoire</h1>
        <p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-bj-ink/75">
            Blac Joyaux est une maison de maroquinerie ivoirienne qui conjugue héritage culturel,
            savoir-faire et élégance accessible. Une marque née à Abidjan, portée par une conviction :
            le luxe peut être enraciné, responsable et fièrement africain.
        </p>
    </section>

    {{-- Visuel d'ouverture --}}
    <section class="mx-auto mt-10 max-w-5xl px-5">
        <x-lifestyle-image ratio="aspect-[16/9]" label="Photo lifestyle — Blac Joyaux" :eager="true" />
    </section>

    {{-- La fondatrice --}}
    <section class="mx-auto mt-20 max-w-5xl px-5">
        <div class="grid items-center gap-10 sm:grid-cols-2">
            <x-lifestyle-image ratio="aspect-[4/5]" label="Portrait — Manuela Kouadio" />
            <div>
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">La fondatrice</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-bj-navy">Manuela Kouadio</h2>
                <p class="mt-5 text-[15px] leading-relaxed text-bj-ink/80">
                    Derrière Blac Joyaux, il y a Manuela Kouadio, une créatrice attachée à sa terre
                    et à son héritage. De son enfance bercée par les récits et les symboles ashanti,
                    elle a gardé le goût des objets qui racontent une histoire.
                </p>
                <p class="mt-4 text-[15px] leading-relaxed text-bj-ink/80">
                    Sa démarche est simple et exigeante : créer des sacs à main d'une élégance intemporelle,
                    fabriqués en Côte d'Ivoire, accessibles sans jamais renoncer à la qualité. Chaque pièce
                    est pensée pour accompagner la femme active d'aujourd'hui, avec fierté et allure.
                </p>
            </div>
        </div>
    </section>

    {{-- La collection Joyau de Bla — section narrative sombre pleine largeur --}}
    <section class="mt-20 bg-bj-navy py-16 text-bj-cream sm:py-20">
        <div class="mx-auto grid max-w-5xl items-center gap-10 px-5 sm:grid-cols-2">
            <div>
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold-soft">La collection</p>
                <h2 class="mt-3 font-display text-3xl font-semibold sm:text-4xl">Joyau de Bla</h2>
                <p class="mt-5 text-[15px] leading-relaxed text-bj-cream/80">
                    La collection phare de la maison s'inspire de la poupée de fécondité ashanti,
                    figure emblématique du patrimoine ouest-africain, symbole de vie, de transmission
                    et de beauté.
                </p>
                <p class="mt-4 text-[15px] leading-relaxed text-bj-cream/80">
                    Chaque sac « Joyau de Bla » porte ce récit : des lignes épurées, une allure structurée,
                    et un supplément d'âme qui relie la femme qui le porte à un héritage plus grand qu'elle.
                    Un bijou du quotidien, à transmettre.
                </p>
            </div>
            <x-lifestyle-image ratio="aspect-[4/5]" label="Ambiance — Joyau de Bla" rounded="rounded-3xl" class="ring-1 ring-white/10" />
        </div>
    </section>

    {{-- Les valeurs --}}
    <section class="mx-auto max-w-5xl px-5 py-20">
        <div class="text-center">
            <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Nos valeurs</p>
            <h2 class="mt-3 font-display text-3xl font-semibold text-bj-navy">Ce qui nous guide</h2>
        </div>
        <div class="mt-12 grid gap-6 sm:grid-cols-3">
            <div class="rounded-2xl border border-bj-border bg-white p-7 text-center">
                <h3 class="font-display text-xl font-semibold text-bj-navy">Made in Côte d'Ivoire</h3>
                <p class="mt-3 text-sm leading-relaxed text-bj-ink/70">
                    Une fabrication locale qui valorise les mains et les talents ivoiriens.
                </p>
            </div>
            <div class="rounded-2xl border border-bj-border bg-white p-7 text-center">
                <h3 class="font-display text-xl font-semibold text-bj-navy">Durabilité</h3>
                <p class="mt-3 text-sm leading-relaxed text-bj-ink/70">
                    Des matières choisies et un travail soigné, pour des pièces faites pour durer.
                </p>
            </div>
            <div class="rounded-2xl border border-bj-border bg-white p-7 text-center">
                <h3 class="font-display text-xl font-semibold text-bj-navy">Élégance accessible</h3>
                <p class="mt-3 text-sm leading-relaxed text-bj-ink/70">
                    Le luxe à portée de main, de 40 000 à 100 000 FCFA, sans compromis sur la qualité.
                </p>
            </div>
        </div>
    </section>

    {{-- Le showroom --}}
    <section class="border-y border-bj-border bg-white/60">
        <div class="mx-auto grid max-w-5xl items-center gap-10 px-5 py-16 sm:grid-cols-2">
            <div>
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-bj-gold">Nous rencontrer</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-bj-navy">Le showroom</h2>
                <p class="mt-5 text-[15px] leading-relaxed text-bj-ink/80">
                    Poussez la porte de notre showroom à <strong>Cocody Palmeraie</strong>, à Abidjan,
                    pour découvrir la collection, toucher les matières et être conseillée.
                </p>
                <p class="mt-4 text-sm text-bj-ink/60">Cocody Palmeraie, Abidjan — Côte d'Ivoire</p>

                {{-- Réassurance : horaires (provisoires, à confirmer) + contact direct --}}
                <dl class="mt-6 space-y-2 text-sm">
                    <div class="flex items-start gap-3">
                        <dt class="w-24 shrink-0 text-xs font-medium uppercase tracking-widest text-bj-ink/50">Horaires</dt>
                        <dd class="text-bj-ink/80">Du lundi au samedi, 9h – 18h</dd>
                    </div>
                    <div class="flex items-start gap-3">
                        <dt class="w-24 shrink-0 text-xs font-medium uppercase tracking-widest text-bj-ink/50">Sur RDV</dt>
                        <dd class="text-bj-ink/80">Dimanche, sur rendez-vous</dd>
                    </div>
                </dl>

                <a href="https://wa.me/{{ config('blacjoyaux.whatsapp_number') }}?text={{ rawurlencode('Bonjour Blac Joyaux, je souhaite visiter votre showroom à Cocody Palmeraie.') }}"
                   target="_blank" rel="noopener"
                   class="mt-6 inline-flex items-center gap-2 rounded-full bg-emerald-600 px-6 py-3 text-xs font-medium uppercase tracking-widest text-white transition hover:bg-emerald-700">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.82 9.82 0 0 0 1.599 5.408l-.999 3.648 3.899-1.003zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.767.967-.94 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
                    </svg>
                    Nous écrire sur WhatsApp
                </a>
            </div>
            <x-lifestyle-image ratio="aspect-[4/5]" label="Le showroom — Cocody Palmeraie" />
        </div>
    </section>

    {{-- CTA final --}}
    <section class="mx-auto max-w-3xl px-5 py-20 text-center">
        <h2 class="font-display text-3xl font-semibold text-bj-navy">Découvrez la collection</h2>
        <p class="mx-auto mt-3 max-w-md text-sm text-bj-ink/70">
            Chaque pièce Joyau de Bla est une invitation à porter un morceau d'héritage.
        </p>
        <a href="{{ route('home') }}#collection"
           class="mt-8 inline-flex items-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Découvrir la collection
        </a>
    </section>

@endsection
