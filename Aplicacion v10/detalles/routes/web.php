<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
/*
|--------------------------------------------------------------------------
| PÁGINAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $categories = \App\Models\Category::where('activo', true)
        ->orderBy('orden')
        ->get();

    $products = \App\Models\Product::with('categories')
        ->where('activo', true)
        ->orderBy('orden')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('shop.home', compact('categories', 'products'));
})->name('home');

Route::get('/about', fn () => view('shop.pages.about'))->name('about');
Route::get('/terms', fn () => view('shop.pages.terms'))->name('terms');

Route::get('/products', function () {
    $categories = \App\Models\Category::where('activo', true)
        ->orderBy('orden')
        ->get();

    $products = \App\Models\Product::with('categories')
        ->where('activo', true)
        ->orderBy('orden')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('shop.products.products', compact('categories', 'products'));
})->name('products');

Route::get('/gallery', function () {
    $galleries = \App\Models\Gallery::activeOrdered()->get();
    $histories = \App\Models\History::latest()->take(10)->get();

    return view('shop.pages.gallery', compact('galleries', 'histories'));
})->name('gallery');

/*
|--------------------------------------------------------------------------
| CARRITO
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

/*
|--------------------------------------------------------------------------
| CLIENTE (AUTENTICADO)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('cliente')
    ->name('client.')
    ->group(function () {

        Route::get('/dashboard', function () {
            $orders = \App\Models\Order::where('user_id', auth()->id())
                ->latest()
                ->take(5)
                ->get();

            return view('client.dashboard', compact('orders'));
        })->name('dashboard');

        Route::get('/orders', fn () => view('client.orders'))->name('orders');
        Route::get('/profile', fn () => view('client.profile'))->name('profile');
    });

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
         Route::middleware(['auth', 'admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

        Route::resource('products', ProductController::class);

        /* DASHBOARD */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        /* PERFIL */
        Route::get('/profile', [ProfileController::class, 'perfil'])
            ->name('profile');

        Route::post('/profile/update', [ProfileController::class, 'actualizar'])
            ->name('profile.update');

        /* CATÁLOGO */
        Route::resource('products', ProductController::class)
    ->names('products');

        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories');

        Route::get('/inventory', [InventoryController::class, 'index'])
            ->name('inventory');

        /* PEDIDOS Y VENTAS */
        Route::get('/orders', fn () => view('admin.orders.index'))
            ->name('orders');

        Route::get('/invoices', fn () => view('admin.invoices.index'))
            ->name('invoices');

        Route::get('/transactions', fn () => view('admin.transactions.index'))
            ->name('transactions');

        Route::get('/shipments', fn () => view('admin.shipments.index'))
            ->name('shipments');

        /* USUARIOS */
        Route::get('/customers', fn () => view('admin.customers.index'))
            ->name('customers');

        Route::get('/reviews', fn () => view('admin.reviews.index'))
            ->name('reviews');

        /* REPORTES */
        Route::get('/reports/sales', fn () => view('admin.reports.sales'))
            ->name('reports.sales');

        Route::get('/reports/products', fn () => view('admin.reports.products'))
            ->name('reports.products');

        Route::get('/reports/customers', fn () => view('admin.reports.customers'))
            ->name('reports.customers');
    });

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();
