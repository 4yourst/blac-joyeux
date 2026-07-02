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

    {{-- Emplacement pour les données structurées SEO (Product, Offer, FAQPage — doc §10.2) --}}
    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bj-cream font-sans text-bj-ink antialiased">

    @php
        $cartCount = app(\App\Services\Cart::class)->count();
        $navLinks = [
            ['route' => 'home', 'label' => 'Boutique'],
            ['route' => 'about', 'label' => 'Notre histoire'],
            ['route' => 'shipping', 'label' => 'Livraison & Paiement'],
            ['route' => 'contact', 'label' => 'Contact'],
            ['route' => 'faq', 'label' => 'FAQ'],
        ];
    @endphp

    {{-- En-tête --}}
    <header class="sticky top-0 z-40 border-b border-bj-border/70 bg-bj-cream/90 backdrop-blur">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-5 py-4">
            <a href="{{ route('home') }}" class="flex flex-col leading-none">
                <span class="font-display text-2xl font-semibold tracking-wide text-bj-navy">Blac Joyaux</span>
                <span class="mt-0.5 text-[10px] font-medium uppercase tracking-[0.25em] text-bj-gold">Maroquinerie</span>
            </a>

            {{-- Navigation desktop --}}
            <nav class="hidden items-center gap-6 lg:flex">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="text-sm transition {{ request()->routeIs($link['route']) ? 'font-medium text-bj-navy' : 'text-bj-ink/70 hover:text-bj-navy' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <a href="{{ route('cart.index') }}"
                   class="relative rounded-full border border-bj-navy/20 px-4 py-2 text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:bg-bj-navy hover:text-bj-cream">
                    Panier
                    @if ($cartCount > 0)
                        <span class="ml-1 inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-bj-gold px-1.5 text-[11px] font-semibold text-white">{{ $cartCount }}</span>
                    @endif
                </a>

                {{-- Bouton menu mobile --}}
                <button type="button" id="menuToggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="mobileMenu"
                        class="rounded-full border border-bj-navy/20 p-2.5 text-bj-navy transition hover:bg-bj-navy hover:text-bj-cream lg:hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Menu mobile --}}
        <div id="mobileMenu" class="hidden border-t border-bj-border/70 bg-bj-cream lg:hidden">
            <nav class="mx-auto max-w-5xl px-5 py-3">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block rounded-lg px-3 py-2.5 text-sm transition {{ request()->routeIs($link['route']) ? 'bg-bj-sand font-medium text-bj-navy' : 'text-bj-ink/80 hover:bg-bj-sand/60' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    {{-- Message flash --}}
    @if (session('status'))
        <div class="mx-auto mt-4 max-w-3xl px-5">
            <div class="flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                {{ session('status') }}
            </div>
        </div>
    @endif

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
            <nav class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-sm">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="text-bj-cream/70 transition hover:text-bj-cream">{{ $link['label'] }}</a>
                @endforeach
            </nav>
            <p class="mt-8 text-xs uppercase tracking-widest text-bj-cream/50">
                Abidjan, Côte d'Ivoire · {{ now()->year }}
            </p>
        </div>
    </footer>

    {{-- Bascule du menu mobile --}}
    <script>
        (function () {
            const toggle = document.getElementById('menuToggle');
            const menu = document.getElementById('mobileMenu');
            if (!toggle || !menu) return;
            toggle.addEventListener('click', function () {
                const hidden = menu.classList.toggle('hidden');
                toggle.setAttribute('aria-expanded', String(!hidden));
            });
        })();
    </script>

    @stack('scripts')

</body>
</html>
