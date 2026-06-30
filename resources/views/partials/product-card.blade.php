{{-- Carte produit réutilisable. Attend $product (App\Models\Product). --}}
@php
    $imagePath = $product->image ? public_path('images/'.$product->image) : null;
    $hasImage = $imagePath && file_exists($imagePath);
@endphp
<a href="{{ route('products.show', $product) }}"
   class="group block overflow-hidden rounded-2xl border border-bj-border bg-white shadow-sm transition hover:shadow-md">
    <div class="relative aspect-[4/5] overflow-hidden bg-bj-sand">
        @if ($hasImage)
            <img src="{{ asset('images/'.$product->image) }}" alt="{{ $product->name }}"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            {{-- Visuel de remplacement (en attente des photos du pôle Création) --}}
            <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-bj-navy to-bj-navy-soft text-bj-cream">
                <span class="font-display text-5xl font-semibold tracking-tight">BJ</span>
                <span class="mt-2 text-[10px] uppercase tracking-[0.3em] text-bj-gold-soft">Joyau de Bla</span>
            </div>
        @endif
    </div>
    <div class="p-5">
        <h3 class="font-display text-xl font-semibold text-bj-navy">{{ $product->name }}</h3>
        <p class="mt-2 line-clamp-2 text-sm text-bj-ink/70">{{ $product->description }}</p>
        <p class="mt-4 text-sm font-semibold tracking-wide text-bj-gold">{{ $product->formatted_price }}</p>
    </div>
</a>
