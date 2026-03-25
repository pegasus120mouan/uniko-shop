<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::get('/', [ShopController::class, 'home'])->name('shop.home');
Route::get('/catalogue', [ShopController::class, 'catalog'])->name('shop.catalog');
Route::get('/produits/{product}', [ShopController::class, 'product'])->name('shop.product');

Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/panier/maj', [CartController::class, 'update'])->name('cart.update');
Route::post('/panier/supprimer/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/commande', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/commande', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/commande/succes', [CheckoutController::class, 'success'])->name('checkout.success');
