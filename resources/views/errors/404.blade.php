@extends('layouts.app')

@section('title', 'Page introuvable — Blac Joyaux')
@section('meta_description', 'La page que vous cherchez est introuvable. Découvrez la collection Joyau de Bla de Blac Joyaux.')

@section('content')

    <section class="mx-auto flex min-h-[60vh] max-w-3xl flex-col items-center justify-center px-6 py-24 text-center">

        {{-- Monogramme --}}
        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-bj-navy">
            <span class="font-display text-3xl font-semibold text-bj-gold-soft">BJ</span>
        </div>

        <p class="mt-8 text-xs font-medium uppercase tracking-[0.35em] text-bj-gold">Erreur 404</p>
        <h1 class="mt-4 font-display text-5xl font-semibold leading-tight text-bj-navy sm:text-6xl">
            Page introuvable
        </h1>
        <p class="mx-auto mt-5 max-w-md text-base leading-relaxed text-bj-ink/70">
            La page que vous cherchez n'existe pas ou a été déplacée. Mais votre prochaine pièce
            favorite, elle, vous attend dans la collection.
        </p>

        <div class="mt-10 flex flex-col items-center gap-3 sm:flex-row">
            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center rounded-full bg-bj-navy px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Retour à l'accueil
            </a>
            <a href="{{ route('home') }}#collection"
               class="inline-flex items-center justify-center rounded-full border border-bj-navy/20 px-8 py-4 text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:bg-bj-navy hover:text-bj-cream">
                Voir la collection
            </a>
        </div>

        <p class="mt-8 text-sm text-bj-ink/50">
            Besoin d'aide ? <a href="{{ route('contact') }}" class="font-medium text-bj-navy underline decoration-bj-gold underline-offset-4 transition hover:text-bj-gold">Contactez-nous</a>.
        </p>
    </section>

@endsection
