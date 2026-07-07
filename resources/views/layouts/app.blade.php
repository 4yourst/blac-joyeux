<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (file_exists(public_path('images/site/favicon.png')))
        <link rel="icon" type="image/png" href="{{ asset('images/site/favicon.png') }}">
    @endif

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
        $bannerPromo = \App\Models\PromoCode::currentlyValid()->orderBy('ends_at')->first();
        $navLinks = [
            ['route' => 'home', 'label' => 'Accueil'],
            ['route' => 'collection', 'label' => 'Collection'],
            ['route' => 'about', 'label' => 'Notre histoire'],
            ['route' => 'shipping', 'label' => 'Livraison & Paiement'],
            ['route' => 'contact', 'label' => 'Contact'],
            ['route' => 'faq', 'label' => 'FAQ'],
        ];
    @endphp

    {{-- Bannière promo avec compte à rebours basé sur la vraie date de fin --}}
    @if ($bannerPromo)
        <div id="promoBanner" data-ends="{{ $bannerPromo->ends_at->toIso8601String() }}"
             class="bg-bj-navy px-4 py-2.5 text-center text-sm text-bj-cream">
            <span class="font-medium">Code <span class="font-semibold text-bj-gold-soft">{{ $bannerPromo->code }}</span>
            · −{{ $bannerPromo->discount_percent }} %</span>
            <span class="text-bj-cream/70">— se termine dans</span>
            <span data-countdown class="font-semibold tabular-nums">…</span>
        </div>
    @endif

    {{-- En-tête --}}
    <header class="sticky top-0 z-40 border-b border-bj-border/70 bg-bj-cream/90 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-4">
            <a href="{{ route('home') }}" class="flex items-center">
                @if (file_exists(public_path('images/site/logo.png')))
                    <img src="{{ asset('images/site/logo.png') }}" alt="Blac Joyaux — by Blacom" class="h-9 w-auto sm:h-11">
                @else
                    <span class="flex flex-col leading-none">
                        <span class="font-display text-2xl font-semibold tracking-wide text-bj-navy">Blac Joyaux</span>
                        <span class="mt-0.5 text-[10px] font-medium uppercase tracking-[0.25em] text-bj-gold">Maroquinerie</span>
                    </span>
                @endif
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
                {{-- Bouton recherche (toutes les pages) --}}
                <button type="button" id="searchToggle" aria-label="Rechercher" aria-expanded="false" aria-controls="searchPanel"
                        class="rounded-full border border-bj-navy/20 p-2.5 text-bj-navy transition hover:bg-bj-navy hover:text-bj-cream">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3m1.8-4.45a6.25 6.25 0 1 1-12.5 0 6.25 6.25 0 0 1 12.5 0Z" />
                    </svg>
                </button>

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
            <nav class="mx-auto max-w-6xl px-5 py-3">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block rounded-lg px-3 py-2.5 text-sm transition {{ request()->routeIs($link['route']) ? 'bg-bj-sand font-medium text-bj-navy' : 'text-bj-ink/80 hover:bg-bj-sand/60' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Panneau de recherche (renvoie vers la page Collection) --}}
        <div id="searchPanel" class="hidden border-t border-bj-border/70 bg-bj-cream">
            <form method="GET" action="{{ route('collection') }}" class="mx-auto max-w-6xl px-5 py-4">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-bj-ink/40" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3m1.8-4.45a6.25 6.25 0 1 1-12.5 0 6.25 6.25 0 0 1 12.5 0Z" />
                    </svg>
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un sac…" autocomplete="off"
                           class="w-full rounded-full border border-bj-border bg-white py-3 pl-11 pr-28 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                    <button type="submit"
                            class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-full bg-bj-navy px-5 py-2 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </header>

    {{-- Messages flash --}}
    @if (session('status'))
        <div class="mx-auto mt-4 max-w-3xl px-5">
            <div class="flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                {{ session('status') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="mx-auto mt-4 max-w-3xl px-5">
            <div class="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    {{-- Pied de page --}}
    <footer class="mt-24 bg-bj-navy text-bj-cream">
        <div class="mx-auto max-w-6xl px-6 py-16">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Marque --}}
                <div class="lg:pr-6">
                    <p class="font-display text-3xl font-semibold">Blac Joyaux</p>
                    <p class="mt-1 text-[10px] font-medium uppercase tracking-[0.3em] text-bj-gold-soft">Maroquinerie ivoirienne</p>
                    <p class="mt-5 max-w-xs text-sm leading-relaxed text-bj-cream/80">
                        La collection Joyau de Bla, inspirée de la poupée de fécondité ashanti :
                        l'héritage culturel au service d'une élégance accessible.
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <a href="https://www.instagram.com/blacjoyaux/" target="_blank" rel="noopener" aria-label="Instagram" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-bj-cream/80 transition hover:border-bj-gold-soft hover:text-bj-cream">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.2c3.2 0 3.6 0 4.8.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.2.07 1.56.07 4.6s0 3.4-.07 4.6c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.2.06-1.56.07-4.8.07s-3.6 0-4.8-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.2 15.6 2.2 15.2 2.2 12s0-3.4.07-4.6c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.4 2.2 8.8 2.2 12 2.2Zm0 1.8c-3.15 0-3.5 0-4.74.07-.9.04-1.38.19-1.7.31-.43.17-.74.37-1.06.69-.32.32-.52.63-.69 1.06-.12.32-.27.8-.31 1.7C3.8 8.5 3.8 8.85 3.8 12s0 3.5.07 4.74c.04.9.19 1.38.31 1.7.17.43.37.74.69 1.06.32.32.63.52 1.06.69.32.12.8.27 1.7.31 1.24.07 1.59.07 4.74.07s3.5 0 4.74-.07c.9-.04 1.38-.19 1.7-.31.43-.17.74-.37 1.06-.69.32-.32.52-.63.69-1.06.12-.32.27-.8.31-1.7.07-1.24.07-1.59.07-4.74s0-3.5-.07-4.74c-.04-.9-.19-1.38-.31-1.7a2.85 2.85 0 0 0-.69-1.06 2.85 2.85 0 0 0-1.06-.69c-.32-.12-.8-.27-1.7-.31C15.5 4 15.15 4 12 4Zm0 3.06A4.94 4.94 0 1 1 12 16.94 4.94 4.94 0 0 1 12 7.06Zm0 1.8A3.14 3.14 0 1 0 12 15.14 3.14 3.14 0 0 0 12 8.86Zm5.14-3.24a1.15 1.15 0 1 1 0 2.3 1.15 1.15 0 0 1 0-2.3Z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/blacjoyaux" target="_blank" rel="noopener" aria-label="Facebook" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-bj-cream/80 transition hover:border-bj-gold-soft hover:text-bj-cream">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.33-.04-1.57-.14-2.88-.14C11.9 2 10 3.66 10 6.7v2.8H7v4h3V22h4v-8.5Z"/></svg>
                        </a>
                        <a href="https://www.tiktok.com/@blac.joyaux" target="_blank" rel="noopener" aria-label="TikTok" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-bj-cream/80 transition hover:border-bj-gold-soft hover:text-bj-cream">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.83-.02 8.74-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.58.07-5.37.01-4.03-.01-8.05.02-12.07z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Explorer --}}
                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.25em] text-bj-gold-soft">Explorer</h3>
                    <ul class="mt-4 space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="text-bj-cream/80 transition hover:text-bj-cream">Accueil</a></li>
                        <li><a href="{{ route('collection') }}" class="text-bj-cream/80 transition hover:text-bj-cream">Collection</a></li>
                        <li><a href="{{ route('about') }}" class="text-bj-cream/80 transition hover:text-bj-cream">Notre histoire</a></li>
                    </ul>
                </div>

                {{-- Aide --}}
                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.25em] text-bj-gold-soft">Aide</h3>
                    <ul class="mt-4 space-y-2.5 text-sm">
                        <li><a href="{{ route('shipping') }}" class="text-bj-cream/80 transition hover:text-bj-cream">Livraison &amp; Paiement</a></li>
                        <li><a href="{{ route('faq') }}" class="text-bj-cream/80 transition hover:text-bj-cream">Questions fréquentes</a></li>
                        <li><a href="{{ route('contact') }}" class="text-bj-cream/80 transition hover:text-bj-cream">Contact</a></li>
                    </ul>
                </div>

                {{-- Nous trouver --}}
                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.25em] text-bj-gold-soft">Nous trouver</h3>
                    <ul class="mt-4 space-y-2.5 text-sm text-bj-cream/80">
                        <li>Showroom — Cocody Palmeraie<br>Abidjan, Côte d'Ivoire</li>
                        <li>Lun – Sam · 9h – 18h</li>
                        <li>
                            <a href="https://wa.me/{{ config('blacjoyaux.whatsapp_number') }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-2 font-medium text-bj-cream transition hover:text-bj-gold-soft">
                                Écrire sur WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Barre basse --}}
            <div class="mt-14 flex flex-col gap-3 border-t border-white/10 pt-6 text-xs text-bj-cream/60 sm:flex-row sm:items-center sm:justify-between">
                <p class="uppercase tracking-widest">© {{ now()->year }} Blac Joyaux — Abidjan, Côte d'Ivoire</p>
                <p class="tracking-wide">Paiement Mobile Money &amp; espèces · Livraison 1 à 3 jours</p>
            </div>
        </div>
    </footer>

    {{-- Bouton WhatsApp flottant (contact direct avec un conseiller de la marque) --}}
    <a href="https://wa.me/{{ config('blacjoyaux.whatsapp_number') }}?text={{ rawurlencode('Bonjour Blac Joyaux, j\'ai une question.') }}"
       target="_blank" rel="noopener" aria-label="Écrire à Blac Joyaux sur WhatsApp"
       class="bj-fab fixed bottom-5 right-5 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-emerald-600 text-white shadow-lg shadow-emerald-900/25 transition duration-200 hover:scale-105 hover:bg-emerald-700 sm:bottom-6 sm:right-6">
        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.82 9.82 0 0 0 1.599 5.408l-.999 3.648 3.899-1.003zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.767.967-.94 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
        </svg>
        <span class="sr-only">Écrire sur WhatsApp</span>
    </a>

    {{-- Bascule du menu mobile et du panneau de recherche --}}
    <script>
        (function () {
            function bind(btnId, panelId, onOpen) {
                const btn = document.getElementById(btnId);
                const panel = document.getElementById(panelId);
                if (!btn || !panel) return;
                btn.addEventListener('click', function () {
                    const hidden = panel.classList.toggle('hidden');
                    btn.setAttribute('aria-expanded', String(!hidden));
                    if (!hidden && typeof onOpen === 'function') onOpen(panel);
                });
            }
            bind('menuToggle', 'mobileMenu');
            bind('searchToggle', 'searchPanel', function (panel) {
                const input = panel.querySelector('input[name="q"]');
                if (input) input.focus();
            });
        })();
    </script>

    {{-- Compte à rebours de la bannière promo (basé sur la vraie date de fin) --}}
    <script>
        (function () {
            const banner = document.getElementById('promoBanner');
            if (!banner) return;
            const output = banner.querySelector('[data-countdown]');
            const ends = new Date(banner.dataset.ends).getTime();

            function pad(n) { return String(n).padStart(2, '0'); }

            function tick() {
                const diff = ends - Date.now();
                if (diff <= 0) { banner.remove(); return; } // Promo expiré : la bannière disparaît.
                const totalSeconds = Math.floor(diff / 1000);
                const days = Math.floor(totalSeconds / 86400);
                const h = Math.floor((totalSeconds % 86400) / 3600);
                const m = Math.floor((totalSeconds % 3600) / 60);
                const s = totalSeconds % 60;
                output.textContent = (days > 0 ? days + 'j ' : '') + pad(h) + ':' + pad(m) + ':' + pad(s);
            }

            tick();
            setInterval(tick, 1000);
        })();
    </script>

    @stack('scripts')

</body>
</html>
