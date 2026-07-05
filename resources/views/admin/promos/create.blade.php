@extends('layouts.admin')

@section('title', 'Nouveau code promo')

@section('content')

    <a href="{{ route('admin.promos.index') }}" class="text-xs font-medium uppercase tracking-widest text-bj-ink/50 transition hover:text-bj-navy">
        &larr; Retour aux codes promo
    </a>
    <h1 class="mt-4 font-display text-3xl font-semibold text-bj-navy">Nouveau code promo</h1>

    @include('admin.promos._form', [
        'action' => route('admin.promos.store'),
        'method' => 'POST',
    ])

@endsection
