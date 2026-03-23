<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Uniko Perfume')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

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
          <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-zinc-900 text-white text-sm">U</span>
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

        @php($cartCount = array_sum((array) session('cart', [])))
        <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-4 py-2 text-sm hover:bg-zinc-50">
          <span>Panier</span>
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
          <div>Propulsé par Laravel</div>
        </div>
      </div>
    </footer>
  </body>
</html>
