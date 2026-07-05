{{-- Carte produit premium (accueil + page Collection). Attend $product. --}}
<a href="{{ route('products.show', $product) }}" class="group block">
    <div class="relative aspect-[4/5] overflow-hidden rounded-2xl">
        <x-product-image :product="$product" size="card" />
        <span class="absolute left-3 top-3 z-10 rounded-full bg-bj-cream/90 px-3 py-1 text-[10px] font-medium uppercase tracking-widest text-bj-navy">
            {{ $product->collection }}
        </span>
    </div>
    <div class="mt-4 text-center">
        <h3 class="font-display text-lg font-semibold text-bj-navy transition group-hover:text-bj-gold">{{ $product->name }}</h3>
        <p class="mt-1 text-sm tracking-wide text-bj-ink/70">{{ $product->formatted_price }}</p>
    </div>
</a>
