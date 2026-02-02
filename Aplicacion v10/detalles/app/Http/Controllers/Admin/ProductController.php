<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('activo', true)
        ->orderBy('nombre')
        ->get()
        ->unique('nombre')
        ->values();

    return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion_corta' => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'activo'            => 'nullable|boolean',
            'categories'        => 'nullable|array',
            'categories.*'      => 'integer|exists:categories,id',
        ]);

        // checkbox producto activo
        $data['activo'] = $request->boolean('activo');

        // fingreso obligatorio (si en BD es DATE)
        $data['fingreso'] = now()->toDateString();

        // SLUG ÚNICO
        $baseSlug = Str::slug($data['nombre']);
        $slug = $baseSlug;
        $i = 2;

        while (Product::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        $data['slug'] = $slug;

        // categorías
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $product = Product::create($data);
        $product->categories()->sync($categories);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('activo', true)
        ->orderBy('nombre')
        ->get()
        ->unique('nombre')
        ->values();

    $selectedCategories = $product->categories()->pluck('categories.id')->toArray();

    return view('admin.products.edit', compact('product', 'categories', 'selectedCategories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion_corta' => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',
            'activo'            => 'nullable|boolean',
            'categories'        => 'nullable|array',
            'categories.*'      => 'integer|exists:categories,id',
        ]);

        $data['activo'] = $request->boolean('activo');

        // Si cambió el nombre, recalcular slug único
        if ($product->nombre !== $data['nombre']) {
            $baseSlug = Str::slug($data['nombre']);
            $slug = $baseSlug;
            $i = 2;

           while (
      Product::withTrashed()
        ->where('slug', $slug)
        ->where('id', '!=', $product->id)
        ->exists()
)
                {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }

            $data['slug'] = $slug;
        }

        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $product->update($data);
        $product->categories()->sync($categories);

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
