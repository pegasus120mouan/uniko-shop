<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Uniko Perfume')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">
    <meta name="theme-color" content="#08c">

    @if (file_exists(public_path('build/manifest.json')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
      <script src="https://cdn.tailwindcss.com"></script>
      <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                porto: { primary: '#08c', secondary: '#222529', accent: '#e13b3b', light: '#f4f4f4' }
            }
          }
        }
      </script>
    @endif

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap');
      :root { 
        --primary: #c3a265;
        --primary-dark: #a68b4b;
        --dark: #1a1a1a;
        --text: #666666;
        --light-bg: #f9f6f2;
      }
      body { font-family: 'Jost', sans-serif; color: #666; }
      h1, h2, h3, h4, .font-serif { font-family: 'Cormorant Garamond', serif; color: #1a1a1a; }
      .btn-primary { background: var(--primary); color: #fff; transition: all 0.3s; }
      .btn-primary:hover { background: var(--primary-dark); }
      .btn-outline { border: 1px solid var(--dark); color: var(--dark); background: transparent; transition: all 0.3s; }
      .btn-outline:hover { background: var(--dark); color: #fff; }
      .product-card { transition: all 0.4s ease; }
      .product-card:hover { box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
      .product-card:hover .product-overlay { opacity: 1; }
      .product-card .product-overlay { opacity: 0; transition: all 0.4s ease; }
      .product-card:hover img { transform: scale(1.05); }
      .product-card img { transition: transform 0.6s ease; }
      .mobile-menu { transform: translateX(-100%); transition: transform 0.3s ease; }
      .mobile-menu.active { transform: translateX(0); }
      .nav-link { position: relative; letter-spacing: 1px; }
      .nav-link::after { content: ''; position: absolute; bottom: -2px; left: 50%; width: 0; height: 1px; background: var(--primary); transition: all 0.3s; transform: translateX(-50%); }
      .nav-link:hover::after { width: 100%; }
      .section-title { font-size: 42px; font-weight: 400; letter-spacing: 2px; }
      .section-subtitle { font-size: 14px; letter-spacing: 3px; text-transform: uppercase; color: var(--primary); }
      @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
      .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; }
      .swiper-pagination-bullet-active { background: var(--primary) !important; }
    </style>
  </head>
  <body class="min-h-screen bg-white text-gray-800">
    
    <div class="bg-[#1a1a1a] text-white/80 text-xs py-2.5">
      <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
        <div class="hidden md:flex items-center gap-6">
          <a href="tel:+22500000000" class="flex items-center gap-2 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            +225 00 00 00 00
          </a>
          <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
            Abidjan, Côte d'Ivoire
          </span>
        </div>
        <div class="flex items-center gap-4 mx-auto md:mx-0">
          <span>Livraison gratuite dès 25 000 FCFA</span>
          <span class="hidden sm:inline">|</span>
          <span class="hidden sm:inline">Parfums 100% Authentiques</span>
        </div>
        <div class="hidden md:flex items-center gap-4">
          <a href="#" class="hover:text-[#c3a265] transition-colors">Mon Compte</a>
        </div>
      </div>
    </div>

    <header class="sticky top-0 z-50 bg-white border-b border-gray-100">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-24">
          <button id="mobileMenuBtn" class="lg:hidden p-2 text-[#1a1a1a]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
          </button>

          <a href="{{ route('shop.home') }}" class="flex flex-col items-center">
            <span class="text-3xl font-serif font-semibold tracking-[0.15em] text-[#1a1a1a]">UNIKO</span>
            <span class="text-[10px] tracking-[0.4em] text-[#c3a265] uppercase mt-0.5">Parfumerie</span>
          </a>

          <nav class="hidden lg:flex items-center gap-8">
            <a href="{{ route('shop.home') }}" class="nav-link text-[13px] font-medium tracking-[1px] text-[#1a1a1a] hover:text-[#c3a265] transition-colors uppercase">Accueil</a>
            <a href="{{ route('shop.catalog') }}" class="nav-link text-[13px] font-medium tracking-[1px] text-[#1a1a1a] hover:text-[#c3a265] transition-colors uppercase">Boutique</a>
            <a href="{{ route('shop.catalog') }}" class="nav-link text-[13px] font-medium tracking-[1px] text-[#1a1a1a] hover:text-[#c3a265] transition-colors uppercase">Femme</a>
            <a href="{{ route('shop.catalog') }}" class="nav-link text-[13px] font-medium tracking-[1px] text-[#1a1a1a] hover:text-[#c3a265] transition-colors uppercase">Homme</a>
            <a href="{{ route('shop.catalog') }}" class="nav-link text-[13px] font-medium tracking-[1px] text-[#c3a265] uppercase">Promotions</a>
            <a href="#" class="nav-link text-[13px] font-medium tracking-[1px] text-[#1a1a1a] hover:text-[#c3a265] transition-colors uppercase">Contact</a>
          </nav>

          <div class="flex items-center gap-5">
            <button class="hidden lg:flex items-center justify-center w-10 h-10 text-[#1a1a1a] hover:text-[#c3a265] transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>

            <a href="#" class="hidden lg:flex items-center justify-center w-10 h-10 text-[#1a1a1a] hover:text-[#c3a265] transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </a>

            <a href="#" class="hidden lg:flex items-center justify-center w-10 h-10 text-[#1a1a1a] hover:text-[#c3a265] transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            </a>

            @php($cartCount = array_sum((array) session('cart', [])))
            <a href="{{ route('cart.index') }}" class="relative flex items-center justify-center w-10 h-10 text-[#1a1a1a] hover:text-[#c3a265] transition-all">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
              </svg>
              @if ($cartCount > 0)
                <span class="absolute -top-1 -right-1 bg-[#c3a265] text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
              @endif
            </a>
          </div>
        </div>
      </div>
    </header>
    <div id="mobileMenu" class="mobile-menu fixed inset-y-0 left-0 w-80 bg-white shadow-2xl z-50 overflow-y-auto">
      <div class="p-4 border-b flex items-center justify-between bg-purple-800">
        <span class="font-semibold text-white">Menu</span>
        <button id="closeMobileMenu" class="p-2 text-white/80 hover:text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>
      <div class="p-4">
        <form method="GET" action="{{ route('shop.catalog') }}" class="mb-4">
          <div class="relative flex">
            <input name="q" placeholder="Rechercher..." class="w-full border border-gray-300 rounded-l-full pl-4 pr-4 py-2 text-sm focus:outline-none focus:border-purple-800" />
            <button type="submit" class="bg-purple-800 text-white px-4 rounded-r-full">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
          </div>
        </form>
      </div>
      <nav class="px-4">
        <a href="{{ route('shop.home') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Accueil</a>
        <a href="{{ route('shop.catalog') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Parfums</a>
        <a href="{{ route('shop.catalog') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Marques</a>
        <a href="{{ route('shop.catalog') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Soins</a>
        <a href="{{ route('shop.catalog') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Maquillage</a>
        <a href="{{ route('shop.catalog') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Cheveux</a>
        <a href="{{ route('shop.catalog') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Coffrets</a>
        <a href="{{ route('cart.index') }}" class="block py-3 border-b border-gray-100 font-medium text-gray-800 hover:text-purple-800">Mon Panier</a>
      </nav>
    </div>
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

    <main>
      @if (session('status'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
          <div class="rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-green-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('status') }}
          </div>
        </div>
      @endif
      @yield('content')
    </main>

    <footer class="bg-[#f9f6f2]">
      <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">
          <div class="lg:col-span-1">
            <div class="mb-6">
              <span class="text-2xl font-serif tracking-[0.15em] text-[#1a1a1a]">UNIKO</span>
              <span class="block text-[10px] tracking-[0.4em] text-[#c3a265] uppercase">Parfumerie</span>
            </div>
            <p class="text-gray-500 text-sm leading-relaxed mb-6">Votre parfumerie de luxe en ligne. Découvrez notre sélection exclusive de parfums authentiques.</p>
            <div class="flex gap-3">
              <a href="#" class="w-9 h-9 border border-gray-300 hover:border-[#c3a265] hover:bg-[#c3a265] flex items-center justify-center transition-all group">
                <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              </a>
              <a href="#" class="w-9 h-9 border border-gray-300 hover:border-[#c3a265] hover:bg-[#c3a265] flex items-center justify-center transition-all group">
                <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              </a>
              <a href="#" class="w-9 h-9 border border-gray-300 hover:border-green-500 hover:bg-green-500 flex items-center justify-center transition-all group">
                <svg class="w-4 h-4 text-gray-600 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              </a>
            </div>
          </div>
          <div>
            <h4 class="text-xs font-medium tracking-[2px] uppercase mb-6 text-[#1a1a1a]">Boutique</h4>
            <ul class="space-y-3 text-gray-500 text-sm">
              <li><a href="{{ route('shop.catalog') }}" class="hover:text-[#c3a265] transition-colors">Tous les parfums</a></li>
              <li><a href="{{ route('shop.catalog') }}" class="hover:text-[#c3a265] transition-colors">Nouveautés</a></li>
              <li><a href="{{ route('shop.catalog') }}" class="hover:text-[#c3a265] transition-colors">Promotions</a></li>
              <li><a href="{{ route('shop.catalog') }}" class="hover:text-[#c3a265] transition-colors">Coffrets cadeaux</a></li>
              <li><a href="{{ route('shop.catalog') }}" class="hover:text-[#c3a265] transition-colors">Marques</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-xs font-medium tracking-[2px] uppercase mb-6 text-[#1a1a1a]">Informations</h4>
            <ul class="space-y-3 text-gray-500 text-sm">
              <li><a href="#" class="hover:text-[#c3a265] transition-colors">À propos de nous</a></li>
              <li><a href="#" class="hover:text-[#c3a265] transition-colors">Livraison & Retours</a></li>
              <li><a href="#" class="hover:text-[#c3a265] transition-colors">Conditions générales</a></li>
              <li><a href="#" class="hover:text-[#c3a265] transition-colors">Politique de confidentialité</a></li>
              <li><a href="#" class="hover:text-[#c3a265] transition-colors">FAQ</a></li>
            </ul>
          </div>
          <div>
            <h4 class="text-xs font-medium tracking-[2px] uppercase mb-6 text-[#1a1a1a]">Contact</h4>
            <ul class="space-y-3 text-gray-500 text-sm">
              <li class="flex items-start gap-3">
                <svg class="w-4 h-4 text-[#c3a265] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Abidjan, Côte d'Ivoire</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-4 h-4 text-[#c3a265] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span>+225 00 00 00 00</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-4 h-4 text-[#c3a265] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>contact@unikoperfume.com</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-sm text-gray-500">
              © {{ date('Y') }} <span class="text-[#1a1a1a]">Uniko Perfume</span>. Tous droits réservés.
            </div>
            <div class="flex items-center gap-6 text-sm text-gray-500">
              <a href="#" class="hover:text-[#c3a265] transition-colors">Mentions légales</a>
              <a href="#" class="hover:text-[#c3a265] transition-colors">CGV</a>
              <a href="https://obaxion.com/" target="_blank" rel="noopener noreferrer" class="hover:text-[#c3a265] transition-colors flex items-center gap-1">
                <span>Créé par</span>
                <span class="text-[#c3a265] font-medium">Obaxion</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <script>
      (function() {
        var mobileMenuBtn = document.getElementById('mobileMenuBtn');
        var closeMobileMenu = document.getElementById('closeMobileMenu');
        var mobileMenu = document.getElementById('mobileMenu');
        var mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        function openMenu() { mobileMenu.classList.add('active'); mobileMenuOverlay.classList.remove('hidden'); document.body.style.overflow = 'hidden'; }
        function closeMenu() { mobileMenu.classList.remove('active'); mobileMenuOverlay.classList.add('hidden'); document.body.style.overflow = ''; }
        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMenu);
        if (closeMobileMenu) closeMobileMenu.addEventListener('click', closeMenu);
        if (mobileMenuOverlay) mobileMenuOverlay.addEventListener('click', closeMenu);
      })();
    </script>
  </body>
</html>
