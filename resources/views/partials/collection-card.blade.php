{{-- Carte produit premium (accueil + page Collection). Attend $product. --}}
<a href="{{ route('products.show', $product) }}" class="group block">
    <div class="relative aspect-[4/5] overflow-hidden rounded-2xl">
        <x-product-image :product="$product" size="card" />
        <span class="absolute left-3 top-3 z-10 rounded-full bg-bj-cream/90 px-3 py-1 text-[10px] font-medium uppercase tracking-widest text-bj-navy">
            {{ $product->collection }}
        </span>
    </div>
    <div class="mt-4 text-center">
        <h3 class="font-display text-xl font-semibold text-bj-navy transition group-hover:text-bj-gold">{{ $product->name }}</h3>
        <p class="mt-1.5 text-[15px] font-semibold tracking-wide text-bj-gold">{{ $product->formatted_price }}</p>
    </div>
</a>
