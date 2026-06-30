{{-- Badge de voie de conversion / statut. Attend $order. --}}
@switch($order->status)
    @case('paid')
        <span class="inline-flex items-center rounded-full bg-bj-navy/10 px-2.5 py-1 text-xs font-medium text-bj-navy">Mobile Money</span>
        @break
    @case('whatsapp')
        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">WhatsApp</span>
        @break
    @default
        <span class="inline-flex items-center rounded-full bg-bj-sand px-2.5 py-1 text-xs font-medium text-bj-ink/60">En attente</span>
@endswitch
