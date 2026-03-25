@extends('layouts.shop')

@section('title', 'Catalogue')

@section('content')
  @php
    $assetBase = rtrim((string) config('services.uniko.asset_url', ''), '/');
  @endphp
  <section class="max-w-6xl mx-auto px-4 pt-8">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-semibold">Catalogue</h1>
        <p class="text-zinc-600 text-sm mt-1">Trouve ton parfum et ajoute-le au panier.</p>
      </div>
    </div>

    <!-- Tabs for parfum type -->
    <div class="mt-6 flex gap-2 border-b border-zinc-200">
      <a href="{{ route('shop.catalog', array_filter(['category_id' => $categoryId, 'q' => $q])) }}"
         class="px-4 py-2.5 text-sm font-medium border-b-2 transition {{ !isset($parfumType) ? 'border-amber-500 text-amber-600' : 'border-transparent text-zinc-500 hover:text-zinc-700' }}">
        Tous
      </a>
      <a href="{{ route('shop.catalog', array_filter(['type' => 'classics', 'category_id' => $categoryId, 'q' => $q])) }}"
         class="px-4 py-2.5 text-sm font-medium border-b-2 transition {{ ($parfumType ?? '') === 'classics' ? 'border-amber-500 text-amber-600' : 'border-transparent text-zinc-500 hover:text-zinc-700' }}">
        Classics
      </a>
      <a href="{{ route('shop.catalog', array_filter(['type' => 'luxe', 'category_id' => $categoryId, 'q' => $q])) }}"
         class="px-4 py-2.5 text-sm font-medium border-b-2 transition {{ ($parfumType ?? '') === 'luxe' ? 'border-amber-500 text-amber-600' : 'border-transparent text-zinc-500 hover:text-zinc-700' }}">
        Luxe
      </a>
    </div>

    <div class="mt-6 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <form method="GET" action="{{ route('shop.catalog') }}" class="w-full md:w-auto">
        @if ($parfumType)
          <input type="hidden" name="type" value="{{ $parfumType }}" />
        @endif
        <div class="grid sm:grid-cols-3 gap-2">
          <select name="category_id" class="w-full rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10">
            <option value="">Toutes catégories</option>
            @foreach ($categories as $cat)
              <option value="{{ $cat->id }}" @selected((string) $categoryId === (string) $cat->id)>{{ $cat->name }}</option>
            @endforeach
          </select>
          <input name="q" value="{{ $q }}" class="w-full sm:col-span-2 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10" placeholder="Rechercher (nom, marque)..." />
          <button class="sm:col-span-3 rounded-xl bg-zinc-900 px-4 py-2.5 text-white text-sm font-medium hover:bg-zinc-800" type="submit">Filtrer</button>
        </div>
      </form>
    </div>

    <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
      @forelse ($products as $p)
        <div class="group rounded-3xl border border-zinc-200 bg-white p-4 hover:shadow-sm transition">
          <a href="{{ route('shop.product', $p) }}" class="block aspect-[4/3] rounded-2xl bg-zinc-50 border border-zinc-200 overflow-hidden">
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
          </a>
          <div class="flex items-start justify-between gap-3 mt-4">
            <div class="min-w-0">
              <div class="text-[11px] text-zinc-500 uppercase tracking-wide">{{ $p->brand }}</div>
              <a href="{{ route('shop.product', $p) }}" class="mt-1 block font-medium hover:underline leading-snug truncate">{{ $p->name }}</a>
            </div>
            <span class="shrink-0 inline-flex items-center rounded-full border border-zinc-200 bg-zinc-50 px-2 py-1 text-[11px] text-zinc-600">
              {{ $p->quantity > 0 ? 'En stock' : 'Sur commande' }}
            </span>
          </div>

          <div class="mt-4 flex items-center justify-between">
            <div class="text-base font-semibold">
              @if ($p->parfum && $p->parfum->prices->count() > 0)
                {{ $p->parfum->getPriceRange() }}
              @else
                {{ number_format((float) $p->price, 0, ',', ' ') }} FCFA
              @endif
            </div>
            <a href="{{ route('shop.product', $p) }}" class="rounded-xl bg-zinc-900 px-3.5 py-2 text-white text-sm font-medium hover:bg-zinc-800">Voir</a>
          </div>
        </div>
      @empty
        <div class="text-sm text-zinc-600">Aucun produit.</div>
      @endforelse
    </div>

    <div class="mt-10 rounded-2xl bg-white border border-zinc-200 p-4">
      {{ $products->links() }}
    </div>
  </section>
@endsection
