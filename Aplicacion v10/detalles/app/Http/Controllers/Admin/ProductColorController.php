<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductColorController extends Controller
{
    /**
     * Mostrar la pantalla de colores del producto.
     */
    public function index(Product $product)
    {
        $colors = ProductColor::where('product_id', $product->id)
            ->orderByDesc('id')
            ->get();

        return view('admin.products.colors.index', compact('product', 'colors'));
    }

    /**
     * Guardar un nuevo color para un producto.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'stock'  => 'required|integer|min:0',
        ]);

        $imagePath = null;

        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('products', 'public');
        }

        ProductColor::create([
            'product_id' => $product->id,
            'nombre'     => $validated['nombre'],
            'imagen'     => $imagePath,
            'stock'      => $validated['stock'],
            'activo'     => true,
        ]);

        return redirect()
            ->route('admin.products.colors.index', $product->id)
            ->with('success', 'Color agregado correctamente.');
    }

    /**
     * Eliminar un color del producto.
     */
    public function destroy(ProductColor $color)
    {
        if (!empty($color->imagen) && Storage::disk('public')->exists($color->imagen)) {
            Storage::disk('public')->delete($color->imagen);
        }

        $productId = $color->product_id;

        $color->delete();

        return redirect()
            ->route('admin.products.colors.index', $productId)
            ->with('success', 'Color eliminado correctamente.');
    }
}
