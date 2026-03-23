@extends('layouts.shop')

@section('title', 'Uniko Perfume')

@section('content')
  @php
    $assetBase = rtrim((string) config('services.uniko.asset_url', ''), '/');
  @endphp
  <section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-white via-white to-zinc-50"></div>
    <div class="absolute -top-24 left-1/2 -translate-x-1/2 h-72 w-[900px] rounded-full bg-zinc-900/5 blur-3xl"></div>

    <div class="relative max-w-6xl mx-auto px-4 pt-12 pb-10">
      <div class="grid lg:grid-cols-2 gap-10 items-center">
        <div>
          <div class="inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1 text-xs text-zinc-600">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            <span>Commande rapide · Retrait boutique</span>
          </div>
          <h1 class="mt-4 text-4xl md:text-5xl font-semibold tracking-tight">Uniko Perfume</h1>
          <p class="mt-4 text-zinc-600 text-base md:text-lg">Parfums authentiques pour tous les styles. Ajoute au panier et commande en quelques clics.</p>
          <div class="mt-7 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('shop.catalog') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-6 py-3 text-white text-sm font-medium hover:bg-zinc-800">Explorer le catalogue</a>
            <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center rounded-xl border border-zinc-200 bg-white px-6 py-3 text-sm font-medium hover:bg-zinc-50">Voir le panier</a>
          </div>

          <div class="mt-8 grid sm:grid-cols-3 gap-3 text-sm">
            <div class="rounded-xl border border-zinc-200 bg-white p-4">
              <div class="font-medium">Qualité</div>
              <div class="text-zinc-600 mt-1">Sélection rigoureuse</div>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4">
              <div class="font-medium">Paiement</div>
              <div class="text-zinc-600 mt-1">Sur place / livraison</div>
            </div>
            <div class="rounded-xl border border-zinc-200 bg-white p-4">
              <div class="font-medium">Retrait</div>
              <div class="text-zinc-600 mt-1">Boutique</div>
            </div>
          </div>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
          <div class="flex items-center justify-between">
            <div>
              <div class="text-sm font-medium">Nouveautés</div>
              <div class="text-xs text-zinc-500 mt-0.5">Produits récemment ajoutés</div>
            </div>
            <a href="{{ route('shop.catalog') }}" class="text-sm text-zinc-600 hover:text-zinc-900">Tout voir</a>
          </div>

          <div class="mt-4 grid grid-cols-2 gap-3">
            @forelse ($featured as $p)
              <a href="{{ route('shop.product', $p) }}" class="group rounded-2xl border border-zinc-200 bg-zinc-50 p-4 hover:bg-white hover:shadow-sm transition">
                <div class="aspect-[4/3] rounded-xl bg-white border border-zinc-200 overflow-hidden">
                  @if (!empty($p->image_path))
                    <img
                      src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($p->image_path, '/') }}"
                      alt="{{ $p->name }}"
                      class="h-full w-full object-cover"
                      loading="lazy"
                    />
                  @else
                    <div class="h-full w-full bg-gradient-to-br from-zinc-100 via-white to-zinc-200"></div>
                  @endif
                </div>
                <div class="text-[11px] text-zinc-500 uppercase tracking-wide mt-3">{{ $p->brand }}</div>
                <div class="mt-1 font-medium leading-tight group-hover:underline">{{ $p->name }}</div>
                <div class="mt-3 text-sm font-semibold">{{ number_format((float) $p->price, 0, ',', ' ') }} FCFA</div>
              </a>
            @empty
              <div class="col-span-2 text-sm text-zinc-500">Aucun produit pour le moment.</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-4 pt-8">
    <div class="rounded-3xl border border-zinc-200 bg-white p-5 md:p-6">
      <div class="flex items-end justify-between gap-3">
        <div>
          <div class="text-sm font-semibold">Catégories</div>
          <div class="text-xs text-zinc-500 mt-0.5">Choisis ta famille de parfums</div>
        </div>
        <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('shop.catalog') }}">Voir tout</a>
      </div>

      <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach ($categories->take(6) as $cat)
          <a href="{{ route('shop.catalog', ['category_id' => $cat->id]) }}" class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 hover:bg-white hover:shadow-sm transition">
            <div class="text-xs text-zinc-500">Parfum</div>
            <div class="mt-1 font-medium leading-tight">{{ $cat->name }}</div>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  @foreach ($categoryBlocks as $block)
    <section class="max-w-6xl mx-auto px-4 pt-8">
      <div class="flex items-end justify-between gap-3">
        <div>
          <div class="text-xs text-zinc-500">Sélection</div>
          <h2 class="text-xl font-semibold">{{ $block['category']->name }}</h2>
        </div>
        <a class="text-sm text-zinc-600 hover:text-zinc-900" href="{{ route('shop.catalog', ['category_id' => $block['category']->id]) }}">Voir tout</a>
      </div>

      <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ($block['products'] as $p)
          <a href="{{ route('shop.product', $p) }}" class="group rounded-3xl border border-zinc-200 bg-white p-4 hover:shadow-sm transition">
            <div class="aspect-[4/3] rounded-2xl bg-zinc-50 border border-zinc-200 overflow-hidden">
              @if (!empty($p->image_path))
                <img
                  src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($p->image_path, '/') }}"
                  alt="{{ $p->name }}"
                  class="h-full w-full object-cover"
                  loading="lazy"
                />
              @else
                <div class="h-full w-full bg-gradient-to-br from-zinc-100 via-white to-zinc-200"></div>
              @endif
            </div>
            <div class="text-[11px] text-zinc-500 uppercase tracking-wide mt-3">{{ $p->brand }}</div>
            <div class="mt-1 font-medium group-hover:underline leading-snug">{{ $p->name }}</div>
            <div class="mt-3 flex items-center justify-between">
              <div class="text-sm font-semibold">{{ number_format((float) $p->price, 0, ',', ' ') }} FCFA</div>
              <span class="text-[11px] text-zinc-500">détails</span>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endforeach

  <section class="max-w-6xl mx-auto px-4 pt-4">
    <div class="rounded-3xl border border-zinc-200 bg-white p-6 md:p-8">
      <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
          <h2 class="text-xl font-semibold">Prêt à commander ?</h2>
          <p class="text-zinc-600 mt-1">Parcours le catalogue et ajoute tes parfums préférés au panier.</p>
        </div>
        <a href="{{ route('shop.catalog') }}" class="inline-flex items-center justify-center rounded-xl bg-zinc-900 px-6 py-3 text-white text-sm font-medium hover:bg-zinc-800">Aller au catalogue</a>
      </div>
    </div>
  </section>
@endsection
