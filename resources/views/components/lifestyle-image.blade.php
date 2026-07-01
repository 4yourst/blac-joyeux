@props([
    'ratio' => 'aspect-[4/3]',   // classe d'aspect (aspect-[4/3], aspect-square, aspect-video…)
    'label' => 'Visuel à venir', // légende du placeholder
    'image' => null,             // chemin relatif dans public/ (ex. images/lifestyle/xxx.webp) — pour plus tard
    'eager' => false,
    'rounded' => 'rounded-3xl',
])

@php
    $hasImage = $image && file_exists(public_path($image));
    $loading = $eager ? 'eager' : 'lazy';
@endphp

{{-- Emplacement pour une photo lifestyle. Affiche la vraie image si fournie, sinon un placeholder de marque. --}}
<div {{ $attributes->merge(['class' => "relative $ratio $rounded overflow-hidden bg-bj-sand"]) }}>
    @if ($hasImage)
        <img src="{{ asset($image) }}" alt="{{ $label }}" loading="{{ $loading }}"
             class="h-full w-full object-cover">
    @else
        {{-- Placeholder de marque : dégradé marine + monogramme « BJ » doré + libellé --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 bg-gradient-to-br from-bj-navy to-bj-navy-soft text-center">
            <span class="font-display text-5xl font-semibold leading-none text-bj-gold-soft">BJ</span>
            <span class="max-w-[85%] px-3 text-[10px] font-medium uppercase tracking-[0.3em] text-bj-cream/70">{{ $label }}</span>
        </div>
    @endif
</div>
