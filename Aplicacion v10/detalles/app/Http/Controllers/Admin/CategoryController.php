<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $types = [
            'tipo_producto'   => 'Tipo de Producto',
            'ocasion'         => 'Ocasión Especial',
            'personalizacion' => 'Tipo de Personalización',
        ];

        $type = $request->get('type', 'tipo_producto');
        if (!array_key_exists($type, $types)) {
            $type = 'tipo_producto';
        }

        $search = $request->get('search');
        $dir    = $request->get('dir', 'asc');
        $dir    = in_array($dir, ['asc', 'desc'], true) ? $dir : 'asc';

        $categories = Category::query()
            ->where('grupo', $type)
            ->when($search, fn ($q) => $q->where('nombre', 'like', "%{$search}%"))
            ->orderBy('nombre', $dir)
            ->orderBy('orden', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact(
            'categories',
            'types',
            'type',
            'search',
            'dir'
        ));
    }

    public function store(Request $request)
    {
        //  Normaliza nombre para evitar duplicados por espacios
        $request->merge([
            'nombre' => trim((string) $request->input('nombre')),
        ]);

        $data = $request->validate([
            'grupo'  => ['required', Rule::in(['tipo_producto', 'ocasion', 'personalizacion'])],
            'nombre' => ['required', 'string', 'max:100'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->boolean('activo');

        //  Si ya existe la restaurar o actualiza y NO inserta
        $existing = Category::withTrashed()
            ->where('grupo', $data['grupo'])
            ->where('nombre', $data['nombre'])
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }

            $existing->activo = $data['activo'];
            $existing->save();

            return redirect()
         ->route('admin.categories.index', ['type' => $data['grupo']])
         ->with('success', 'Categoría guardada correctamente.');
         }

        // ✅ Orden incremental por grupo
        $maxOrden = Category::where('grupo', $data['grupo'])->max('orden');
        $data['orden'] = is_null($maxOrden) ? 1 : ((int) $maxOrden + 1);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index', ['type' => $data['grupo']])
            ->with('success', 'Categoría creada.');
    }

    public function update(Request $request, Category $category)
    {
        $request->merge([
            'nombre' => trim((string) $request->input('nombre')),
        ]);

        $grupo = $request->input('grupo', $category->grupo);

        $data = $request->validate([
            'grupo'  => ['required', Rule::in(['tipo_producto', 'ocasion', 'personalizacion'])],
            'nombre' => [
                'required', 'string', 'max:100',
                Rule::unique('categories', 'nombre')
                    ->ignore($category->id)
                    ->where(fn ($q) => $q->where('grupo', $grupo)),
            ],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre.unique' => 'Ya existe una categoría con ese nombre en este grupo.',
        ]);

        $data['activo'] = $request->boolean('activo');

        // ✅ Si cambió de grupo, mandarla al final del nuevo grupo
        if ($data['grupo'] !== $category->grupo) {
            $maxOrden = Category::where('grupo', $data['grupo'])->max('orden');
            $data['orden'] = is_null($maxOrden) ? 1 : ((int) $maxOrden + 1);
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index', ['type' => $data['grupo']])
            ->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $category)
    {
        $tab = $category->grupo ?? 'tipo_producto';

        $category->delete();

        return redirect()
            ->route('admin.categories.index', ['type' => $tab])
            ->with('success', 'Categoría eliminada.');
    }
}
