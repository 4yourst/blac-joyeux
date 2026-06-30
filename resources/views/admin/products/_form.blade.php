{{-- Formulaire produit partagé (création / édition). Attend $product et $action, $method. --}}
<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
    @csrf
    @if ($method === 'PATCH')
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-bj-border bg-white p-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="name" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Nom *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Slug (URL)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                       placeholder="généré automatiquement"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="price" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Prix (FCFA) *</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" step="1"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Description *</label>
                <textarea id="description" name="description" rows="3" required
                          class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="story" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Histoire du modèle (storytelling)</label>
                <textarea id="story" name="story" rows="3"
                          class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">{{ old('story', $product->story) }}</textarea>
                @error('story') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="dimensions" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Dimensions</label>
                <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('dimensions') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="material" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Matière</label>
                <input type="text" id="material" name="material" value="{{ old('material', $product->material) }}"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('material') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="care" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Entretien</label>
                <input type="text" id="care" name="care" value="{{ old('care', $product->care) }}"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-3 text-sm text-bj-navy focus:border-bj-navy focus:outline-none">
                @error('care') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <label for="image" class="block text-xs font-medium uppercase tracking-widest text-bj-ink/50">Visuel</label>
                @if ($product->image && file_exists(public_path('images/'.$product->image)))
                    <div class="mt-2 flex items-center gap-3">
                        <img src="{{ asset('images/'.$product->image) }}" alt="" class="h-16 w-16 rounded-lg object-cover">
                        <span class="text-xs text-bj-ink/50">Visuel actuel — téléversez un fichier pour le remplacer.</span>
                    </div>
                @endif
                <input type="file" id="image" name="image" accept="image/*"
                       class="mt-2 w-full rounded-xl border border-bj-border px-4 py-2.5 text-sm text-bj-ink/70 file:mr-3 file:rounded-full file:border-0 file:bg-bj-navy file:px-4 file:py-1.5 file:text-xs file:font-medium file:uppercase file:tracking-widest file:text-bj-cream">
                @error('image') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="sm:col-span-2">
                <input type="hidden" name="is_available" value="0">
                <label class="flex items-center gap-2 text-sm text-bj-ink/80">
                    <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $product->is_available))
                           class="h-4 w-4 rounded accent-bj-navy">
                    Disponible à la vente
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="inline-flex items-center rounded-full bg-bj-navy px-7 py-3.5 text-sm font-medium uppercase tracking-widest text-bj-cream transition hover:bg-bj-navy-soft">
            Enregistrer
        </button>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-bj-navy">
            Annuler
        </a>
    </div>
</form>
