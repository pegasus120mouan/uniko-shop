<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
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

        if (count($items) === 0) {
            return view('checkout.index', [
                'items' => [],
                'subtotal' => 0.0,
                'communes' => [],
            ]);
        }

        $communes = Commune::query()
            ->orderBy('nom')
            ->get();

        return view('checkout.index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'communes' => $communes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = (array) $request->session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()
                ->route('cart.index')
                ->with('status', 'Ton panier est vide.');
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'delivery_mode' => ['required', 'in:pickup,delivery'],
            'commune_id' => ['nullable', 'integer', 'exists:communes,id'],
            'address' => ['nullable', 'string', 'max:500'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['delivery_mode'] === 'delivery' && empty($validated['address'])) {
            return back()
                ->withInput()
                ->withErrors(['address' => "L'adresse est obligatoire pour la livraison."]); 
        }

        if ($validated['delivery_mode'] === 'delivery' && empty($validated['commune_id'])) {
            return back()
                ->withInput()
                ->withErrors(['commune_id' => 'La commune est obligatoire pour la livraison.']);
        }

        $cart = (array) $request->session()->get('cart', []);
        $productIds = array_keys($cart);

        $products = Product::query()
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $subtotal = 0;
        $resolvedItems = [];
        foreach ($cart as $productId => $qty) {
            $product = $products->get((int) $productId);
            if (!$product) {
                continue;
            }

            $qty = max(1, (int) $qty);
            $unitPrice = (int) $product->price;
            $lineTotal = $unitPrice * $qty;
            $subtotal += $lineTotal;

            $resolvedItems[] = [
                'product' => $product,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
            ];
        }

        if (count($resolvedItems) === 0) {
            return redirect()
                ->route('cart.index')
                ->with('status', 'Ton panier est vide.');
        }

        $deliveryCost = 0;
        $communeName = null;

        if ($validated['delivery_mode'] === 'delivery') {
            $commune = Commune::query()->find((int) $validated['commune_id']);
            if (!$commune) {
                return back()
                    ->withInput()
                    ->withErrors(['commune_id' => 'Commune invalide.']);
            }

            $deliveryCost = (int) $commune->cout_livraison;
            $communeName = (string) $commune->nom;
        }

        $amountToPay = $subtotal + $deliveryCost;

        $order = DB::transaction(function () use ($validated, $subtotal, $deliveryCost, $amountToPay, $communeName, $resolvedItems) {
            $orderNumber = $this->generateOrderNumber();

            $order = Order::create([
                'order_number' => $orderNumber,
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'delivery_mode' => $validated['delivery_mode'],
                'commune_id' => $validated['commune_id'] ?? null,
                'commune_nom' => $communeName,
                'address' => $validated['address'] ?? null,
                'note' => $validated['note'] ?? null,
                'subtotal' => $subtotal,
                'cout_livraison' => $deliveryCost,
                'montant_a_payer' => $amountToPay,
                'status' => 'pending_confirmation',
            ]);

            foreach ($resolvedItems as $it) {
                /** @var \App\Models\Product $product */
                $product = $it['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => (string) $product->name,
                    'product_brand' => (string) ($product->brand ?? ''),
                    'unit_price' => (int) $it['unit_price'],
                    'quantity' => (int) $it['quantity'],
                    'line_total' => (int) $it['line_total'],
                ]);
            }

            return $order;
        });

        $whatsappMessage = $this->buildWhatsappMessage(
            orderNumber: (string) $order->order_number,
            validated: $validated,
            communeName: $communeName,
            items: $resolvedItems,
            subtotal: $subtotal,
            deliveryCost: $deliveryCost,
            amountToPay: $amountToPay,
        );

        logger()->info('WHATSAPP_ORDER_NOTIFICATION', [
            'to' => '0584828385',
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'message' => $whatsappMessage,
        ]);

        $request->session()->put('last_checkout', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'delivery_mode' => $validated['delivery_mode'],
            'commune_id' => $validated['commune_id'] ?? null,
            'commune_nom' => $communeName,
            'address' => $validated['address'] ?? null,
            'note' => $validated['note'] ?? null,
            'subtotal' => $subtotal,
            'cout_livraison' => $deliveryCost,
            'montant_a_payer' => $amountToPay,
            'created_at' => now()->toDateTimeString(),
        ]);

        $request->session()->forget('cart');

        return redirect()->route('checkout.success');
    }

    private function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');

        for ($i = 0; $i < 10; $i++) {
            $suffix = Str::upper(Str::random(6));
            $orderNumber = "ORD-{$date}-{$suffix}";

            if (!Order::query()->where('order_number', $orderNumber)->exists()) {
                return $orderNumber;
            }
        }

        return 'ORD-' . $date . '-' . (string) Str::uuid();
    }

    /**
     * @param array{full_name:string,phone:string,delivery_mode:string,commune_id?:mixed,address?:mixed,note?:mixed} $validated
     * @param array<int,array{product:\App\Models\Product,quantity:int,unit_price:int,line_total:int}> $items
     */
    private function buildWhatsappMessage(
        string $orderNumber,
        array $validated,
        ?string $communeName,
        array $items,
        int $subtotal,
        int $deliveryCost,
        int $amountToPay,
    ): string {
        $lines = [];
        $lines[] = "Nouvelle commande {$orderNumber}";
        $lines[] = "Client: {$validated['full_name']}";
        $lines[] = "Téléphone: {$validated['phone']}";

        $mode = $validated['delivery_mode'] === 'delivery' ? 'Livraison' : 'Retrait boutique';
        $lines[] = "Mode: {$mode}";

        if ($validated['delivery_mode'] === 'delivery') {
            if ($communeName) {
                $lines[] = "Commune: {$communeName}";
            }
            $address = trim((string) ($validated['address'] ?? ''));
            if ($address !== '') {
                $lines[] = "Adresse: {$address}";
            }
        }

        $note = trim((string) ($validated['note'] ?? ''));
        if ($note !== '') {
            $lines[] = "Note: {$note}";
        }

        $lines[] = "---";
        foreach ($items as $it) {
            $p = $it['product'];
            $brand = trim((string) ($p->brand ?? ''));
            $name = trim((string) $p->name);
            $label = $brand !== '' ? "{$brand} {$name}" : $name;
            $lines[] = "- {$label} x{$it['quantity']} = {$it['line_total']} FCFA";
        }
        $lines[] = "---";
        $lines[] = "Total produits: {$subtotal} FCFA";
        $lines[] = "Livraison: {$deliveryCost} FCFA";
        $lines[] = "Montant à payer: {$amountToPay} FCFA";

        return implode("\n", $lines);
    }

    public function success(Request $request): View
    {
        $checkout = (array) $request->session()->get('last_checkout', []);

        return view('checkout.success', [
            'checkout' => $checkout,
        ]);
    }
}
