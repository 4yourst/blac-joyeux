<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — Blac Joyaux</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-bj-cream font-sans text-bj-ink antialiased">

    {{-- Barre d'administration --}}
    <header class="border-b border-bj-border bg-bj-navy text-bj-cream">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-5 py-4">
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col leading-none">
                <span class="font-display text-xl font-semibold tracking-wide">Blac Joyaux</span>
                <span class="mt-0.5 text-[10px] font-medium uppercase tracking-[0.25em] text-bj-gold-soft">Administration</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-medium uppercase tracking-widest text-bj-cream/70 transition hover:text-bj-cream">
                    Déconnexion
                </button>
            </form>
        </div>

        {{-- Navigation --}}
        <nav class="border-t border-white/10">
            <div class="mx-auto flex max-w-5xl gap-1 overflow-x-auto px-3 py-2 text-sm">
                @php
                    $navItems = [
                        'admin.dashboard' => 'Tableau de bord',
                        'admin.products.index' => 'Produits',
                        'admin.delivery-options.index' => 'Livraisons',
                        'admin.orders.index' => 'Commandes',
                    ];
                @endphp
                @foreach ($navItems as $route => $label)
                    @if (Route::has($route))
                        @php($active = request()->routeIs(str_replace('.index', '.*', $route)) || request()->routeIs($route))
                        <a href="{{ route($route) }}"
                           class="whitespace-nowrap rounded-lg px-3 py-2 transition {{ $active ? 'bg-white/15 text-bj-cream' : 'text-bj-cream/70 hover:bg-white/10 hover:text-bj-cream' }}">
                            {{ $label }}
                        </a>
                    @endif
                @endforeach
            </div>
        </nav>
    </header>

    {{-- Messages flash --}}
    @if (session('status'))
        <div class="mx-auto mt-4 max-w-5xl px-5">
            <div class="flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                {{ session('status') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="mx-auto mt-4 max-w-5xl px-5">
            <div class="flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="mx-auto max-w-5xl px-5 py-8">
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>
