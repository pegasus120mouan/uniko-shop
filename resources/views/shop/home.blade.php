@extends('layouts.shop')

@section('title', 'Uniko Perfume - Parfumerie de Luxe')

@section('content')
  @php
    $assetBase = rtrim((string) config('services.uniko.asset_url', ''), '/');
  @endphp
  
  <section class="relative min-h-[85vh] flex items-center" style="background: linear-gradient(to right, #f9f6f2 50%, #efe9e0 50%);">
    <div class="max-w-7xl mx-auto px-4 w-full">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8 py-20">
          <p class="section-subtitle">Nouvelle Collection 2024</p>
          <h1 class="text-5xl lg:text-6xl font-serif font-normal leading-tight text-[#1a1a1a]">
            L'Essence de<br/>
            <span class="italic">l'Élégance</span>
          </h1>
          <p class="text-base text-gray-500 leading-relaxed max-w-md">Découvrez notre collection exclusive de parfums authentiques. Des fragrances d'exception pour révéler votre personnalité unique.</p>
          <div class="flex flex-wrap gap-4 pt-4">
            <a href="{{ route('shop.catalog') }}" class="btn-primary inline-flex items-center justify-center px-10 py-4 text-sm tracking-[2px] uppercase">
              Découvrir
            </a>
            <a href="{{ route('shop.catalog') }}" class="btn-outline inline-flex items-center justify-center px-10 py-4 text-sm tracking-[2px] uppercase">
              Voir Tout
            </a>
          </div>
        </div>
        <div class="relative py-10">
          <div class="relative aspect-[4/5] overflow-hidden">
            @if($featured->first() && !empty($featured->first()->image_path))
              <img src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($featured->first()->image_path, '/') }}" alt="Hero" class="w-full h-full object-cover" />
            @else
              <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#efe9e0] to-[#e5ddd3]">
                <svg class="w-32 h-32 text-[#c3a265]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
              </div>
            @endif
          </div>
          <div class="absolute -bottom-6 -left-6 bg-white p-6 shadow-xl max-w-xs">
            <p class="text-[#c3a265] text-xs tracking-[2px] uppercase mb-2">Best Seller</p>
            <p class="font-serif text-xl text-[#1a1a1a]">Parfums Premium</p>
            <p class="text-sm text-gray-500 mt-2">À partir de 15 000 FCFA</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <p class="section-subtitle mb-4">Notre Sélection</p>
        <h2 class="section-title font-serif">Meilleures Ventes</h2>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($featured->take(8) as $p)
          <div class="group product-card bg-[#f9f6f2]">
            <a href="{{ route('shop.product', $p) }}" class="block">
              <div class="relative aspect-square overflow-hidden">
                @if (!empty($p->image_path))
                  <img src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($p->image_path, '/') }}" alt="{{ $p->name }}" class="w-full h-full object-cover" loading="lazy" />
                @else
                  <div class="w-full h-full flex items-center justify-center bg-[#efe9e0]">
                    <svg class="w-16 h-16 text-[#c3a265]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                  </div>
                @endif
                <div class="product-overlay absolute inset-0 bg-black/20 flex items-center justify-center gap-3">
                  <button class="w-10 h-10 bg-white text-[#1a1a1a] rounded-full flex items-center justify-center hover:bg-[#c3a265] hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                  </button>
                  <button class="w-10 h-10 bg-[#c3a265] text-white rounded-full flex items-center justify-center hover:bg-[#1a1a1a] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                  </button>
                  <button class="w-10 h-10 bg-white text-[#1a1a1a] rounded-full flex items-center justify-center hover:bg-[#c3a265] hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                  </button>
                </div>
              </div>
              <div class="p-5 text-center">
                <p class="text-xs text-[#c3a265] uppercase tracking-[2px] mb-2">{{ $p->brand }}</p>
                <h3 class="font-serif text-lg text-[#1a1a1a] mb-2 group-hover:text-[#c3a265] transition-colors">{{ $p->name }}</h3>
                <p class="text-[#1a1a1a] font-medium">{{ number_format((float) $p->price, 0, ',', ' ') }} FCFA</p>
              </div>
            </a>
          </div>
        @empty
          <div class="col-span-4 text-center py-16">
            <p class="text-gray-500">Aucun produit disponible pour le moment.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <section class="py-20 bg-[#f9f6f2]">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid md:grid-cols-3 gap-6">
        <div class="relative overflow-hidden group cursor-pointer bg-[#efe9e0]" style="min-height: 400px;">
          <div class="absolute inset-0 p-8 flex flex-col justify-end">
            <p class="text-[#c3a265] text-xs tracking-[2px] uppercase mb-2">Pour Elle</p>
            <h3 class="text-3xl font-serif text-[#1a1a1a] mb-4">Parfums Femme</h3>
            <a href="{{ route('shop.catalog') }}" class="inline-flex items-center text-[#1a1a1a] text-sm tracking-[1px] uppercase hover:text-[#c3a265] transition-colors">
              Découvrir
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
          </div>
        </div>
        <div class="relative overflow-hidden group cursor-pointer bg-[#1a1a1a]" style="min-height: 400px;">
          <div class="absolute inset-0 p-8 flex flex-col justify-end">
            <p class="text-[#c3a265] text-xs tracking-[2px] uppercase mb-2">Pour Lui</p>
            <h3 class="text-3xl font-serif text-white mb-4">Parfums Homme</h3>
            <a href="{{ route('shop.catalog') }}" class="inline-flex items-center text-white text-sm tracking-[1px] uppercase hover:text-[#c3a265] transition-colors">
              Découvrir
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
          </div>
        </div>
        <div class="relative overflow-hidden group cursor-pointer" style="min-height: 400px; background: linear-gradient(135deg, #c3a265 0%, #d4b87a 100%);">
          <div class="absolute inset-0 p-8 flex flex-col justify-end">
            <p class="text-white/80 text-xs tracking-[2px] uppercase mb-2">Offres Spéciales</p>
            <h3 class="text-3xl font-serif text-white mb-4">Promotions</h3>
            <a href="{{ route('shop.catalog') }}" class="inline-flex items-center text-white text-sm tracking-[1px] uppercase hover:text-[#1a1a1a] transition-colors">
              Voir les offres
              <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center mb-16">
        <p class="section-subtitle mb-4">Fraîchement Arrivés</p>
        <h2 class="section-title font-serif">Nouveautés</h2>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($categoryBlocks as $block)
          @foreach ($block['products']->take(4) as $p)
            <div class="group product-card bg-[#f9f6f2]">
              <a href="{{ route('shop.product', $p) }}" class="block">
                <div class="relative aspect-square overflow-hidden">
                  @if (!empty($p->image_path))
                    <img src="{{ ($assetBase !== '' ? $assetBase : '') . '/storage/' . ltrim($p->image_path, '/') }}" alt="{{ $p->name }}" class="w-full h-full object-cover" loading="lazy" />
                  @else
                    <div class="w-full h-full flex items-center justify-center bg-[#efe9e0]">
                      <svg class="w-16 h-16 text-[#c3a265]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                  @endif
                  <div class="absolute top-4 left-4">
                    <span class="bg-[#c3a265] text-white text-[10px] tracking-[1px] uppercase px-3 py-1">Nouveau</span>
                  </div>
                  <div class="product-overlay absolute inset-0 bg-black/20 flex items-center justify-center gap-3">
                    <button class="w-10 h-10 bg-white text-[#1a1a1a] rounded-full flex items-center justify-center hover:bg-[#c3a265] hover:text-white transition-all">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <button class="w-10 h-10 bg-[#c3a265] text-white rounded-full flex items-center justify-center hover:bg-[#1a1a1a] transition-all">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </button>
                  </div>
                </div>
                <div class="p-5 text-center">
                  <p class="text-xs text-[#c3a265] uppercase tracking-[2px] mb-2">{{ $p->brand }}</p>
                  <h3 class="font-serif text-lg text-[#1a1a1a] mb-2 group-hover:text-[#c3a265] transition-colors">{{ $p->name }}</h3>
                  <p class="text-[#1a1a1a] font-medium">{{ number_format((float) $p->price, 0, ',', ' ') }} FCFA</p>
                </div>
              </a>
            </div>
          @endforeach
        @endforeach
      </div>
    </div>
  </section>

  <section class="py-20" style="background: linear-gradient(to right, #1a1a1a 50%, #c3a265 50%);">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <div class="text-center md:text-left py-10">
          <p class="text-[#c3a265] text-xs tracking-[3px] uppercase mb-4">Newsletter</p>
          <h2 class="text-4xl font-serif text-white mb-4">Restez Informé</h2>
          <p class="text-white/70 mb-8">Inscrivez-vous pour recevoir nos offres exclusives</p>
          <form class="flex flex-col sm:flex-row gap-3">
            <input type="email" placeholder="Votre email" class="flex-1 bg-white/10 border border-white/30 text-white placeholder-white/50 px-5 py-3 focus:outline-none focus:border-[#c3a265]" />
            <button type="submit" class="bg-[#c3a265] text-white px-8 py-3 text-sm tracking-[2px] uppercase hover:bg-white hover:text-[#1a1a1a] transition-all">
              S'inscrire
            </button>
          </form>
        </div>
        <div class="text-center py-10">
          <p class="text-white/80 text-xs tracking-[3px] uppercase mb-4">Suivez-nous</p>
          <h2 class="text-4xl font-serif text-white mb-6">@unikoperfume</h2>
          <div class="flex justify-center gap-4">
            <a href="#" class="w-12 h-12 border border-white/30 flex items-center justify-center text-white hover:bg-white hover:text-[#1a1a1a] transition-all">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="w-12 h-12 border border-white/30 flex items-center justify-center text-white hover:bg-white hover:text-[#1a1a1a] transition-all">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="#" class="w-12 h-12 border border-white/30 flex items-center justify-center text-white hover:bg-white hover:text-[#1a1a1a] transition-all">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        <div>
          <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center">
            <svg class="w-10 h-10 text-[#c3a265]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
          </div>
          <h4 class="font-serif text-lg text-[#1a1a1a] mb-1">Livraison Gratuite</h4>
          <p class="text-sm text-gray-500">Dès 25 000 FCFA</p>
        </div>
        <div>
          <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center">
            <svg class="w-10 h-10 text-[#c3a265]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
          </div>
          <h4 class="font-serif text-lg text-[#1a1a1a] mb-1">100% Authentique</h4>
          <p class="text-sm text-gray-500">Garantie originale</p>
        </div>
        <div>
          <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center">
            <svg class="w-10 h-10 text-[#c3a265]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
          </div>
          <h4 class="font-serif text-lg text-[#1a1a1a] mb-1">Paiement Sécurisé</h4>
          <p class="text-sm text-gray-500">Transactions protégées</p>
        </div>
        <div>
          <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center">
            <svg class="w-10 h-10 text-[#c3a265]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          </div>
          <h4 class="font-serif text-lg text-[#1a1a1a] mb-1">Support 7j/7</h4>
          <p class="text-sm text-gray-500">À votre écoute</p>
        </div>
      </div>
    </div>
  </section>
@endsection
