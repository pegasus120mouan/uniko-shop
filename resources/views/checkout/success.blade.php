@extends('layouts.shop')

@section('title', 'Commande confirmée')

@section('content')
  <section class="max-w-3xl mx-auto px-4 pt-10">
    <div class="rounded-3xl border border-zinc-200 bg-white p-6 md:p-8">
      <div class="text-xs text-zinc-500">Commande</div>
      <h1 class="mt-2 text-2xl md:text-3xl font-semibold">Commande confirmée</h1>
      <p class="mt-3 text-zinc-600">Nous te contacterons rapidement pour finaliser la livraison / le retrait.</p>

      @if (!empty($checkout))
        <div class="mt-6 rounded-2xl border border-zinc-200 bg-zinc-50 p-4">
          <div class="text-sm font-medium">Détails</div>
          <div class="mt-2 text-sm text-zinc-700">
            @if (!empty($checkout['order_number']))
              <div><span class="text-zinc-500">Numéro:</span> {{ $checkout['order_number'] }}</div>
            @endif
            <div><span class="text-zinc-500">Nom:</span> {{ $checkout['full_name'] ?? '—' }}</div>
            <div class="mt-1"><span class="text-zinc-500">Téléphone:</span> {{ $checkout['phone'] ?? '—' }}</div>
            <div class="mt-1"><span class="text-zinc-500">Mode:</span> {{ ($checkout['delivery_mode'] ?? '') === 'delivery' ? 'Livraison' : 'Retrait boutique' }}</div>
            @if (!empty($checkout['commune_nom']))
              <div class="mt-1"><span class="text-zinc-500">Commune:</span> {{ $checkout['commune_nom'] }}</div>
            @endif
            @if (!empty($checkout['address']))
              <div class="mt-1"><span class="text-zinc-500">Adresse:</span> {{ $checkout['address'] }}</div>
            @endif
            @if (isset($checkout['montant_a_payer']))
              <div class="mt-3 pt-3 border-t border-zinc-200">
                <div><span class="text-zinc-500">Total produits:</span> {{ number_format((int) ($checkout['subtotal'] ?? 0), 0, ',', ' ') }} FCFA</div>
                <div class="mt-1"><span class="text-zinc-500">Coût livraison:</span> {{ number_format((int) ($checkout['cout_livraison'] ?? 0), 0, ',', ' ') }} FCFA</div>
                <div class="mt-1"><span class="text-zinc-500">Montant à payer:</span> <span class="fw-semibold">{{ number_format((int) $checkout['montant_a_payer'], 0, ',', ' ') }} FCFA</span></div>
              </div>
            @endif
          </div>
        </div>
      @endif

      <div class="mt-6 flex flex-col sm:flex-row gap-3">
        <a href="{{ url('/catalogue') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-6 py-3 text-white text-sm font-medium hover:bg-zinc-800">Retour au catalogue</a>
        <a href="{{ route('shop.home') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-200 bg-white px-6 py-3 text-sm font-medium hover:bg-zinc-50">Accueil</a>
      </div>
    </div>
  </section>
@endsection
