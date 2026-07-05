{{-- Formulaire code promo partagé. Attend $promo, $action, $method. --}}
<form action="{{ $action }}" method="POST" class="mt-8 space-y-6">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-bj-border bg-white p-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="code" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Code *</label>
                <input type="text" id="code" name="code" value="{{ old('code', $promo->code) }}" required
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm uppercase text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="discount_percent" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Réduction (%) *</label>
                <input type="number" id="discount_percent" name="discount_percent" value="{{ old('discount_percent', $promo->discount_percent) }}" required min="1" max="100"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('discount_percent') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="starts_at" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Début *</label>
                <input type="datetime-local" id="starts_at" name="starts_at"
                       value="{{ old('starts_at', $promo->starts_at?->format('Y-m-d\TH:i')) }}" required
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('starts_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="ends_at" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/60">Fin *</label>
                <input type="datetime-local" id="ends_at" name="ends_at"
                       value="{{ old('ends_at', $promo->ends_at?->format('Y-m-d\TH:i')) }}" required
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('ends_at') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <input type="hidden" name="is_active" value="0">
                <label class="flex items-center gap-2 text-sm text-bj-ink/80">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $promo->is_active))
                           class="h-4 w-4 rounded accent-bj-navy">
                    Actif
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center rounded-full bg-bj-navy px-7 py-3.5 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Enregistrer
        </button>
        <a href="{{ route('admin.promos.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/60 transition hover:text-bj-navy">
            Annuler
        </a>
    </div>
</form>
