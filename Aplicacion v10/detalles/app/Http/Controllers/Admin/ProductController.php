<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Extra;
use App\Models\Product;
use App\Models\ProductCustomField;
use App\Models\ProductCustomFieldOption;
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
            ->where('grupo', 'ocasion_especial')
            ->orderBy('orden')
            ->get();

        return view('admin.products.index', compact(
            'products',
            'catsTipoProducto',
            'catsOcasion'
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
            ->where('grupo', 'ocasion_especial')
            ->orderBy('orden')
            ->get();

        return view('admin.products.create', compact(
            'catsTipoProducto',
            'catsOcasion'
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
            'nombre'             => 'required|string|max:255',
            'descripcion_corta'  => 'nullable|string|max:255',
            'precio'             => 'required|numeric|min:0',
            'photo_print_price'  => 'nullable|numeric|min:0',
            'stock'              => 'required|integer|min:0',
            'tipo_producto'      => 'required|integer|exists:categories,id',
            'ocasion_especial'   => 'nullable|integer|exists:categories,id',
            'activo'             => 'required|boolean',
            'personalizable'     => 'required|boolean',
            'tiene_variantes'    => 'nullable|boolean',
            'tipo_arreglo'       => 'nullable|string|max:50',
            'plantilla_preview'  => 'nullable|string|max:50',
            'imagen_principal'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $mainCategory = Category::where('id', $data['tipo_producto'])
            ->where('grupo', 'tipo_producto')
            ->first();

        if (!$mainCategory) {
            return back()
                ->withErrors(['tipo_producto' => 'Debe seleccionar una categoría válida.'])
                ->withInput();
        }

        if (!empty($data['ocasion_especial'])) {
            $ocasionCategory = Category::where('id', $data['ocasion_especial'])
                ->where('grupo', 'ocasion_especial')
                ->first();

            if (!$ocasionCategory) {
                return back()
                    ->withErrors(['ocasion_especial' => 'Debe seleccionar una ocasión válida.'])
                    ->withInput();
            }
        }

        $imagePath = null;

        if ($request->hasFile('imagen_principal')) {
            $imagePath = $request->file('imagen_principal')->store('products', 'public');
        }

        $sku = 'SD-' . strtoupper(Str::random(8));
        while (Product::where('sku', $sku)->exists()) {
            $sku = 'SD-' . strtoupper(Str::random(8));
        }

        $product = Product::create([
            'nombre'               => $data['nombre'],
            'descripcion_corta'    => $data['descripcion_corta'] ?? null,
            'precio'               => $data['precio'],
            'photo_print_price'    => $data['photo_print_price'] ?? 0,
            'stock'                => $data['stock'],
            'sku'                  => $sku,
            'category_id'          => $data['tipo_producto'],
            'activo'               => $request->boolean('activo'),
            'personalizable'       => $request->boolean('personalizable'),
            'tiene_variantes'      => $request->boolean('tiene_variantes'),
            'tipo_arreglo'         => $data['tipo_arreglo'] ?? null,
            'plantilla_preview'    => $data['plantilla_preview'] ?? null,
            'customization_zones'  => $this->getPreviewTemplate($data['plantilla_preview'] ?? null),
            'slug'                 => $this->uniqueSlug($data['nombre']),
            'fingreso'             => now()->toDateString(),
            'imagen_principal'     => $imagePath,
        ]);

        $pivotIds = [];

        if (!empty($data['ocasion_especial'])) {
            $pivotIds[] = $data['ocasion_especial'];
        }

        $product->categories()->sync($pivotIds);

        if ($product->tiene_variantes) {
            return redirect()
                ->route('admin.products.colors.index', $product->id)
                ->with('success', 'Producto creado correctamente. Ahora agrega los colores disponibles.');
        }

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
        $product->load('colors');

        $catsTipoProducto = Category::where('activo', 1)
            ->where('grupo', 'tipo_producto')
            ->orderBy('orden')
            ->get();

        $catsOcasion = Category::where('activo', 1)
            ->where('grupo', 'ocasion_especial')
            ->orderBy('orden')
            ->get();

        $selectedIds = $product->categories()->pluck('categories.id')->toArray();

        $selectedOcasion = Category::whereIn('id', $selectedIds)
            ->where('grupo', 'ocasion_especial')
            ->pluck('id')
            ->toArray();

        return view('admin.products.edit', compact(
            'product',
            'catsTipoProducto',
            'catsOcasion',
            'selectedOcasion'
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
            'nombre'             => 'required|string|max:255',
            'descripcion_corta'  => 'nullable|string|max:255',
            'precio'             => 'required|numeric|min:0',
            'photo_print_price'  => 'nullable|numeric|min:0',
            'stock'              => 'required|integer|min:0',
            'tipo_producto'      => 'required|integer|exists:categories,id',
            'ocasion_especial'   => 'nullable|integer|exists:categories,id',
            'activo'             => 'required|boolean',
            'personalizable'     => 'required|boolean',
            'tiene_variantes'    => 'nullable|boolean',
            'tipo_arreglo'       => 'nullable|string|max:50',
            'plantilla_preview'  => 'nullable|string|max:50',
            'imagen_principal'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $mainCategory = Category::where('id', $data['tipo_producto'])
            ->where('grupo', 'tipo_producto')
            ->first();

        if (!$mainCategory) {
            return back()
                ->withErrors(['tipo_producto' => 'Debe seleccionar una categoría válida.'])
                ->withInput();
        }

        if (!empty($data['ocasion_especial'])) {
            $ocasionCategory = Category::where('id', $data['ocasion_especial'])
                ->where('grupo', 'ocasion_especial')
                ->first();

            if (!$ocasionCategory) {
                return back()
                    ->withErrors(['ocasion_especial' => 'Debe seleccionar una ocasión válida.'])
                    ->withInput();
            }
        }

        $updateData = [
            'nombre'               => $data['nombre'],
            'descripcion_corta'    => $data['descripcion_corta'] ?? null,
            'precio'               => $data['precio'],
            'photo_print_price'    => $data['photo_print_price'] ?? 0,
            'stock'                => $data['stock'],
            'category_id'          => $data['tipo_producto'],
            'activo'               => $request->boolean('activo'),
            'personalizable'       => $request->boolean('personalizable'),
            'tiene_variantes'      => $request->boolean('tiene_variantes'),
            'tipo_arreglo'         => $data['tipo_arreglo'] ?? null,
            'plantilla_preview'    => $data['plantilla_preview'] ?? null,
            'customization_zones'  => $this->getPreviewTemplate($data['plantilla_preview'] ?? null),
        ];

        if ($product->nombre !== $data['nombre']) {
            $updateData['slug'] = $this->uniqueSlug($data['nombre'], $product->id);
        }

        if ($request->hasFile('imagen_principal')) {
            if (!empty($product->imagen_principal) && Storage::disk('public')->exists($product->imagen_principal)) {
                Storage::disk('public')->delete($product->imagen_principal);
            }

            $updateData['imagen_principal'] = $request->file('imagen_principal')->store('products', 'public');
        }

        $product->update($updateData);

        $pivotIds = [];

        if (!empty($data['ocasion_especial'])) {
            $pivotIds[] = $data['ocasion_especial'];
        }

        $product->categories()->sync($pivotIds);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - VISTA
    |--------------------------------------------------------------------------
    */
    public function personalization(Product $product)
    {
        $product->load([
            'colors' => function ($query) {
                $query->where('activo', true)->orderBy('id');
            },
            'extras' => function ($query) {
                $query->orderBy('nombre');
            },
        ]);

        $fields = ProductCustomField::where('product_id', $product->id)
            ->with(['options' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $extras = Extra::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $selectedExtras = method_exists($product, 'extras')
            ? $product->extras()->pluck('extras.id')->toArray()
            : [];

        $colors = method_exists($product, 'colors')
            ? $product->colors
            : collect();

        $dedicatoriaField = $fields->first(function ($field) {
            return in_array($field->type, ['text', 'textarea']) &&
                   str_contains(\Illuminate\Support\Str::lower($field->label), 'dedicator');
        });

        $fotoField = $fields->first(function ($field) {
            return $field->type === 'image';
        });

        $colorField = $fields->first(function ($field) {
            return in_array($field->type, ['select', 'radio']) &&
                   str_contains(\Illuminate\Support\Str::lower($field->label), 'color');
        });

        return view('admin.products.personalization', compact(
            'product',
            'fields',
            'extras',
            'selectedExtras',
            'colors',
            'dedicatoriaField',
            'fotoField',
            'colorField'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - GUARDAR CONFIGURACIÓN / AGREGAR CAMPO
    |--------------------------------------------------------------------------
    */
    public function updatePersonalization(Request $request, Product $product)
    {
        $accion = $request->input('accion');

        if ($accion === 'agregar_campo') {
            $validated = $request->validate([
                'label'          => 'required|string|max:255',
                'type'           => 'required|in:text,textarea,select,checkbox,radio,image',
                'help_text'      => 'nullable|string|max:255',
                'max_length'     => 'nullable|integer|min:1',
                'selection_type' => 'nullable|in:single,multiple',
                'max_options'    => 'nullable|integer|min:1',
                'min_options'    => 'nullable|integer|min:0',
            ]);

            $nextSortOrder = ProductCustomField::where('product_id', $product->id)->max('sort_order');
            $nextSortOrder = is_null($nextSortOrder) ? 1 : $nextSortOrder + 1;

            ProductCustomField::create([
                'product_id'      => $product->id,
                'label'           => $validated['label'],
                'type'            => $validated['type'],
                'help_text'       => $validated['help_text'] ?? null,
                'is_required'     => $request->boolean('is_required'),
                'max_length'      => in_array($validated['type'], ['text', 'textarea'])
                    ? ($validated['max_length'] ?? null)
                    : null,
                'max_options'     => in_array($validated['type'], ['select', 'checkbox', 'radio'])
                    ? ($validated['max_options'] ?? 1)
                    : 1,
                'min_options'     => in_array($validated['type'], ['select', 'checkbox', 'radio'])
                    ? ($validated['min_options'] ?? 0)
                    : 0,
                'selection_type'  => in_array($validated['type'], ['select', 'checkbox', 'radio'])
                    ? ($validated['selection_type'] ?? 'single')
                    : 'single',
                'sort_order'      => $nextSortOrder,
                'is_active'       => 1,
            ]);

            return redirect()
                ->back()
                ->with('success', 'Campo de personalización agregado correctamente.');
        }

        if ($accion === 'guardar_configuracion') {
            $product->update([
                'personalizable' => $request->boolean('personalizacion_activa'),
            ]);

            if (method_exists($product, 'extras')) {
                $extraIds = $request->boolean('enable_extras')
                    ? $request->input('extras', [])
                    : [];

                $product->extras()->sync($extraIds);
            }

            $sortBase = 1;

            // DEDICATORIA
            $dedicatoriaField = ProductCustomField::where('product_id', $product->id)
                ->where('type', 'textarea')
                ->where('label', 'Dedicatoria')
                ->first();

            if ($request->boolean('enable_dedicatoria')) {
                if ($dedicatoriaField) {
                    $dedicatoriaField->update([
                        'help_text'      => 'Escribe el mensaje que irá en la tarjeta.',
                        'is_required'    => $request->boolean('dedicatoria_required'),
                        'max_length'     => $request->input('dedicatoria_max', 120),
                        'selection_type' => 'single',
                        'max_options'    => 1,
                        'min_options'    => 0,
                        'sort_order'     => $sortBase,
                        'is_active'      => 1,
                    ]);
                } else {
                    ProductCustomField::create([
                        'product_id'      => $product->id,
                        'label'           => 'Dedicatoria',
                        'type'            => 'textarea',
                        'help_text'       => 'Escribe el mensaje que irá en la tarjeta.',
                        'is_required'     => $request->boolean('dedicatoria_required'),
                        'max_length'      => $request->input('dedicatoria_max', 120),
                        'selection_type'  => 'single',
                        'max_options'     => 1,
                        'min_options'     => 0,
                        'sort_order'      => $sortBase,
                        'is_active'       => 1,
                    ]);
                }

                $sortBase++;
            } elseif ($dedicatoriaField) {
                ProductCustomFieldOption::where('field_id', $dedicatoriaField->id)->delete();
                $dedicatoriaField->delete();
            }

            // FOTO
            $fotoField = ProductCustomField::where('product_id', $product->id)
                ->where('type', 'image')
                ->where('label', 'Foto del cliente')
                ->first();

            if ($request->boolean('enable_foto')) {
                if ($fotoField) {
                    $fotoField->update([
                        'help_text'      => 'Sube una foto clara para colocar en el arreglo.',
                        'is_required'    => $request->boolean('foto_required'),
                        'max_length'     => null,
                        'selection_type' => 'single',
                        'max_options'    => 1,
                        'min_options'    => 0,
                        'sort_order'     => $sortBase,
                        'is_active'      => 1,
                    ]);
                } else {
                    ProductCustomField::create([
                        'product_id'      => $product->id,
                        'label'           => 'Foto del cliente',
                        'type'            => 'image',
                        'help_text'       => 'Sube una foto clara para colocar en el arreglo.',
                        'is_required'     => $request->boolean('foto_required'),
                        'max_length'      => null,
                        'selection_type'  => 'single',
                        'max_options'     => 1,
                        'min_options'     => 0,
                        'sort_order'      => $sortBase,
                        'is_active'       => 1,
                    ]);
                }

                $sortBase++;
            } elseif ($fotoField) {
                ProductCustomFieldOption::where('field_id', $fotoField->id)->delete();
                $fotoField->delete();
            }

            // COLOR
            $colorField = ProductCustomField::where('product_id', $product->id)
                ->whereIn('type', ['radio', 'select'])
                ->where('label', 'Color')
                ->first();

            if ($request->boolean('enable_color')) {
                if ($colorField) {
                    $colorField->update([
                        'help_text'      => 'Selecciona el color disponible para este arreglo.',
                        'is_required'    => false,
                        'max_length'     => null,
                        'selection_type' => 'single',
                        'max_options'    => 1,
                        'min_options'    => 0,
                        'sort_order'     => $sortBase,
                        'is_active'      => 1,
                        'type'           => 'radio',
                    ]);
                } else {
                    $colorField = ProductCustomField::create([
                        'product_id'      => $product->id,
                        'label'           => 'Color',
                        'type'            => 'radio',
                        'help_text'       => 'Selecciona el color disponible para este arreglo.',
                        'is_required'     => false,
                        'max_length'      => null,
                        'selection_type'  => 'single',
                        'max_options'     => 1,
                        'min_options'     => 0,
                        'sort_order'      => $sortBase,
                        'is_active'       => 1,
                    ]);
                }

                ProductCustomFieldOption::where('field_id', $colorField->id)->delete();

                if (method_exists($product, 'colors')) {
                    $product->load('colors');

                    foreach ($product->colors as $index => $color) {
                        ProductCustomFieldOption::create([
                            'field_id'           => $colorField->id,
                            'label'              => $color->nombre ?? ('Color ' . ($index + 1)),
                            'extra_price'        => 0,
                            'stock'              => 0,
                            'controls_inventory' => false,
                            'sort_order'         => $index + 1,
                            'is_active'          => true,
                        ]);
                    }
                }

                $sortBase++;
            } elseif ($colorField) {
                ProductCustomFieldOption::where('field_id', $colorField->id)->delete();
                $colorField->delete();
            }

            return redirect()
                ->back()
                ->with('success', 'Configuración de personalización guardada correctamente.');
        }

        return redirect()
            ->back()
            ->with('error', 'No se pudo procesar la solicitud.');
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - AGREGAR OPCIÓN A UN CAMPO
    |--------------------------------------------------------------------------
    */
    public function storeFieldOption(Request $request, Product $product, ProductCustomField $field)
    {
        if ($field->product_id !== $product->id) {
            abort(404);
        }

        if (!in_array($field->type, ['select', 'checkbox', 'radio'])) {
            return redirect()
                ->back()
                ->with('error', 'Este campo no permite registrar opciones.');
        }

        $validated = $request->validate([
            'option_label'              => 'required|string|max:255',
            'option_extra_price'        => 'nullable|numeric|min:0',
            'option_stock'              => 'nullable|integer|min:0',
            'option_controls_inventory' => 'nullable|boolean',
        ]);

        $controlsInventory = $request->boolean('option_controls_inventory');

        $nextSortOrder = ProductCustomFieldOption::where('field_id', $field->id)->max('sort_order');
        $nextSortOrder = is_null($nextSortOrder) ? 1 : $nextSortOrder + 1;

        ProductCustomFieldOption::create([
            'field_id'           => $field->id,
            'label'              => $validated['option_label'],
            'extra_price'        => $validated['option_extra_price'] ?? 0,
            'stock'              => $controlsInventory ? ($validated['option_stock'] ?? 0) : 0,
            'controls_inventory' => $controlsInventory,
            'sort_order'         => $nextSortOrder,
            'is_active'          => true,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Opción agregada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - ELIMINAR OPCIÓN DE UN CAMPO
    |--------------------------------------------------------------------------
    */
    public function destroyFieldOption(Product $product, ProductCustomField $field, ProductCustomFieldOption $option)
    {
        if ($field->product_id !== $product->id) {
            abort(404);
        }

        if ($option->field_id !== $field->id) {
            abort(404);
        }

        $option->delete();

        return redirect()
            ->back()
            ->with('success', 'Opción eliminada correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - EDITAR CAMPO
    |--------------------------------------------------------------------------
    */
    public function editPersonalizationOption(Product $product, ProductCustomField $option)
    {
        if ($option->product_id !== $product->id) {
            abort(404);
        }

        return view('admin.products.personalization-edit-option', [
            'product' => $product,
            'field'   => $option,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - ACTUALIZAR CAMPO
    |--------------------------------------------------------------------------
    */
    public function updatePersonalizationOption(Request $request, Product $product, ProductCustomField $option)
    {
        if ($option->product_id !== $product->id) {
            abort(404);
        }

        $validated = $request->validate([
            'label'          => 'required|string|max:255',
            'type'           => 'required|in:text,textarea,select,checkbox,radio,image',
            'help_text'      => 'nullable|string|max:255',
            'max_length'     => 'nullable|integer|min:1',
            'selection_type' => 'nullable|in:single,multiple',
            'max_options'    => 'nullable|integer|min:1',
            'min_options'    => 'nullable|integer|min:0',
        ]);

        $option->update([
            'label'          => $validated['label'],
            'type'           => $validated['type'],
            'help_text'      => $validated['help_text'] ?? null,
            'is_required'    => $request->boolean('is_required'),
            'max_length'     => in_array($validated['type'], ['text', 'textarea'])
                ? ($validated['max_length'] ?? null)
                : null,
            'max_options'    => in_array($validated['type'], ['select', 'checkbox', 'radio'])
                ? ($validated['max_options'] ?? 1)
                : 1,
            'min_options'    => in_array($validated['type'], ['select', 'checkbox', 'radio'])
                ? ($validated['min_options'] ?? 0)
                : 0,
            'selection_type' => in_array($validated['type'], ['select', 'checkbox', 'radio'])
                ? ($validated['selection_type'] ?? 'single')
                : 'single',
            'is_active'      => 1,
        ]);

        return redirect()
            ->route('admin.products.personalization', $product->id)
            ->with('success', 'Campo actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | PERSONALIZACIÓN - ELIMINAR CAMPO
    |--------------------------------------------------------------------------
    */
    public function destroyPersonalizationOption(Product $product, ProductCustomField $option)
    {
        if ($option->product_id !== $product->id) {
            abort(404);
        }

        ProductCustomFieldOption::where('field_id', $option->id)->delete();
        $option->delete();

        return redirect()
            ->back()
            ->with('success', 'Campo eliminado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(Product $product)
    {
        if (!empty($product->imagen_principal) && Storage::disk('public')->exists($product->imagen_principal)) {
            Storage::disk('public')->delete($product->imagen_principal);
        }

        $fields = ProductCustomField::where('product_id', $product->id)->get();

        foreach ($fields as $field) {
            ProductCustomFieldOption::where('field_id', $field->id)->delete();
        }

        ProductCustomField::where('product_id', $product->id)->delete();

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
            Product::withTrashed()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | PLANTILLAS DE VISTA PREVIA
    |--------------------------------------------------------------------------
    */
    private function getPreviewTemplate(?string $template): array
    {
        $templates = [
            'bouquet_right' => [
                'photo_zone' => ['x' => 60, 'y' => 18, 'width' => 20, 'height' => 26],
                'card_zone' => ['x' => 22, 'y' => 76, 'width' => 34, 'height' => 14],
                'extras_zone' => ['x' => 8, 'y' => 10, 'width' => 84, 'height' => 45],
            ],
            'bouquet_left' => [
                'photo_zone' => ['x' => 20, 'y' => 18, 'width' => 20, 'height' => 26],
                'card_zone' => ['x' => 22, 'y' => 76, 'width' => 34, 'height' => 14],
                'extras_zone' => ['x' => 8, 'y' => 10, 'width' => 84, 'height' => 45],
            ],
            'balloon_top' => [
                'photo_zone' => ['x' => 30, 'y' => 25, 'width' => 22, 'height' => 28],
                'card_zone' => ['x' => 22, 'y' => 78, 'width' => 34, 'height' => 12],
                'extras_zone' => ['x' => 10, 'y' => 45, 'width' => 80, 'height' => 30],
            ],
            'heart_center' => [
                'photo_zone' => ['x' => 50, 'y' => 28, 'width' => 18, 'height' => 24],
                'card_zone' => ['x' => 20, 'y' => 80, 'width' => 32, 'height' => 10],
                'extras_zone' => ['x' => 10, 'y' => 10, 'width' => 80, 'height' => 35],
            ],
            'round_top' => [
                'photo_zone' => ['x' => 40, 'y' => 22, 'width' => 20, 'height' => 25],
                'card_zone' => ['x' => 25, 'y' => 78, 'width' => 30, 'height' => 12],
                'extras_zone' => ['x' => 10, 'y' => 10, 'width' => 80, 'height' => 40],
            ],
            'teddy_center' => [
                'photo_zone' => ['x' => 60, 'y' => 25, 'width' => 18, 'height' => 24],
                'card_zone' => ['x' => 22, 'y' => 78, 'width' => 34, 'height' => 12],
                'extras_zone' => ['x' => 8, 'y' => 10, 'width' => 50, 'height' => 45],
            ],
            'box_center' => [
                'photo_zone' => ['x' => 55, 'y' => 22, 'width' => 18, 'height' => 22],
                'card_zone' => ['x' => 25, 'y' => 78, 'width' => 30, 'height' => 12],
                'extras_zone' => ['x' => 10, 'y' => 12, 'width' => 80, 'height' => 45],
            ],
            'free_layout' => [
                'photo_zone' => ['x' => 50, 'y' => 25, 'width' => 20, 'height' => 25],
                'card_zone' => ['x' => 22, 'y' => 80, 'width' => 34, 'height' => 10],
                'extras_zone' => ['x' => 5, 'y' => 10, 'width' => 90, 'height' => 50],
            ],
        ];

        return $templates[$template] ?? $templates['free_layout'];
    }
}
