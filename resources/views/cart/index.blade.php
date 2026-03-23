@extends('layouts.shop')

@section('title', 'Panier')

@section('content')
  @php
    $assetBase = rtrim((string) config('services.uniko.asset_url', ''), '/');
  @endphp
  <section class="max-w-6xl mx-auto px-4 pt-8">
    <h1 class="text-2xl font-semibold">Panier</h1>

    @if (count($items) === 0)
      <div class="mt-6 rounded-2xl border border-zinc-200 bg-white p-6">
        <div class="text-zinc-600">Ton panier est vide.</div>
        <a href="{{ route('shop.catalog') }}" class="mt-4 inline-flex rounded-lg bg-zinc-900 px-4 py-2 text-white text-sm font-medium hover:bg-zinc-800">Aller au catalogue</a>
      </div>
      @return
    @endif

    <form method="POST" action="{{ route('cart.update') }}" class="mt-6 grid lg:grid-cols-3 gap-6">
      @csrf

      <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white">
        <div class="p-4 border-b border-zinc-200 font-medium">Articles</div>
        <div class="divide-y divide-zinc-200">
          @foreach ($items as $item)
            @php($p = $item['product'])
            <div class="p-4 flex items-center gap-4" data-cart-row data-unit-price="{{ (float) $p->price }}">
              <a href="{{ route('shop.product', $p) }}" class="block flex-none rounded-xl border border-zinc-200 bg-white overflow-hidden" style="width:64px;height:64px;min-width:64px;min-height:64px;">
                @if (!empty($p->image_path))
                  <img
                    src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($p->image_path, '/') }}"
                    alt="{{ $p->name }}"
                    class="block h-full w-full object-cover"
                    loading="lazy"
                  />
                @else
                  <div class="h-full w-full bg-gradient-to-br from-zinc-100 via-white to-zinc-200"></div>
                @endif
              </a>

              <div class="min-w-0 flex-1">
                <div class="text-xs text-zinc-500">{{ $p->brand }}</div>
                <a class="font-medium hover:underline" href="{{ route('shop.product', $p) }}">{{ $p->name }}</a>
                <div class="text-sm text-zinc-600 mt-1">{{ number_format((float) $p->price, 2, ',', ' ') }}</div>
              </div>

              <div class="w-28">
                <label class="text-xs text-zinc-500">Qté</label>
                <input type="number" min="0" max="99" name="items[{{ $p->id }}]" value="{{ $item['qty'] }}" class="mt-1 w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm" data-cart-qty />
              </div>

              <div class="w-28 text-right">
                <div class="text-xs text-zinc-500">Total</div>
                <div class="mt-1 font-semibold text-sm" data-cart-line-total>{{ number_format((float) $item['line_total'], 2, ',', ' ') }}</div>
              </div>

              <button form="remove-{{ $p->id }}" class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm hover:bg-zinc-50" type="submit">Retirer</button>
            </div>
          @endforeach
        </div>
      </div>

      <div class="rounded-2xl border border-zinc-200 bg-white p-4 h-fit">
        <div class="font-medium">Résumé</div>
        <div class="mt-4 flex items-center justify-between text-sm">
          <span class="text-zinc-600">Sous-total</span>
          <span class="font-semibold" data-cart-subtotal>{{ number_format((float) $subtotal, 2, ',', ' ') }}</span>
        </div>
        <div class="mt-1 text-xs text-zinc-500">Paiement sur place / livraison · Retrait boutique.</div>

        <a href="{{ route('checkout.index') }}" class="mt-4 block w-full text-center rounded-lg bg-zinc-900 px-4 py-2 text-white text-sm font-medium hover:bg-zinc-800">Commander</a>
        <button class="mt-2 w-full rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm hover:bg-zinc-50" type="submit">Mettre à jour</button>
        <a href="{{ url('/catalogue') }}" class="mt-2 block w-full text-center text-sm text-zinc-600 hover:text-zinc-900">Continuer mes achats</a>
      </div>
    </form>

    <script>
      (function () {
        var formatMoney = function (value) {
          var num = Number(value);
          if (!Number.isFinite(num)) num = 0;
          return new Intl.NumberFormat('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
          }).format(num);
        };

        var rows = document.querySelectorAll('[data-cart-row]');
        if (!rows || rows.length === 0) return;

        var subtotalEl = document.querySelector('[data-cart-subtotal]');

        var recalc = function () {
          var subtotal = 0;

          rows.forEach(function (row) {
            var unitPrice = Number(row.getAttribute('data-unit-price'));
            if (!Number.isFinite(unitPrice)) unitPrice = 0;

            var qtyInput = row.querySelector('[data-cart-qty]');
            var lineEl = row.querySelector('[data-cart-line-total]');

            var qty = qtyInput ? Number(qtyInput.value) : 0;
            if (!Number.isFinite(qty)) qty = 0;
            qty = Math.max(0, Math.min(99, Math.floor(qty)));

            if (qtyInput && String(qtyInput.value) !== String(qty)) {
              qtyInput.value = qty;
            }

            var lineTotal = unitPrice * qty;
            subtotal += lineTotal;

            if (lineEl) {
              lineEl.textContent = formatMoney(lineTotal);
            }
          });

          if (subtotalEl) {
            subtotalEl.textContent = formatMoney(subtotal);
          }
        };

        rows.forEach(function (row) {
          var qtyInput = row.querySelector('[data-cart-qty]');
          if (!qtyInput) return;
          qtyInput.addEventListener('input', recalc);
          qtyInput.addEventListener('change', recalc);
        });

        recalc();
      })();
    </script>

    @foreach ($items as $item)
      @php($p = $item['product'])
      <form id="remove-{{ $p->id }}" method="POST" action="{{ route('cart.remove', $p) }}" class="hidden">
        @csrf
      </form>
    @endforeach
  </section>
@endsection
