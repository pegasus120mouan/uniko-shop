@extends('layouts.shop')

@section('title', 'Commander')

@section('content')
  @php
    $assetBase = rtrim((string) config('services.uniko.asset_url', ''), '/');
  @endphp

  <section class="max-w-6xl mx-auto px-4 pt-8">
    <div class="flex items-start justify-between gap-4 flex-wrap">
      <div>
        <h1 class="text-2xl font-semibold">Commander</h1>
        <p class="text-zinc-600 text-sm mt-1">Paiement sur place / à la livraison.</p>
      </div>
      <a href="{{ route('cart.index') }}" class="text-sm text-zinc-600 hover:text-zinc-900">← Retour au panier</a>
    </div>

    @if (count($items) === 0)
      <div class="mt-6 rounded-2xl border border-zinc-200 bg-white p-6">
        <div class="text-zinc-600">Ton panier est vide.</div>
        <a href="{{ url('/catalogue') }}" class="mt-4 inline-flex rounded-lg bg-zinc-900 px-4 py-2 text-white text-sm font-medium hover:bg-zinc-800">Aller au catalogue</a>
      </div>
      @return
    @endif

    <div class="mt-6 grid lg:grid-cols-3 gap-6">
      <form method="POST" action="{{ route('checkout.store') }}" class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white p-5">
        @csrf

        <div class="font-medium">Informations client</div>

        <div class="mt-4 grid sm:grid-cols-2 gap-4">
          <div>
            <label class="text-xs text-zinc-600">Nom complet</label>
            <input name="full_name" value="{{ old('full_name') }}" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm" required />
            @error('full_name')
              <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div>
            <label class="text-xs text-zinc-600">Téléphone</label>
            <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm" required />
            @error('phone')
              <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="mt-4">
          <div class="text-xs text-zinc-600">Mode</div>
          <div class="mt-2 grid sm:grid-cols-2 gap-3">
            <label class="rounded-xl border border-zinc-200 bg-white p-4 flex items-start gap-3 cursor-pointer">
              <input type="radio" name="delivery_mode" value="pickup" class="mt-1" {{ old('delivery_mode', 'pickup') === 'pickup' ? 'checked' : '' }} />
              <span>
                <span class="block text-sm font-medium">Retrait boutique</span>
                <span class="block text-xs text-zinc-600 mt-0.5">Tu récupères ta commande sur place.</span>
              </span>
            </label>

            <label class="rounded-xl border border-zinc-200 bg-white p-4 flex items-start gap-3 cursor-pointer">
              <input type="radio" name="delivery_mode" value="delivery" class="mt-1" {{ old('delivery_mode') === 'delivery' ? 'checked' : '' }} />
              <span>
                <span class="block text-sm font-medium">Livraison</span>
                <span class="block text-xs text-zinc-600 mt-0.5">On livre à l’adresse indiquée.</span>
              </span>
            </label>
          </div>
          @error('delivery_mode')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="mt-4" data-commune-wrap style="display:none;">
          <label class="text-xs text-zinc-600">Commune (si livraison)</label>
          <select name="commune_id" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm">
            <option value="">Choisir une commune</option>
            @foreach ($communes as $commune)
              <option value="{{ $commune->id }}" data-commune-cost="{{ (int) $commune->cout_livraison }}" {{ (string) old('commune_id') === (string) $commune->id ? 'selected' : '' }}>
                {{ $commune->nom }}
              </option>
            @endforeach
          </select>
          @error('commune_id')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="mt-4">
          <label class="text-xs text-zinc-600">Adresse (si livraison)</label>
          <textarea name="address" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm" rows="3">{{ old('address') }}</textarea>
          @error('address')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <div class="mt-4">
          <label class="text-xs text-zinc-600">Note (optionnel)</label>
          <textarea name="note" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm" rows="3">{{ old('note') }}</textarea>
          @error('note')
            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
          @enderror
        </div>

        <button class="mt-5 w-full rounded-xl bg-zinc-900 px-4 py-3 text-white text-sm font-medium hover:bg-zinc-800" type="submit">Confirmer la commande</button>
        <div class="mt-2 text-xs text-zinc-500">En confirmant, tu valides ta commande. Paiement sur place / livraison.</div>
      </form>

      <div class="rounded-2xl border border-zinc-200 bg-white p-5 h-fit">
        <div class="font-medium">Récapitulatif</div>

        <div class="mt-4 grid gap-3">
          @foreach ($items as $item)
            @php($p = $item['product'])
            <div class="flex items-center gap-3">
              <div class="rounded-xl border border-zinc-200 bg-white overflow-hidden" style="width:52px;height:52px;min-width:52px;min-height:52px;">
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
              </div>

              <div class="min-w-0 flex-1">
                <div class="text-xs text-zinc-500">{{ $p->brand }}</div>
                <div class="text-sm font-medium truncate">{{ $p->name }}</div>
                <div class="text-xs text-zinc-600 mt-0.5">Qté: {{ $item['qty'] }}</div>
              </div>

              <div class="text-sm font-semibold">{{ number_format((float) $item['line_total'], 0, ',', ' ') }} FCFA</div>
            </div>
          @endforeach
        </div>

        <div class="mt-4 border-t border-zinc-200 pt-4 grid gap-2">
          <div class="flex items-center justify-between">
            <div class="text-sm text-zinc-600">Total produits</div>
            <div class="text-sm font-semibold" data-subtotal="{{ (int) $subtotal }}">{{ number_format((float) $subtotal, 0, ',', ' ') }} FCFA</div>
          </div>
          <div class="flex items-center justify-between" data-delivery-row style="display:none;">
            <div class="text-sm text-zinc-600">Coût livraison</div>
            <div class="text-sm font-semibold" data-delivery-cost>0 FCFA</div>
          </div>
          <div class="flex items-center justify-between">
            <div class="text-sm text-zinc-600">Montant à payer</div>
            <div class="text-lg font-semibold" data-amount-to-pay>{{ number_format((float) $subtotal, 0, ',', ' ') }} FCFA</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    (function () {
      var pickupRadio = document.querySelector('input[name="delivery_mode"][value="pickup"]');
      var deliveryRadio = document.querySelector('input[name="delivery_mode"][value="delivery"]');
      var communeWrap = document.querySelector('[data-commune-wrap]');
      var communeSelect = document.querySelector('select[name="commune_id"]');

      var subtotalEl = document.querySelector('[data-subtotal]');
      var deliveryRow = document.querySelector('[data-delivery-row]');
      var deliveryCostEl = deliveryRow ? deliveryRow.querySelector('[data-delivery-cost]') : null;
      var amountEl = document.querySelector('[data-amount-to-pay]');

      var formatMoney = function (value) {
        var num = Number(value);
        if (!Number.isFinite(num)) num = 0;
        return new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 0 }).format(num) + ' FCFA';
      };

      var getSubtotal = function () {
        var raw = subtotalEl ? subtotalEl.getAttribute('data-subtotal') : '0';
        var num = Number(raw);
        if (!Number.isFinite(num)) num = 0;
        return num;
      };

      var getDeliveryCost = function () {
        if (!communeSelect) return 0;
        var opt = communeSelect.options[communeSelect.selectedIndex];
        if (!opt) return 0;
        var raw = (opt.dataset && opt.dataset.communeCost) ? opt.dataset.communeCost : (opt.getAttribute('data-commune-cost') || '0');
        var num = Number(raw);
        if (!Number.isFinite(num)) num = 0;
        return num;
      };

      var updateUi = function () {
        var isDelivery = deliveryRadio && deliveryRadio.checked;
        if (communeWrap) communeWrap.style.display = isDelivery ? '' : 'none';
        if (deliveryRow) deliveryRow.style.display = isDelivery ? '' : 'none';

        var subtotal = getSubtotal();
        var deliveryCost = isDelivery ? getDeliveryCost() : 0;
        var amount = subtotal + deliveryCost;

        if (deliveryCostEl) deliveryCostEl.textContent = formatMoney(deliveryCost);
        if (amountEl) amountEl.textContent = formatMoney(amount);
      };

      if (pickupRadio) pickupRadio.addEventListener('change', updateUi);
      if (deliveryRadio) deliveryRadio.addEventListener('change', updateUi);
      if (communeSelect) {
        communeSelect.addEventListener('change', function () {
          updateUi();
          setTimeout(updateUi, 0);
        });
        communeSelect.addEventListener('input', function () {
          updateUi();
          setTimeout(updateUi, 0);
        });
      }

      updateUi();
    })();
  </script>
@endsection
