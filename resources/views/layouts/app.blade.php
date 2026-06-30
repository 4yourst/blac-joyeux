<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Blac Joyaux — Maroquinerie ivoirienne')</title>
    <meta name="description" content="@yield('meta_description', 'Blac Joyaux, maison de maroquinerie ivoirienne. Sacs à main de la collection Joyau de Bla — élégance, héritage et luxe accessible.')">

    {{-- Polices : serif élégante pour les titres, sans pour le texte. Dégrade proprement hors-ligne. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bj-cream font-sans text-bj-ink antialiased">

    {{-- En-tête --}}
    <header class="sticky top-0 z-40 border-b border-bj-border/70 bg-bj-cream/90 backdrop-blur">
        <div class="mx-auto flex max-w-3xl items-center justify-between px-5 py-4">
            <a href="{{ route('home') }}" class="flex flex-col leading-none">
                <span class="font-display text-2xl font-semibold tracking-wide text-bj-navy">Blac Joyaux</span>
                <span class="mt-0.5 text-[10px] font-medium uppercase tracking-[0.25em] text-bj-gold">Maroquinerie</span>
            </a>
            <a href="#collection"
               class="rounded-full border border-bj-navy/20 px-4 py-2 text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:bg-bj-navy hover:text-bj-cream">
                Collection
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- Pied de page --}}
    <footer class="mt-20 border-t border-bj-border bg-bj-navy text-bj-cream">
        <div class="mx-auto max-w-3xl px-5 py-12">
            <p class="font-display text-3xl font-medium">Blac Joyaux</p>
            <p class="mt-3 max-w-sm text-sm leading-relaxed text-bj-cream/70">
                Maison de maroquinerie ivoirienne. La collection Joyau de Bla s'inspire de la poupée
                de fécondité ashanti — l'héritage culturel au service d'une élégance accessible.
            </p>
            <p class="mt-8 text-xs uppercase tracking-widest text-bj-cream/50">
                Abidjan, Côte d'Ivoire · {{ now()->year }}
            </p>
        </div>
    </footer>

</body>
</html>
