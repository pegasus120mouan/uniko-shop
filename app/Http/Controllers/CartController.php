<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = (array) $request->session()->get('cart', []);
        $productIds = array_keys($cart);

        $products = Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $items = [];
        $subtotal = 0.0;

        foreach ($cart as $productId => $qty) {
            $product = $products->get((int) $productId);

            if (!$product) {
                continue;
            }

            $qty = max(1, (int) $qty);
            $lineTotal = (float) $product->price * $qty;
            $subtotal += $lineTotal;

            $items[] = [
                'product' => $product,
                'qty' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        return view('cart.index', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $qty = (int) $request->input('qty', 1);
        $qty = max(1, min(99, $qty));

        $cart = (array) $request->session()->get('cart', []);
        $id = (string) $product->id;

        $cart[$id] = (int) ($cart[$id] ?? 0) + $qty;

        $request->session()->put('cart', $cart);

        return redirect()
            ->back()
            ->with('status', 'Ajouté au panier.');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['nullable', 'integer', 'min:0', 'max:99'],
        ]);

        $items = (array) ($validated['items'] ?? []);

        $cart = [];

        foreach ($items as $productId => $qty) {
            $qty = (int) $qty;
            if ($qty > 0) {
                $cart[(string) $productId] = $qty;
            }
        }

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Panier mis à jour.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = (array) $request->session()->get('cart', []);
        unset($cart[(string) $product->id]);
        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Article supprimé du panier.');
    }
}
