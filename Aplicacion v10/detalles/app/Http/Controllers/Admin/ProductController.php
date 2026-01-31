<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('activo', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::create([
            'nombre' => $request->nombre,
            'descripcion_corta' => $request->descripcion_corta,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'activo' => true,
        ]);

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('activo', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->only([
            'nombre',
            'descripcion_corta',
            'precio',
            'stock',
            'activo'
        ]));

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Producto eliminado');
    }
}
