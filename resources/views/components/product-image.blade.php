@props([
    'product',
    'size' => 'card',        // card | hero | thumbnail
    'eager' => false,        // true = pas de lazy (visuels above-the-fold, ex. hero)
    'hoverImage' => null,    // chemin relatif d'une 2e image révélée au survol (optionnel, pour plus tard)
])

@php
    $hasImage = $product->image && file_exists(public_path('images/'.$product->image));
    $hasHover = $hoverImage && file_exists(public_path('images/'.$hoverImage));

    $monogram = match ($size) {
        'thumbnail' => 'text-lg',
        'hero' => 'text-6xl sm:text-7xl',
        default => 'text-5xl',
    };
    $showLabel = $size !== 'thumbnail';
    $loading = $eager ? 'eager' : 'lazy';
@endphp

{{-- Conteneur qui remplit son parent (le wrapper de ratio est géré par la vue appelante) --}}
<div class="relative h-full w-full overflow-hidden bg-bj-sand">
    @if ($hasImage)
        <img src="{{ asset('images/'.$product->image) }}" alt="{{ $product->name }}" loading="{{ $loading }}"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

        @if ($hasHover)
            {{-- 2e image révélée au survol (fondu doux) — n'agit que dans un conteneur .group --}}
            <img src="{{ asset('images/'.$hoverImage) }}" alt="" loading="lazy"
                 class="absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity duration-500 group-hover:opacity-100">
        @endif
    @else
        {{-- Placeholder de marque : remplit le conteneur à tout ratio, monogramme centré (jamais déformé) --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-bj-navy to-bj-navy-soft text-center text-bj-cream">
            <span class="font-display font-semibold leading-none {{ $monogram }}">BJ</span>
            @if ($showLabel)
                <span class="mt-2 max-w-[85%] truncate px-2 text-[10px] uppercase tracking-[0.3em] text-bj-gold-soft">{{ $product->name }}</span>
            @endif
        </div>
    @endif
</div>
