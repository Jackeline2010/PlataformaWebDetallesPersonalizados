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
        $dir    = in_array($dir, ['asc', 'desc']) ? $dir : 'asc';

        $categories = Category::query()
            ->where('grupo', $type)
            ->when($search, function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            })
            // ✅ primero orden incremental, luego nombre como “desempate”
            ->orderBy('orden', 'asc')
            ->orderBy('nombre', $dir)
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact(
            'categories',
            'types',
            'type',
            'search'
        ));
    }

    public function store(Request $request)
    {
        $grupo = $request->input('grupo');

        $data = $request->validate([
            'grupo'  => ['required', Rule::in(['tipo_producto', 'ocasion', 'personalizacion'])],
            'nombre' => [
                'required', 'string', 'max:100',
                // ✅ mismo nombre permitido en otro grupo
                Rule::unique('categories', 'nombre')
                    ->where(fn ($q) => $q->where('grupo', $grupo)),
            ],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre.unique' => 'Ya existe una categoría con ese nombre en este grupo.',
        ]);

        $data['activo'] = $request->boolean('activo');

        // ✅ ORDEN incremental por grupo
        $maxOrden = Category::where('grupo', $data['grupo'])->max('orden');
        $data['orden'] = is_null($maxOrden) ? 1 : ((int) $maxOrden + 1);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index', ['type' => $data['grupo']])
            ->with('success', 'Categoría creada.');
    }

    public function update(Request $request, Category $category)
    {
        // grupo actual o el que venga (pero en tu vista lo mandas hidden, así que viene siempre)
        $grupo = $request->input('grupo', $category->grupo);

        $data = $request->validate([
            'grupo'  => ['nullable', Rule::in(['tipo_producto', 'ocasion', 'personalizacion'])],
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'nombre')
                    ->ignore($category->id)
                    ->where(fn ($q) => $q->where('grupo', $grupo)),
            ],
            'activo' => ['nullable', 'boolean'],
        ], [
            'nombre.unique' => 'Ya existe una categoría con ese nombre en este grupo.',
        ]);

        $data['activo'] = $request->boolean('activo');

        // Si no mandan grupo, no lo cambiamos
        if (empty($data['grupo'])) {
            unset($data['grupo']);
        }

        // ✅ Si cambió de grupo, lo mandamos al final del nuevo grupo (nuevo orden incremental)
        if (isset($data['grupo']) && $data['grupo'] !== $category->grupo) {
            $maxOrden = Category::where('grupo', $data['grupo'])->max('orden');
            $data['orden'] = is_null($maxOrden) ? 1 : ((int) $maxOrden + 1);
        }

        $category->update($data);

        $tab = $data['grupo'] ?? $category->grupo ?? 'tipo_producto';

        return redirect()
            ->route('admin.categories.index', ['type' => $tab])
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
