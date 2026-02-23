<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Lista con filtros (admin).
     * Lógica TEMU:
     * - category_id = categoría principal (grupo=tipo_producto)
     * - categorias_products = filtros (grupo=ocasion|personalizacion)
     */
    public function index(Request $request)
    {
        $q = $request->get('q');

        // Estado: activos | borrador | todos
        $estado = $request->get('estado', 'activos');

        // Filtros por categorías (IDs)
        $tipoProductoId = $request->get('tipo_producto');        // products.category_id
        $ocasionId      = $request->get('ocasion');              // pivot (categories.grupo=ocasion)
        $personalId     = $request->get('personalizacion');      // pivot (categories.grupo=personalizacion)

        // Orden: recent | name_asc | name_desc
        $sort = $request->get('sort', 'recent');

        $productsQuery = Product::query()
            ->with(['principalCategory', 'categories']);

        // Estado
        if ($estado === 'activos') {
            $productsQuery->where('activo', 1);
        } elseif ($estado === 'borrador') {
            $productsQuery->where('activo', 0);
        }

        // Buscar por nombre o SKU
        if ($q) {
            $productsQuery->where(function ($qq) use ($q) {
                $qq->where('nombre', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            });
        }

        // Filtrar por categoría principal (tipo_producto) -> products.category_id
        if ($tipoProductoId) {
            $productsQuery->where('category_id', (int) $tipoProductoId);
        }

        // Filtrar por ocasión (pivot)
        if ($ocasionId) {
            $productsQuery->whereHas('categories', function ($c) use ($ocasionId) {
                $c->where('categories.id', (int) $ocasionId)
                  ->where('categories.grupo', 'ocasion');
            });
        }

        // Filtrar por personalización (pivot)
        if ($personalId) {
            $productsQuery->whereHas('categories', function ($c) use ($personalId) {
                $c->where('categories.id', (int) $personalId)
                  ->where('categories.grupo', 'personalizacion');
            });
        }

        // Orden
        if ($sort === 'name_asc') {
            $productsQuery->orderBy('nombre', 'asc');
        } elseif ($sort === 'name_desc') {
            $productsQuery->orderBy('nombre', 'desc');
        } else {
            $productsQuery->orderByDesc('created_at');
        }

        $products = $productsQuery->paginate(10)->withQueryString();

        // Categorías para selects del filtro (por grupo)
        $catsTipoProducto = Category::query()->where('activo', 1)->where('grupo', 'tipo_producto')->orderBy('orden')->get();
        $catsOcasion      = Category::query()->where('activo', 1)->where('grupo', 'ocasion')->orderBy('orden')->get();
        $catsPersonal     = Category::query()->where('activo', 1)->where('grupo', 'personalizacion')->orderBy('orden')->get();

        return view('admin.products.index', compact(
            'products',
            'catsTipoProducto',
            'catsOcasion',
            'catsPersonal'
        ));
    }

    public function create()
    {
        $catsTipoProducto = Category::query()->where('activo', 1)->where('grupo', 'tipo_producto')->orderBy('orden')->get();
        $catsOcasion      = Category::query()->where('activo', 1)->where('grupo', 'ocasion')->orderBy('orden')->get();
        $catsPersonal     = Category::query()->where('activo', 1)->where('grupo', 'personalizacion')->orderBy('orden')->get();

        return view('admin.products.create', compact('catsTipoProducto', 'catsOcasion', 'catsPersonal'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'nombre'            => 'required|string|max:255',
        'descripcion_corta' => 'nullable|string|max:255',
        'precio'            => 'required|numeric|min:0',
        'stock'             => 'required|integer|min:0',

        // vienen del blade
        'tipo_producto'        => 'required|integer|exists:categories,id',
        'ocasion_especial'     => 'nullable|integer|exists:categories,id',
        'tipo_personalizacion' => 'nullable|integer|exists:categories,id',

        'activo'         => 'required|boolean',
        'personalizable' => 'required|boolean',
    ]);

    /*
    |--------------------------------------------------------------------------
    | VALIDAR QUE tipo_producto PERTENEZCA AL GRUPO CORRECTO
    |--------------------------------------------------------------------------
    */
    $mainCategory = Category::where('id', $data['tipo_producto'])
        ->where('grupo', 'tipo_producto')
        ->first();

    if (!$mainCategory) {
        return back()
            ->withErrors(['tipo_producto' => 'Debe seleccionar una categoría válida de Tipo de Producto.'])
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | GENERAR SKU AUTOMÁTICO
    |--------------------------------------------------------------------------
    */
    $sku = 'SD-' . strtoupper(Str::random(8));

    while (Product::where('sku', $sku)->exists()) {
        $sku = 'SD-' . strtoupper(Str::random(8));
    }

    /*
    |--------------------------------------------------------------------------
    | CREAR PRODUCTO
    |--------------------------------------------------------------------------
    */
    $product = Product::create([
        'nombre'            => $data['nombre'],
        'descripcion_corta' => $data['descripcion_corta'] ?? null,
        'precio'            => $data['precio'],
        'stock'             => $data['stock'],
        'sku'               => $sku,
        'category_id'       => $data['tipo_producto'], // categoría principal
        'activo'            => $request->boolean('activo'),
        'personalizable'    => $request->boolean('personalizable'),
        'slug'              => $this->uniqueSlug($data['nombre']),
        'fingreso'          => now()->toDateString(),
    ]);

    /*
    |--------------------------------------------------------------------------
    | GUARDAR FILTROS EN PIVOT (OCASIÓN Y PERSONALIZACIÓN)
    |--------------------------------------------------------------------------
    */
    $pivotIds = [];

    if (!empty($data['ocasion_especial'])) {
        $pivotIds[] = $data['ocasion_especial'];
    }

    if (!empty($data['tipo_personalizacion'])) {
        $pivotIds[] = $data['tipo_personalizacion'];
    }

    if (!empty($pivotIds)) {
        $product->categories()->sync($pivotIds);
    }

    return redirect()
        ->route('admin.products.index')
        ->with('success', 'Producto creado correctamente');
}
    public function edit(Product $product)
    {
        $catsTipoProducto = Category::query()->where('activo', 1)->where('grupo', 'tipo_producto')->orderBy('orden')->get();
        $catsOcasion      = Category::query()->where('activo', 1)->where('grupo', 'ocasion')->orderBy('orden')->get();
        $catsPersonal     = Category::query()->where('activo', 1)->where('grupo', 'personalizacion')->orderBy('orden')->get();

        $selectedIds = $product->categories()->pluck('categories.id')->toArray();

        // Separar por grupos (para marcar checks correctos)
        $selectedOcasion = Category::query()->whereIn('id', $selectedIds)->where('grupo', 'ocasion')->pluck('id')->toArray();
        $selectedPersonal = Category::query()->whereIn('id', $selectedIds)->where('grupo', 'personalizacion')->pluck('id')->toArray();

        return view('admin.products.edit', compact(
            'product',
            'catsTipoProducto',
            'catsOcasion',
            'catsPersonal',
            'selectedOcasion',
            'selectedPersonal'
        ));
    }

    public function update(Request $request, Product $product)
{
    $data = $request->validate([
        'nombre'                 => 'required|string|max:255',
        'descripcion_corta'      => 'nullable|string|max:255',
        'precio'                 => 'required|numeric|min:0',
        'stock'                  => 'required|integer|min:0',

        'tipo_producto'          => 'required|integer|exists:categories,id',
        'ocasion_especial'       => 'nullable|integer|exists:categories,id',
        'tipo_personalizacion'   => 'nullable|integer|exists:categories,id',

        'activo'         => 'required|boolean',
        'personalizable' => 'required|boolean',
    ]);

    /*
    |--------------------------------------------------------------------------
    | VALIDAR QUE LA CATEGORÍA PRINCIPAL SEA DEL GRUPO CORRECTO
    |--------------------------------------------------------------------------
    */
    $mainCategory = Category::where('id', $data['tipo_producto'])
        ->where('grupo', 'tipo_producto')
        ->first();

    if (!$mainCategory) {
        return back()
            ->withErrors(['tipo_producto' => 'Debe seleccionar una categoría válida de Tipo de Producto.'])
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | SI CAMBIA EL NOMBRE, REGENERAR SLUG
    |--------------------------------------------------------------------------
    */
    if ($product->nombre !== $data['nombre']) {
        $product->slug = $this->uniqueSlug($data['nombre'], $product->id);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR DATOS PRINCIPALES
    |--------------------------------------------------------------------------
    */
    $product->update([
        'nombre'            => $data['nombre'],
        'descripcion_corta' => $data['descripcion_corta'] ?? null,
        'precio'            => $data['precio'],
        'stock'             => $data['stock'],
        'category_id'       => $data['tipo_producto'],
        'activo'            => $request->boolean('activo'),
        'personalizable'    => $request->boolean('personalizable'),
    ]);

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR FILTROS (PIVOT)
    |--------------------------------------------------------------------------
    */
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

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Producto eliminado');
    }

    /**
     * Genera slug único.
     */
    private function uniqueSlug(string $nombre, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nombre);
        $slug = $baseSlug;
        $i = 2;

        while (
            Product::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    /**
     * Filtra IDs asegurando que pertenezcan al grupo solicitado.
     */
    private function onlyGroupIds(array $ids, string $grupo): array
    {
        if (empty($ids)) return [];

        return Category::query()
            ->whereIn('id', $ids)
            ->where('grupo', $grupo)
            ->pluck('id')
            ->map(fn($v) => (int) $v)
            ->toArray();
    }
}
