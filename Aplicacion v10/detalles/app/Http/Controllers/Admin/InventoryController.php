<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.inventory.products');
    }

    public function products(Request $request)
    {
        $query = Product::query()
            ->orderBy('nombre');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('sku', 'like', '%' . $buscar . '%');
            });
        }

        $products = $query->paginate(10)->withQueryString();

        return view('admin.inventory.products', compact('products'));
    }

    public function extras(Request $request)
    {
        $query = Extra::query()
            ->orderBy('nombre');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('sku', 'like', '%' . $buscar . '%');
            });
        }

        $extras = $query->paginate(10)->withQueryString();

        return view('admin.inventory.extras', compact('extras'));
    }

    public function updateProductStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
        ]);

        $product->update([
            'stock' => $validated['stock'],
            'stock_minimo' => $validated['stock_minimo'],
            'activo' => $validated['stock'] > 0,
        ]);

        return redirect()
            ->route('admin.inventory.products')
            ->with('success', 'Stock del producto actualizado correctamente.');
    }

    public function updateExtraStock(Request $request, Extra $extra)
    {
        $validated = $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'controla_stock' => ['nullable', 'boolean'],
        ]);

        $extra->update([
            'stock' => $validated['stock'],
            'stock_minimo' => $validated['stock_minimo'],
            'controla_stock' => $request->has('controla_stock'),
            'activo' => $request->has('controla_stock')
                ? $validated['stock'] > 0
                : $extra->activo,
        ]);

        return redirect()
            ->route('admin.inventory.extras')
            ->with('success', 'Stock del extra actualizado correctamente.');
    }
}
