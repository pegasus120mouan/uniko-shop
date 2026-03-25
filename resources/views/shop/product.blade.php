@extends('layouts.shop')

@section('title', $product->name)

@section('content')
  @php
    $assetBase = rtrim((string) config('services.uniko.asset_url', ''), '/');
  @endphp
  <section class="max-w-6xl mx-auto px-4 pt-8">
    <a href="{{ route('shop.catalog') }}" class="text-sm text-zinc-600 hover:text-zinc-900">← Retour au catalogue</a>

    <div class="mt-4 grid lg:grid-cols-2 gap-6">
      <div class="rounded-3xl border border-zinc-200 bg-white p-6 md:p-8">
        <div class="grid sm:grid-cols-5 gap-4">
          <div class="sm:col-span-3 aspect-[4/3] rounded-2xl bg-zinc-50 border border-zinc-200 overflow-hidden">
            @if (!empty($product->image_path))
              <img
                src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($product->image_path, '/') }}"
                alt="{{ $product->name }}"
                class="h-full w-full object-cover"
                loading="lazy"
              />
            @else
              <div class="h-full w-full bg-gradient-to-br from-zinc-100 via-white to-zinc-200"></div>
            @endif
          </div>
          <div class="sm:col-span-2 grid grid-cols-2 sm:grid-cols-1 gap-3">
            <div class="aspect-[4/3] rounded-2xl bg-zinc-50 border border-zinc-200 overflow-hidden">
              @if (!empty($product->image_path))
                <img
                  src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($product->image_path, '/') }}"
                  alt="{{ $product->name }}"
                  class="h-full w-full object-cover"
                  loading="lazy"
                />
              @else
                <div class="h-full w-full bg-gradient-to-br from-zinc-100 via-white to-zinc-200"></div>
              @endif
            </div>
            <div class="aspect-[4/3] rounded-2xl bg-zinc-50 border border-zinc-200 overflow-hidden">
              @if (!empty($product->image_path))
                <img
                  src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($product->image_path, '/') }}"
                  alt="{{ $product->name }}"
                  class="h-full w-full object-cover"
                  loading="lazy"
                />
              @else
                <div class="h-full w-full bg-gradient-to-br from-zinc-100 via-white to-zinc-200"></div>
              @endif
            </div>
          </div>
        </div>

        <div class="flex items-start justify-between gap-3 mt-6">
          <div>
            <div class="text-[11px] text-zinc-500 uppercase tracking-wide">{{ $product->brand }}</div>
            <h1 class="mt-2 text-2xl md:text-3xl font-semibold leading-tight">{{ $product->name }}</h1>
          </div>
          <span class="shrink-0 inline-flex items-center rounded-full border border-zinc-200 bg-zinc-50 px-2.5 py-1.5 text-[11px] text-zinc-600">
            {{ $product->quantity > 0 ? 'En stock' : 'Sur commande' }}
          </span>
        </div>

        @if ($product->parfum && $product->parfum->prices->count() > 0)
          <div class="mt-4">
            <div class="text-sm text-zinc-500 mb-2">Sélectionnez un contenant :</div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="contenant-options">
              @foreach ($product->parfum->prices->sortBy('contenant.ml') as $price)
                <label class="contenant-option cursor-pointer">
                  <input type="radio" name="contenant_preview" value="{{ $price->id }}" data-prix="{{ $price->prix }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }} />
                  <div class="rounded-xl border-2 border-zinc-200 bg-zinc-50 p-3 text-center transition peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:border-zinc-300">
                    <div class="font-semibold text-sm">{{ $price->contenant->ml }} ml</div>
                    <div class="text-xs text-zinc-500 mt-0.5">{{ $price->contenant->type_contenant }}</div>
                    <div class="font-bold text-amber-600 mt-1">{{ number_format($price->prix, 0, ',', ' ') }} FCFA</div>
                  </div>
                </label>
              @endforeach
            </div>
            <div class="mt-3 text-2xl font-semibold" id="selected-price">
              {{ number_format($product->parfum->prices->sortBy('contenant.ml')->first()->prix, 0, ',', ' ') }} FCFA
            </div>
          </div>
        @else
          <div class="mt-4 text-3xl font-semibold">{{ number_format((float) $product->price, 0, ',', ' ') }} FCFA</div>
        @endif

        @if ($product->description)
          <p class="mt-5 text-zinc-600 leading-relaxed">{{ $product->description }}</p>
        @else
          <p class="mt-5 text-zinc-600 leading-relaxed">Parfum sélectionné par Uniko Perfume.</p>
        @endif

        <div class="mt-7 grid sm:grid-cols-2 gap-3 text-sm">
          <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4">
            <div class="text-zinc-500">Paiement</div>
            <div class="font-medium mt-1">Sur place / livraison</div>
          </div>
          <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4">
            <div class="text-zinc-500">Retrait</div>
            <div class="font-medium mt-1">Boutique</div>
          </div>
        </div>
      </div>

      <div class="lg:sticky lg:top-24 h-fit rounded-3xl border border-zinc-200 bg-white p-6 md:p-8 shadow-sm">
        <div class="font-semibold">Acheter</div>
        <div class="mt-2 text-sm text-zinc-600">Ajoute au panier puis valide ta commande.</div>

        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-6 grid gap-3" id="add-to-cart-form">
          @csrf
          @if ($product->parfum && $product->parfum->prices->count() > 0)
            <div>
              <label class="text-sm text-zinc-600">Contenant</label>
              <select name="parfum_price_id" id="contenant-select" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10" required>
                @foreach ($product->parfum->prices->sortBy('contenant.ml') as $price)
                  <option value="{{ $price->id }}" data-prix="{{ $price->prix }}">
                    {{ $price->contenant->ml }} ml - {{ $price->contenant->type_contenant }} ({{ number_format($price->prix, 0, ',', ' ') }} FCFA)
                  </option>
                @endforeach
              </select>
            </div>
          @endif
          <div>
            <label class="text-sm text-zinc-600">Quantité</label>
            <input type="number" min="1" max="99" name="qty" value="1" class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
          </div>
          <button class="w-full rounded-xl bg-zinc-900 px-4 py-3 text-white text-sm font-medium hover:bg-zinc-800" type="submit">Ajouter au panier</button>
          <a href="{{ route('cart.index') }}" class="w-full text-center rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-medium hover:bg-zinc-50">Voir le panier</a>
        </form>
      </div>
    </div>
  </section>
@endsection
