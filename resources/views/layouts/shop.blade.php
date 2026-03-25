<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Uniko Perfume')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">
    <meta name="theme-color" content="#ffffff">

    <style>
      :root { color-scheme: light; }
      body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; }
    </style>

    @if (file_exists(public_path('build/manifest.json')))
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
      <script src="https://cdn.tailwindcss.com"></script>
    @endif
  </head>
  <body class="min-h-screen bg-zinc-50 text-zinc-900">
    <div class="bg-zinc-900 text-white">
      <div class="max-w-6xl mx-auto px-4 py-2 text-xs flex items-center justify-between gap-3">
        <div class="hidden sm:block">Parfumerie en ligne · Paiement sur place/livraison · Retrait boutique</div>
        <div class="sm:hidden">Uniko Perfume</div>
        <div class="text-white/80">Service client: 7j/7</div>
      </div>
    </div>

    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-zinc-200">
      <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-3">
        <a href="{{ route('shop.home') }}" class="flex items-center gap-2 font-semibold tracking-tight text-lg">
          <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-zinc-900 text-white text-sm overflow-hidden">
            <img src="{{ asset('img/logo/logo.jpeg') }}" alt="Uniko Perfume" class="h-full w-full object-cover" />
          </span>
          <span>Uniko Perfume</span>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm text-zinc-700 ml-6">
          <a class="hover:text-zinc-900" href="{{ route('shop.catalog') }}">Parfum</a>
          <a class="hover:text-zinc-900" href="{{ route('shop.catalog') }}">Nouveautés</a>
        </nav>

        <div class="flex-1"></div>

        <form class="hidden lg:block" method="GET" action="{{ route('shop.catalog') }}">
          <div class="relative">
            <input name="q" value="{{ (string) request('q', '') }}" placeholder="Rechercher un parfum..." class="w-80 rounded-full border border-zinc-200 bg-white px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900/10" />
          </div>
        </form>

        @php
          $cartCount = 0;
          foreach ((array) session('cart', []) as $item) {
            $cartCount += is_array($item) ? (int) ($item['qty'] ?? 0) : (int) $item;
          }
        @endphp
        <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-4 py-2 text-sm hover:bg-zinc-50" aria-label="Panier">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-zinc-800">
            <path d="M6 6h15l-1.5 9h-13z" />
            <path d="M6 6l-2-2H2" />
            <circle cx="9" cy="20" r="1" />
            <circle cx="18" cy="20" r="1" />
          </svg>
          @if ($cartCount > 0)
            <span class="inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-zinc-900 px-1.5 text-xs font-medium text-white">{{ $cartCount }}</span>
          @endif
        </a>
      </div>
    </header>

    <main>
      @if (session('status'))
        <div class="max-w-6xl mx-auto px-4 pt-4">
          <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-900 text-sm">{{ session('status') }}</div>
        </div>
      @endif

      @yield('content')
    </main>

    <footer class="border-t border-zinc-200 mt-14 bg-white">
      <div class="max-w-6xl mx-auto px-4 py-10 text-sm text-zinc-600">
        <div class="grid md:grid-cols-4 gap-8">
          <div class="md:col-span-2">
            <div class="font-semibold text-zinc-900">Uniko Perfume</div>
            <div class="mt-2 text-zinc-600">Parfums authentiques. Commande simple, retrait boutique.</div>
          </div>
          <div>
            <div class="font-medium text-zinc-900">Boutique</div>
            <div class="mt-2 grid gap-1">
              <a class="hover:text-zinc-900" href="{{ route('shop.catalog') }}">Catalogue</a>
              <a class="hover:text-zinc-900" href="{{ route('cart.index') }}">Panier</a>
            </div>
          </div>
          <div>
            <div class="font-medium text-zinc-900">Infos</div>
            <div class="mt-2 grid gap-1">
              <div>Paiement: sur place / livraison</div>
              <div>Retrait: boutique</div>
            </div>
          </div>
        </div>
        <div class="mt-8 flex flex-col md:flex-row md:items-center md:justify-between gap-2 text-xs text-zinc-500">
          <div>© {{ date('Y') }} Uniko Perfume. Tous droits réservés.</div>
          <div>
            <a href="https://obaxion.com/" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-900">by obaxion</a>
            <span>© {{ date('Y') }}</span>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>
