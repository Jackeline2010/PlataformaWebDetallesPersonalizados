<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $products = Product::with(['principalCategory', 'categories'])
            ->orderByDesc('created_at')
            ->paginate(10);

        $catsTipoProducto = Category::where('activo', 1)
            ->where('grupo', 'tipo_producto')
            ->orderBy('orden')
            ->get();

        $catsOcasion = Category::where('activo', 1)
            ->where('grupo', 'ocasion')
            ->orderBy('orden')
            ->get();

        $catsPersonal = Category::where('activo', 1)
            ->where('grupo', 'personalizacion')
            ->orderBy('orden')
            ->get();

        return view('admin.products.index', compact(
            'products',
            'catsTipoProducto',
            'catsOcasion',
            'catsPersonal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $catsTipoProducto = Category::where('activo', 1)
            ->where('grupo', 'tipo_producto')
            ->orderBy('orden')
            ->get();

        $catsOcasion = Category::where('activo', 1)
            ->where('grupo', 'ocasion')
            ->orderBy('orden')
            ->get();

        $catsPersonal = Category::where('activo', 1)
            ->where('grupo', 'personalizacion')
            ->orderBy('orden')
            ->get();

        return view('admin.products.create', compact(
            'catsTipoProducto',
            'catsOcasion',
            'catsPersonal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion_corta' => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',

            'tipo_producto'        => 'required|integer|exists:categories,id',
            'ocasion_especial'     => 'nullable|integer|exists:categories,id',
            'tipo_personalizacion' => 'nullable|integer|exists:categories,id',

            'activo'         => 'required|boolean',
            'personalizable' => 'required|boolean',

            'imagen_principal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Validar grupo correcto
        $mainCategory = Category::where('id', $data['tipo_producto'])
            ->where('grupo', 'tipo_producto')
            ->first();

        if (!$mainCategory) {
            return back()
                ->withErrors(['tipo_producto' => 'Debe seleccionar una categoría válida.'])
                ->withInput();
        }

        // Guardar imagen
        $imagePath = null;
        if ($request->hasFile('imagen_principal')) {
            $imagePath = $request->file('imagen_principal')
                ->store('products', 'public');
        }

        // Generar SKU único
        $sku = 'SD-' . strtoupper(Str::random(8));
        while (Product::where('sku', $sku)->exists()) {
            $sku = 'SD-' . strtoupper(Str::random(8));
        }

        // Crear producto
        $product = Product::create([
            'nombre'            => $data['nombre'],
            'descripcion_corta' => $data['descripcion_corta'] ?? null,
            'precio'            => $data['precio'],
            'stock'             => $data['stock'],
            'sku'               => $sku,
            'category_id'       => $data['tipo_producto'],
            'activo'            => $request->boolean('activo'),
            'personalizable'    => $request->boolean('personalizable'),
            'slug'              => $this->uniqueSlug($data['nombre']),
            'fingreso'          => now()->toDateString(),
            'imagen_principal'  => $imagePath,
        ]);

        // Guardar pivot
        $pivotIds = [];

        if (!empty($data['ocasion_especial'])) {
            $pivotIds[] = $data['ocasion_especial'];
        }

        if (!empty($data['tipo_personalizacion'])) {
            $pivotIds[] = $data['tipo_personalizacion'];
        }

        $product->categories()->sync($pivotIds);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Product $product)
    {
        $catsTipoProducto = Category::where('grupo', 'tipo_producto')->get();
        $catsOcasion = Category::where('grupo', 'ocasion')->get();
        $catsPersonal = Category::where('grupo', 'personalizacion')->get();

        $selectedIds = $product->categories()->pluck('categories.id')->toArray();

        $selectedOcasion = Category::whereIn('id', $selectedIds)
            ->where('grupo', 'ocasion')
            ->pluck('id')
            ->toArray();

        $selectedPersonal = Category::whereIn('id', $selectedIds)
            ->where('grupo', 'personalizacion')
            ->pluck('id')
            ->toArray();

        return view('admin.products.edit', compact(
            'product',
            'catsTipoProducto',
            'catsOcasion',
            'catsPersonal',
            'selectedOcasion',
            'selectedPersonal'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nombre'            => 'required|string|max:255',
            'descripcion_corta' => 'nullable|string|max:255',
            'precio'            => 'required|numeric|min:0',
            'stock'             => 'required|integer|min:0',

            'tipo_producto'        => 'required|integer|exists:categories,id',
            'ocasion_especial'     => 'nullable|integer|exists:categories,id',
            'tipo_personalizacion' => 'nullable|integer|exists:categories,id',

            'activo'         => 'required|boolean',
            'personalizable' => 'required|boolean',

            'imagen_principal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $updateData = [
            'nombre'            => $data['nombre'],
            'descripcion_corta' => $data['descripcion_corta'] ?? null,
            'precio'            => $data['precio'],
            'stock'             => $data['stock'],
            'category_id'       => $data['tipo_producto'],
            'activo'            => $request->boolean('activo'),
            'personalizable'    => $request->boolean('personalizable'),
        ];

        // Regenerar slug si cambia nombre
        if ($product->nombre !== $data['nombre']) {
            $updateData['slug'] = $this->uniqueSlug($data['nombre'], $product->id);
        }

        // Actualizar imagen
        if ($request->hasFile('imagen_principal')) {
            if (!empty($product->imagen_principal)) {
                Storage::disk('public')->delete($product->imagen_principal);
            }

            $updateData['imagen_principal'] = $request->file('imagen_principal')
                ->store('products', 'public');
        }

        $product->update($updateData);

        // Sync pivot
        $pivotIds = [];
        if (!empty($data['ocasion_especial'])) {
            $pivotIds[] = $data['ocasion_especial'];
        }
        if (!empty($data['tipo_personalizacion'])) {
            $pivotIds[] = $data['tipo_personalizacion'];
        }

        $product->categories()->sync($pivotIds);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(Product $product)
    {
        if (!empty($product->imagen_principal)) {
            Storage::disk('public')->delete($product->imagen_principal);
        }

        $product->delete();

        return back()->with('success', 'Producto eliminado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | SLUG ÚNICO
    |--------------------------------------------------------------------------
    */
    private function uniqueSlug(string $nombre, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nombre);
        $slug = $baseSlug;
        $i = 2;

        while (
            Product::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
