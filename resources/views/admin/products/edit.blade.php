@extends('layouts.admin')

@section('title', 'Modifier un produit')

@section('content')

    <a href="{{ route('admin.products.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-bj-navy">
        &larr; Retour aux produits
    </a>
    <h1 class="mt-4 font-display text-3xl font-semibold text-bj-navy">Modifier « {{ $product->name }} »</h1>

    @include('admin.products._form', [
        'action' => route('admin.products.update', $product),
        'method' => 'PATCH',
    ])

@endsection
