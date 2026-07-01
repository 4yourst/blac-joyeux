{{-- Carte produit réutilisable. Attend $product (App\Models\Product). --}}
<a href="{{ route('products.show', $product) }}"
   class="group block overflow-hidden rounded-2xl border border-bj-border bg-white shadow-sm transition hover:shadow-md">
    <div class="aspect-[4/5]">
        <x-product-image :product="$product" size="card" />
    </div>
    <div class="p-5">
        <h3 class="font-display text-xl font-semibold text-bj-navy">{{ $product->name }}</h3>
        <p class="mt-2 line-clamp-2 text-sm text-bj-ink/70">{{ $product->description }}</p>
        <p class="mt-4 text-sm font-semibold tracking-wide text-bj-gold">{{ $product->formatted_price }}</p>
    </div>
</a>
