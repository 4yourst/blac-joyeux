@extends('layouts.admin')

@section('title', 'Nouvelle option de livraison')

@section('content')

    <a href="{{ route('admin.delivery-options.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-bj-navy">
        &larr; Retour aux livraisons
    </a>
    <h1 class="mt-4 font-display text-3xl font-semibold text-bj-navy">Nouvelle option de livraison</h1>

    @include('admin.delivery-options._form', [
        'action' => route('admin.delivery-options.store'),
        'method' => 'POST',
    ])

@endsection
