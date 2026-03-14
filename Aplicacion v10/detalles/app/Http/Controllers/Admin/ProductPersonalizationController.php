<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCustomField;
use App\Models\ProductCustomFieldOption;
use Illuminate\Http\Request;

class ProductPersonalizationController extends Controller
{
    public function index(Product $product)
    {
        $product->load(['customFields.options' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('admin.products.personalization', compact('product'));
    }

    public function storeField(Request $request, Product $product)
    {
        $data = $request->validate([
            'label'       => ['required', 'string', 'max:120'],
            'type'        => ['required', 'in:text,textarea,select'],
            'is_required' => ['nullable', 'boolean'],
            'max_length'  => ['nullable', 'integer', 'min:1', 'max:500'],
            'help_text'   => ['nullable', 'string', 'max:255'],
        ]);

        $data['product_id'] = $product->id;
        $data['is_required'] = (bool)($data['is_required'] ?? false);

        // max_length solo para type=text
        if ($data['type'] !== 'text') {
            $data['max_length'] = null;
        }

        // sort_order al final
        $data['sort_order'] = (int)(ProductCustomField::where('product_id', $product->id)->max('sort_order') ?? 0) + 1;

        ProductCustomField::create($data);

        return back()->with('success', 'Campo agregado correctamente.');
    }

    public function toggleField(ProductCustomField $field)
    {
        $field->is_active = !$field->is_active;
        $field->save();

        return back()->with('success', 'Estado del campo actualizado.');
    }

    public function destroyField(ProductCustomField $field)
    {
        // Recomendación: en producción suele ser mejor desactivar, no borrar.
        $field->delete();

        return back()->with('success', 'Campo eliminado.');
    }

    public function storeOption(Request $request, ProductCustomField $field)
    {
        if ($field->type !== 'select') {
            return back()->with('error', 'Solo los campos tipo selección (select) pueden tener opciones.');
        }

        $data = $request->validate([
            'label'       => ['required', 'string', 'max:120'],
            'extra_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['field_id'] = $field->id;
        $data['extra_price'] = (float)($data['extra_price'] ?? 0);

        $data['sort_order'] = (int)(ProductCustomFieldOption::where('field_id', $field->id)->max('sort_order') ?? 0) + 1;

        ProductCustomFieldOption::create($data);

        return back()->with('success', 'Opción agregada correctamente.');
    }

    public function destroyOption(ProductCustomFieldOption $option)
    {
        $option->delete();

        return back()->with('success', 'Opción eliminada.');
    }
}
