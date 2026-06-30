{{-- Formulaire option de livraison partagé. Attend $deliveryOption, $action, $method. --}}
<form action="{{ $action }}" method="POST" class="mt-8 space-y-6">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-bj-border bg-white p-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="zone" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Zone *</label>
                <input type="text" id="zone" name="zone" value="{{ old('zone', $deliveryOption->zone) }}" required
                       placeholder="Ex. Abidjan — Cocody, Plateau"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('zone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="delay_days" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Délai (jours) *</label>
                <input type="number" id="delay_days" name="delay_days" value="{{ old('delay_days', $deliveryOption->delay_days) }}" required min="1" max="30" step="1"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('delay_days') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Tarif (FCFA) *</label>
                <input type="number" id="price" name="price" value="{{ old('price', $deliveryOption->price) }}" required min="0" step="1"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <input type="hidden" name="is_active" value="0">
                <label class="flex items-center gap-2 text-sm text-bj-ink/80">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $deliveryOption->is_active))
                           class="h-4 w-4 rounded accent-bj-navy">
                    Active (proposée à la cliente lors de la finalisation)
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center rounded-full bg-bj-navy px-7 py-3.5 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Enregistrer
        </button>
        <a href="{{ route('admin.delivery-options.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-bj-navy">
            Annuler
        </a>
    </div>
</form>
