<?php

namespace App\Http\Controllers;

use App\Models\ParfumPrice;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = (array) $request->session()->get('cart', []);

        $items = [];
        $subtotal = 0.0;

        foreach ($cart as $cartKey => $cartItem) {
            // Handle both old format (productId => qty) and new format (key => {product_id, parfum_price_id, qty})
            if (is_array($cartItem)) {
                $productId = $cartItem['product_id'] ?? null;
                $parfumPriceId = $cartItem['parfum_price_id'] ?? null;
                $qty = max(1, (int) ($cartItem['qty'] ?? 1));
            } else {
                // Old format compatibility
                $productId = (int) $cartKey;
                $parfumPriceId = null;
                $qty = max(1, (int) $cartItem);
            }

            $product = Product::with('parfum')->find($productId);
            if (!$product) {
                continue;
            }

            $parfumPrice = null;
            $price = (float) $product->price;

            if ($parfumPriceId) {
                $parfumPrice = ParfumPrice::with('contenant')->find($parfumPriceId);
                if ($parfumPrice) {
                    $price = (float) $parfumPrice->prix;
                }
            }

            $lineTotal = $price * $qty;
            $subtotal += $lineTotal;

            $items[] = [
                'cart_key' => $cartKey,
                'product' => $product,
                'parfum_price' => $parfumPrice,
                'qty' => $qty,
                'price' => $price,
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

        $parfumPriceId = $request->input('parfum_price_id');

        $cart = (array) $request->session()->get('cart', []);

        // Create unique cart key based on product and parfum_price
        $cartKey = $product->id . '_' . ($parfumPriceId ?? '0');

        if (isset($cart[$cartKey]) && is_array($cart[$cartKey])) {
            $cart[$cartKey]['qty'] = (int) ($cart[$cartKey]['qty'] ?? 0) + $qty;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'parfum_price_id' => $parfumPriceId ? (int) $parfumPriceId : null,
                'qty' => $qty,
            ];
        }

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
        $cart = (array) $request->session()->get('cart', []);

        foreach ($items as $cartKey => $qty) {
            $qty = (int) $qty;
            if ($qty > 0 && isset($cart[$cartKey])) {
                if (is_array($cart[$cartKey])) {
                    $cart[$cartKey]['qty'] = $qty;
                } else {
                    $cart[$cartKey] = $qty;
                }
            } else {
                unset($cart[$cartKey]);
            }
        }

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Panier mis à jour.');
    }

    public function remove(Request $request, string $cartKey): RedirectResponse
    {
        $cart = (array) $request->session()->get('cart', []);
        unset($cart[$cartKey]);
        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Article supprimé du panier.');
    }
}
