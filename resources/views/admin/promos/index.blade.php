@extends('layouts.admin')

@section('title', 'Codes promo')

@section('content')

    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-display text-3xl font-semibold text-bj-navy">Codes promo</h1>
            <p class="mt-1 text-sm text-bj-ink/60">Réductions, dates de validité et statut.</p>
        </div>
        <a href="{{ route('admin.promos.create') }}"
           class="inline-flex items-center rounded-full bg-bj-navy px-5 py-3 text-xs font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Nouveau code
        </a>
    </div>

    @if ($promos->isEmpty())
        <p class="mt-8 rounded-2xl border border-bj-border bg-white p-6 text-sm text-bj-ink/60">Aucun code promo.</p>
    @else
        <div class="mt-8 overflow-hidden rounded-2xl border border-bj-border bg-white">
            <table class="w-full text-sm">
                <thead class="border-b border-bj-border bg-bj-sand/40 text-left text-xs uppercase tracking-widest text-bj-ink/60">
                    <tr>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3 text-center">Réduction</th>
                        <th class="px-4 py-3">Période</th>
                        <th class="px-4 py-3 text-center">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bj-border">
                    @foreach ($promos as $promo)
                        @php($isLive = $promo->is_active && $promo->starts_at <= now() && $promo->ends_at >= now())
                        <tr class="transition hover:bg-bj-cream/40">
                            <td class="px-4 py-3 font-semibold uppercase text-bj-navy">{{ $promo->code }}</td>
                            <td class="px-4 py-3 text-center text-bj-navy">−{{ $promo->discount_percent }} %</td>
                            <td class="px-4 py-3 text-bj-ink/70">
                                {{ $promo->starts_at->translatedFormat('d/m/Y H:i') }} → {{ $promo->ends_at->translatedFormat('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($isLive)
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">En cours</span>
                                @elseif (! $promo->is_active)
                                    <span class="inline-flex items-center rounded-full bg-bj-sand px-2.5 py-1 text-xs font-medium text-bj-ink/60">Inactif</span>
                                @elseif ($promo->ends_at < now())
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">Expiré</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">À venir</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.promos.edit', $promo) }}" class="text-xs font-medium uppercase tracking-widest text-bj-navy transition hover:text-bj-gold">Modifier</a>
                                    <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST"
                                          onsubmit="return confirm('Supprimer le code « {{ $promo->code }} » ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-medium uppercase tracking-widest text-red-600 transition hover:text-red-800">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
