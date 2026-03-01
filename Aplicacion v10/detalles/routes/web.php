<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;

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
        ->where('activo', true)
        ->orderBy('orden')
        ->orderByDesc('created_at')
        ->get();

    return view('shop.home', compact('categories', 'products'));
})->name('home');

Route::get('about', fn () => view('shop.pages.about'))->name('about');
Route::get('terms', fn () => view('shop.pages.terms'))->name('terms');

Route::get('products', function () {
    $categories = \App\Models\Category::where('activo', true)
        ->orderBy('orden')
        ->get();

    $products = \App\Models\Product::with('categories')
        ->where('activo', true)
        ->orderBy('orden')
        ->orderByDesc('created_at')
        ->get();

    return view('shop.products.products', compact('categories', 'products'));
})->name('products');

Route::get('gallery', function () {
    $galleries = \App\Models\Gallery::activeOrdered()->get();
    $histories = \App\Models\History::latest()->take(10)->get();

    return view('shop.pages.gallery', compact('galleries', 'histories'));
})->name('gallery');


/*
|--------------------------------------------------------------------------
| CARRITO (SHOP)
|--------------------------------------------------------------------------
*/
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');


/*
|--------------------------------------------------------------------------
| CLIENTE (AUTENTICADO)
|--------------------------------------------------------------------------
| IMPORTANTE:
| Si apuntas a Controllers que NO existen, php artisan route:list se rompe.
| Por eso aquí dejamos solo los controllers que sí existen/estás usando.
*/
Route::middleware(['auth'])
    ->prefix('cliente')
    ->name('client.')
    ->group(function () {

        // Dashboard (cliente)
        Route::get('dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])
            ->name('dashboard');

        // Pedidos (cliente)
        Route::get('orders', [\App\Http\Controllers\Client\OrderController::class, 'index'])
            ->name('orders');

        Route::get('orders/{order}', [\App\Http\Controllers\Client\OrderController::class, 'show'])
            ->name('orders.show');

        // Perfil (cliente)
        Route::get('profile', [\App\Http\Controllers\Client\ProfileController::class, 'index'])
            ->name('profile');

        Route::post('profile', [\App\Http\Controllers\Client\ProfileController::class, 'update'])
    ->name('profile.update');

        Route::get('catalogo', function () {
          $categories = \App\Models\Category::where('activo', true)->orderBy('orden')->get();
          $products = \App\Models\Product::with('categories')
        ->where('activo', true)
        ->orderBy('orden')
        ->orderByDesc('created_at')
        ->get();
         return view('shop.products.products', compact('categories', 'products'));
        })->name('catalog');

        // Catálogo cliente (temporal: reutiliza la vista pública)
        Route::get('catalogo', function () {
          $categories = \App\Models\Category::where('activo', true)->orderBy('orden')->get();
          $products = \App\Models\Product::with('categories')
        ->where('activo', true)
        ->orderBy('orden')
        ->orderByDesc('created_at')
        ->get();

        return view('shop.products.products', compact('categories', 'products'));
     })->name('catalog');

// Promociones cliente (temporal: muestra una vista simple)
Route::get('promociones', function () {
    return view('client.promos');
})->name('promos');

        // Promociones cliente (temporal: redirige a productos)
Route::get('promociones', function () {
    return redirect()->route('products');
})->name('promos');

// Carrito cliente (temporal: redirige al carrito público)
Route::get('carrito', function () {
    return redirect()->route('cart');
})->name('cart');

        /*
        |------------------------------------------------------------------
        | RUTAS FUTURAS (ACTIVAR CUANDO EXISTAN LOS CONTROLLERS)
        |------------------------------------------------------------------
        */

        // // Catálogo + producto
        // Route::get('catalogo', [\App\Http\Controllers\Client\CatalogController::class, 'index'])
        //     ->name('catalog');
        // Route::get('producto/{product:slug}', [\App\Http\Controllers\Client\ProductController::class, 'show'])
        //     ->name('product.show');

        // // Carrito (cliente)
        // Route::get('carrito', [\App\Http\Controllers\Client\CartController::class, 'index'])
        //     ->name('cart');
        // Route::post('carrito/agregar/{product}', [\App\Http\Controllers\Client\CartController::class, 'add'])
        //     ->name('cart.add');
        // Route::post('carrito/quitar/{product}', [\App\Http\Controllers\Client\CartController::class, 'remove'])
        //     ->name('cart.remove');

        // // Direcciones / pago / promos
        // Route::get('direcciones', [\App\Http\Controllers\Client\AddressController::class, 'index'])
        //     ->name('addresses');
        // Route::get('metodos-pago', [\App\Http\Controllers\Client\PaymentMethodController::class, 'index'])
        //     ->name('payments');
        // Route::get('promociones', [\App\Http\Controllers\Client\PromoController::class, 'index'])
        //     ->name('promos');
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

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Perfil admin
        Route::get('profile', [AdminProfileController::class, 'perfil'])->name('profile');
        Route::post('profile/update', [AdminProfileController::class, 'actualizar'])->name('profile.update');

        // Usuarios
        Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
        Route::resource('users', UserController::class)->except(['show', 'destroy']);

        // Productos
        Route::get('products/category/{category}', [ProductController::class, 'byCategory'])
            ->name('products.byCategory');

        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)
            ->names('products')
            ->except(['show']);

        // Categorías
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Inventario
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');

        // Pedidos y ventas (admin)
        Route::get('orders', fn () => view('admin.orders.index'))->name('orders.index');
        Route::get('invoices', fn () => view('admin.invoices.index'))->name('invoices.index');
        Route::get('transactions', fn () => view('admin.transactions.index'))->name('transactions.index');
        Route::get('shipments', fn () => view('admin.shipments.index'))->name('shipments.index');

        // Clientes / reseñas
        Route::get('customers', function () {
            return redirect()->route('admin.users.index', ['role' => 'cliente']);
        })->name('customers.index');

        Route::get('reviews', fn () => view('admin.reviews.index'))->name('reviews.index');

        // Reportes
        Route::get('reports/sales', fn () => view('admin.reports.sales'))->name('reports.sales');
        Route::get('reports/products', fn () => view('admin.reports.products'))->name('reports.products');
        Route::get('reports/customers', fn () => view('admin.reports.customers'))->name('reports.customers');
    });


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();
