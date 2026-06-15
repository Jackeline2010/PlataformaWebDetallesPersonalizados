<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ExtraController;
use App\Http\Controllers\Client\ProductCustomizationController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Admin\PromotionController;

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
| CARRITO PÚBLICO / SHOP
|--------------------------------------------------------------------------
*/
Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');



       /*
     CLIENTE AUTENTICADO
        /*
-------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('cliente')
    ->name('client.')
    ->group(function () {

        Route::get('dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('orders', [\App\Http\Controllers\Client\OrderController::class, 'index'])
            ->name('orders');

        Route::get('orders/{order}', [\App\Http\Controllers\Client\OrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('orders/{order}/cancel', [\App\Http\Controllers\Client\OrderController::class, 'cancel'])
            ->name('orders.cancel');

        Route::get('profile', [\App\Http\Controllers\Client\ProfileController::class, 'index'])
            ->name('profile');

        Route::post('profile', [\App\Http\Controllers\Client\ProfileController::class, 'update'])
            ->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | MÉTODOS DE PAGO DEL CLIENTE
        |--------------------------------------------------------------------------
        */
        Route::view('metodos-pago', 'client.payment.methods')
            ->name('payments');

        /*
        |--------------------------------------------------------------------------
        | CHECKOUT
        |--------------------------------------------------------------------------
        */
        Route::get('checkout', [CartController::class, 'checkout'])
            ->name('checkout');

        Route::post('checkout/confirm', [\App\Http\Controllers\Client\OrderController::class, 'store'])
            ->name('checkout.store');

        /*
        |--------------------------------------------------------------------------
        | PAGOS
        |--------------------------------------------------------------------------
        */
        Route::get('orders/{order}/payment', [PaymentController::class, 'index'])
            ->name('payment.index');

        Route::post('orders/{order}/payment', [PaymentController::class, 'store'])
            ->name('payment.store');

        Route::get('payment/niubiz/{order}', [PaymentController::class, 'niubiz'])
            ->name('payment.niubiz');

        Route::post('payment/niubiz/{order}/authorize', [PaymentController::class, 'authorizeNiubiz'])
            ->name('payment.niubiz.authorize');

        Route::get('payment/failed/{order}', [PaymentController::class, 'failed'])
            ->name('payment.failed');

        /*
        |--------------------------------------------------------------------------
        | CATÁLOGO DE PRODUCTOS
        |--------------------------------------------------------------------------
        */
        Route::get('catalogo', [\App\Http\Controllers\Client\ProductController::class, 'index'])
            ->name('products.index');

        Route::get('producto/{product}', [\App\Http\Controllers\Client\ProductController::class, 'show'])
            ->name('products.show');

        /*
        |--------------------------------------------------------------------------
        | COMPRA DIRECTA SIN PERSONALIZAR
        |--------------------------------------------------------------------------
        */
        Route::post('productos/{product}/comprar-asi', [CartController::class, 'buyAsIs'])
            ->name('products.buyAsIs');

        /*
        |--------------------------------------------------------------------------
        | CARRITO DEL CLIENTE
        |--------------------------------------------------------------------------
        */
        Route::get('carrito', [CartController::class, 'index'])
            ->name('cart.index');

        Route::post('carrito/agregar/{product}', [CartController::class, 'add'])
            ->name('cart.add');

        Route::patch('carrito/actualizar/{itemId}', [CartController::class, 'updateQuantity'])
            ->name('cart.update');

        Route::delete('carrito/eliminar/{itemId}', [CartController::class, 'remove'])
            ->name('cart.remove');

        Route::post('carrito/promocion', [CartController::class, 'applyPromotion'])
            ->name('cart.applyPromotion');

        Route::delete('carrito/promocion', [CartController::class, 'removePromotion'])
            ->name('cart.removePromotion');

        /*
        |--------------------------------------------------------------------------
        | PERSONALIZACIÓN VISUAL DEL PRODUCTO
        |--------------------------------------------------------------------------
        */
        Route::get('productos/{product}/personalizar', [ProductCustomizationController::class, 'edit'])
            ->name('products.customize');

        /*
        |--------------------------------------------------------------------------
        | ACCESOS RÁPIDOS
        |--------------------------------------------------------------------------
        */
        Route::get('promociones', function () {
        $promotions = \App\Models\Promotion::where('activo', true)
        ->orderByDesc('created_at')
        ->get();

        return view('client.promotions.index', compact('promotions'));
        })->name('promos');

        Route::get('carrito-rapido', function () {
            return redirect()->route('client.cart.index');
        })->name('cart');
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

        Route::get('dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::patch('orders/{order}/confirm-payment', [\App\Http\Controllers\Admin\OrderController::class, 'confirmPayment'])
        ->name('orders.confirmPayment');

        Route::patch('orders/{order}/complete', [\App\Http\Controllers\Admin\OrderController::class, 'complete'])
    ->name('orders.complete');

        /*
        |--------------------------------------------------------------------------
        | PERFIL ADMIN
        |--------------------------------------------------------------------------
        */
        Route::get('profile', [AdminProfileController::class, 'perfil'])
            ->name('profile');

        Route::post('profile/update', [AdminProfileController::class, 'actualizar'])
            ->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | USUARIOS
        |--------------------------------------------------------------------------
        */
        Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])
            ->name('users.toggle');

        Route::resource('users', UserController::class)
            ->except(['show', 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | PRODUCTOS
        |--------------------------------------------------------------------------
        */
        Route::get('products/category/{category}', [ProductController::class, 'byCategory'])
            ->name('products.byCategory');

        /*
        |--------------------------------------------------------------------------
        | PERSONALIZACIÓN DE PRODUCTOS
        |--------------------------------------------------------------------------
        */
        Route::get('products/{product}/personalization', [ProductController::class, 'personalization'])
            ->name('products.personalization');

        Route::put('products/{product}/personalization', [ProductController::class, 'updatePersonalization'])
            ->name('products.personalization.update');

        Route::get('products/{product}/personalization/options/{option}/edit', [ProductController::class, 'editPersonalizationOption'])
            ->name('products.personalization.option.edit');

        Route::put('products/{product}/personalization/options/{option}', [ProductController::class, 'updatePersonalizationOption'])
            ->name('products.personalization.option.update');

        Route::delete('products/{product}/personalization/options/{option}', [ProductController::class, 'destroyPersonalizationOption'])
            ->name('products.personalization.option.destroy');

        Route::post('products/{product}/personalization/fields/{field}/options', [ProductController::class, 'storeFieldOption'])
            ->name('products.personalization.fields.options.store');

        Route::delete('products/{product}/personalization/fields/{field}/options/{option}', [ProductController::class, 'destroyFieldOption'])
            ->name('products.personalization.fields.options.destroy');

        Route::resource('products', ProductController::class)
            ->names('products')
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | COLORES DE PRODUCTOS
        |--------------------------------------------------------------------------
        */
        Route::get('products/{product}/colors', [ProductColorController::class, 'index'])
            ->name('products.colors.index');

        Route::post('products/{product}/colors', [ProductColorController::class, 'store'])
            ->name('products.colors.store');

        Route::delete('colors/{color}', [ProductColorController::class, 'destroy'])
            ->name('colors.destroy');

        /*
        |--------------------------------------------------------------------------
        | EXTRAS
        |--------------------------------------------------------------------------
        */
        Route::resource('extras', ExtraController::class)
            ->names('extras')
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------------------
        */
        Route::get('categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::post('categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');

        Route::put('categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        /*
        |--------------------------------------------------------------------------
        | INVENTARIO
        |--------------------------------------------------------------------------
        */
        Route::get('inventory', [InventoryController::class, 'index'])
            ->name('inventory.index');

        Route::get('inventory/products', [InventoryController::class, 'products'])
            ->name('inventory.products');

        Route::get('inventory/extras', [InventoryController::class, 'extras'])
            ->name('inventory.extras');

        Route::patch('inventory/products/{product}/stock', [InventoryController::class, 'updateProductStock'])
            ->name('inventory.products.updateStock');

        Route::patch('inventory/extras/{extra}/stock', [InventoryController::class, 'updateExtraStock'])
            ->name('inventory.extras.updateStock');
        /*
        |--------------------------------------------------------------------------
        | PEDIDOS Y VENTAS
        |--------------------------------------------------------------------------
        */
        Route::get('orders', function () {
            $orders = \App\Models\Order::with('user')
                ->latest('fpedido')
                ->paginate(10);

            return view('admin.orders.index', compact('orders'));
        })->name('orders.index');

        Route::get('transactions', function () {
            $orders = \App\Models\Order::with('user')
                ->whereNotNull('metodo_pago')
                ->latest('fpedido')
                ->paginate(10);

            return view('admin.transactions.index', compact('orders'));
        })->name('transactions.index');

        Route::get('shipments', function () {
            $orders = \App\Models\Order::with('user')
                ->whereNotNull('tipo_entrega')
                ->latest('fpedido')
                ->paginate(10);

            return view('admin.shipments.index', compact('orders'));
        })->name('shipments.index');

        Route::resource('promotions', PromotionController::class)
              ->names('promotions')
              ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | CLIENTES / RESEÑAS
        |--------------------------------------------------------------------------
        */
        Route::get('customers', function () {
            return redirect()->route('admin.users.index', ['role' => 'cliente']);
        })->name('customers.index');

        Route::get('reviews', fn () => view('admin.reviews.index'))
            ->name('reviews.index');

        /*
        |--------------------------------------------------------------------------
        | REPORTES
        |--------------------------------------------------------------------------
        */
        Route::get('reports/sales', fn () => view('admin.reports.sales'))
            ->name('reports.sales');

        Route::get('reports/products', fn () => view('admin.reports.products'))
            ->name('reports.products');

        Route::get('reports/customers', fn () => view('admin.reports.customers'))
            ->name('reports.customers');
    });

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();
