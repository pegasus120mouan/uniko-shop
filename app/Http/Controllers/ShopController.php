<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function home(Request $request): View
    {
        $categories = Category::query()
            ->whereHas('products', function ($q) {
                $q->where('is_active', true)
                    ->whereNotNull('parfum_id');
            })
            ->orderBy('name')
            ->get();

        $featured = Product::query()
            ->where('is_active', true)
            ->whereNotNull('parfum_id')
            ->with('category')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $categoryBlocks = [];
        $wantedCategoryNames = [
            'Parfum Femme',
            'Parfum Homme',
            'Parfum mixte',
        ];

        foreach ($wantedCategoryNames as $name) {
            $cat = $categories->firstWhere('name', $name);
            if (!$cat) {
                continue;
            }

            $products = Product::query()
                ->where('is_active', true)
                ->whereNotNull('parfum_id')
                ->where('category_id', $cat->id)
                ->orderByDesc('created_at')
                ->limit(8)
                ->get();

            if ($products->isEmpty()) {
                continue;
            }

            $categoryBlocks[] = [
                'category' => $cat,
                'products' => $products,
            ];
        }

        return view('shop.home', [
            'featured' => $featured,
            'categories' => $categories,
            'categoryBlocks' => $categoryBlocks,
        ]);
    }

    public function catalog(Request $request): View
    {
        $q = (string) $request->query('q', '');
        $categoryId = $request->query('category_id');

        $categories = Category::query()
            ->whereHas('products', function ($q) {
                $q->where('is_active', true)
                    ->whereNotNull('parfum_id');
            })
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->where('is_active', true)
            ->whereNotNull('parfum_id')
            ->with('category')
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('name', 'like', "%{$q}%")
                        ->orWhere('brand', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('shop.catalog', [
            'products' => $products,
            'q' => $q,
            'categories' => $categories,
            'categoryId' => $categoryId,
        ]);
    }

    public function product(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('shop.product', [
            'product' => $product,
        ]);
    }
}
