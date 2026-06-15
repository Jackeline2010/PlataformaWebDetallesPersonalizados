<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExtraController extends Controller
{
    public function index()
    {
        $extras = Extra::orderByDesc('created_at')->paginate(10);

        return view('admin.extras.index', compact('extras'));
    }

    public function create()
    {
        return view('admin.extras.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'precio_adicional' => ['required', 'numeric', 'min:0'],

            'stock' => ['nullable', 'integer', 'min:0'],
            'stock_minimo' => ['nullable', 'integer', 'min:0'],
            'controla_stock' => ['nullable', 'boolean'],

            'activo' => ['nullable', 'boolean'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('extras', 'public');
        }

        $data['stock'] = $data['stock'] ?? 0;
        $data['stock_minimo'] = $data['stock_minimo'] ?? 0;
        $data['controla_stock'] = $request->has('controla_stock');
        $data['activo'] = $request->has('activo');

        $extra = Extra::create($data);

        $extra->update([
            'sku' => $this->generateSku($extra),
        ]);

        return redirect()
            ->route('admin.extras.index')
            ->with('success', 'Extra creado correctamente.');
    }

    public function edit(Extra $extra)
    {
        return view('admin.extras.edit', compact('extra'));
    }

    public function update(Request $request, Extra $extra)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'precio_adicional' => ['required', 'numeric', 'min:0'],

            'stock' => ['nullable', 'integer', 'min:0'],
            'stock_minimo' => ['nullable', 'integer', 'min:0'],
            'controla_stock' => ['nullable', 'boolean'],

            'activo' => ['nullable', 'boolean'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            if (!empty($extra->imagen) && Storage::disk('public')->exists($extra->imagen)) {
                Storage::disk('public')->delete($extra->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('extras', 'public');
        }

        $data['stock'] = $data['stock'] ?? 0;
        $data['stock_minimo'] = $data['stock_minimo'] ?? 0;
        $data['controla_stock'] = $request->has('controla_stock');
        $data['activo'] = $request->has('activo');

        $extra->update($data);

        if (empty($extra->sku)) {
            $extra->update([
                'sku' => $this->generateSku($extra),
            ]);
        }

        return redirect()
            ->route('admin.extras.index')
            ->with('success', 'Extra actualizado correctamente.');
    }

    public function destroy(Extra $extra)
    {
        if (method_exists($extra, 'products')) {
            $extra->products()->detach();
        }

        if (!empty($extra->imagen) && Storage::disk('public')->exists($extra->imagen)) {
            Storage::disk('public')->delete($extra->imagen);
        }

        $extra->delete();

        return redirect()
            ->route('admin.extras.index')
            ->with('success', 'Extra eliminado correctamente.');
    }

    private function generateSku(Extra $extra): string
    {
        $tipo = mb_strtolower($extra->tipo ?? '');

        $prefix = match (true) {
            str_contains($tipo, 'globo') => 'EXT-GLO',
            str_contains($tipo, 'peluche') => 'EXT-PEL',
            str_contains($tipo, 'chocolate') => 'EXT-CHO',
            str_contains($tipo, 'vino') => 'EXT-VIN',
            str_contains($tipo, 'dulce') => 'EXT-DUL',
            default => 'EXT-GEN',
        };

        return $prefix . '-' . str_pad((string) $extra->id, 4, '0', STR_PAD_LEFT);
    }
}
