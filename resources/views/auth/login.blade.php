<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion — Administration Blac Joyaux</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-bj-cream px-5 font-sans text-bj-ink antialiased">

    <div class="w-full max-w-sm">
        <div class="text-center">
            <p class="font-display text-3xl font-semibold text-bj-navy">Blac Joyaux</p>
            <p class="mt-1 text-[11px] font-medium uppercase tracking-[0.3em] text-bj-gold">Administration</p>
        </div>

        <form method="POST" action="{{ route('login') }}"
              class="mt-8 space-y-5 rounded-3xl border border-bj-border bg-white p-7 shadow-sm">
            @csrf

            <div>
                <label for="email" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="mt-2 w-full rounded-xl border border-bj-border bg-white px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <label for="remember_me" class="flex items-center gap-2 text-sm text-bj-ink/70">
                <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded accent-bj-navy">
                Se souvenir de moi
            </label>

            <button type="submit"
                    class="w-full rounded-full bg-bj-navy px-7 py-3.5 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
                Se connecter
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-bj-ink/50">
            <a href="{{ route('home') }}" class="transition hover:text-bj-navy">&larr; Retour à la boutique</a>
        </p>
    </div>

</body>
</html>
