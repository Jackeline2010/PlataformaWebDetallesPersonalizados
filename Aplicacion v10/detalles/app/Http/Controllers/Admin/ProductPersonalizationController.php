<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Product;
use App\Models\ProductCustomField;
use App\Models\ProductCustomFieldOption;
use Illuminate\Http\Request;

class ProductPersonalizationController extends Controller
{
    public function index(Product $product)
{
    $product->load([
        'customFields' => function ($q) {
            $q->orderBy('sort_order');
        },
        'customFields.options' => function ($q) {
            $q->orderBy('sort_order');
        },
    ]);

    $fields = $product->customFields;
    $extras = Extra::where('activo', 1)->orderBy('nombre')->get();

    $selectedExtras = method_exists($product, 'extras')
        ? $product->extras()->pluck('extras.id')->toArray()
        : [];

    $dedicatoriaField = $fields->first(function ($field) {
        return in_array($field->type, ['text', 'textarea']) &&
               str_contains(strtolower($field->label), 'dedicatoria');
    });

    $fotoField = $fields->first(function ($field) {
        return $field->type === 'image' &&
               str_contains(strtolower($field->label), 'foto');
    });

    $colorField = $fields->first(function ($field) {
        return in_array($field->type, ['select', 'radio']) &&
               str_contains(strtolower($field->label), 'color');
    });

    $colors = method_exists($product, 'colors')
        ? $product->colors()->where('activo', 1)->orderBy('nombre')->get()
        : collect();

    return view('admin.products.personalization', compact(
        'product',
        'fields',
        'extras',
        'selectedExtras',
        'dedicatoriaField',
        'fotoField',
        'colorField',
        'colors'
    ));
}
    public function update(Request $request, Product $product)
    {
        $accion = $request->input('accion');

        if ($accion === 'agregar_campo') {
            return $this->storeField($request, $product);
        }

        return $this->saveConfiguration($request, $product);
    }

    protected function saveConfiguration(Request $request, Product $product)
    {
        $product->personalizable = $request->has('personalizacion_activa');
        $product->save();

        if ($request->has('extras')) {
            if (method_exists($product, 'extras')) {
                $product->extras()->sync($request->extras);
            }
        } else {
            if (method_exists($product, 'extras')) {
                $product->extras()->sync([]);
            }
        }

        return back()->with('success', 'Configuración de personalización actualizada correctamente.');
    }

    protected function storeField(Request $request, Product $product)
    {
        $data = $request->validate([
            'label'            => 'required|string|max:255',
            'type'             => 'required|in:text,textarea,select,checkbox,radio,image',
            'help_text'        => 'nullable|string|max:255',
            'is_required'      => 'nullable|boolean',
            'max_length'       => 'nullable|integer|min:1|max:500',
            'selection_type'   => 'nullable|in:single,multiple',

            'preview_type'     => 'nullable|in:text_overlay,image_overlay',
            'preview_target'   => 'nullable|string|max:100',
            'preview_x'        => 'nullable|integer|min:0',
            'preview_y'        => 'nullable|integer|min:0',
            'preview_width'    => 'nullable|integer|min:20|max:1000',
            'preview_height'   => 'nullable|integer|min:20|max:1000',
            'font_size'        => 'nullable|integer|min:8|max:72',
            'text_color'       => 'nullable|string|max:20',
            'template_image'   => 'nullable|string|max:255',
            'mask_shape'       => 'nullable|in:rectangle,rounded,circle',
        ]);

        $data['product_id'] = $product->id;
        $data['is_required'] = $request->has('is_required');
        $data['is_active'] = true;
        $data['sort_order'] = ((int) ProductCustomField::where('product_id', $product->id)->max('sort_order')) + 1;

        if (!in_array($data['type'], ['text', 'textarea'])) {
            $data['max_length'] = null;
        }

        if (!in_array($data['type'], ['select', 'checkbox', 'radio'])) {
            $data['selection_type'] = null;
        } else {
            if (empty($data['selection_type'])) {
                $data['selection_type'] = $data['type'] === 'checkbox' ? 'multiple' : 'single';
            }
        }

        if (empty($data['preview_type'])) {
            $data['preview_target'] = null;
            $data['preview_x'] = null;
            $data['preview_y'] = null;
            $data['preview_width'] = null;
            $data['preview_height'] = null;
            $data['font_size'] = null;
            $data['text_color'] = null;
            $data['template_image'] = null;
            $data['mask_shape'] = null;
        } else {
            if ($data['preview_type'] !== 'text_overlay') {
                $data['font_size'] = null;
                $data['text_color'] = null;
                $data['template_image'] = null;
            }

            if ($data['preview_type'] !== 'image_overlay') {
                $data['mask_shape'] = null;
            }

            if (($data['preview_target'] ?? null) !== 'custom') {
                $data['preview_x'] = null;
                $data['preview_y'] = null;
                $data['preview_width'] = null;
                $data['preview_height'] = null;
            }
        }

        ProductCustomField::create($data);

        return back()->with('success', 'Campo agregado correctamente.');
    }

    public function toggleField(ProductCustomField $field)
    {
        $field->is_active = !$field->is_active;
        $field->save();

        return back()->with('success', 'Estado del campo actualizado.');
    }

    public function destroyField(Product $product, ProductCustomField $field)
    {
        if ($field->product_id !== $product->id) {
            abort(404);
        }

        $field->delete();

        return back()->with('success', 'Campo eliminado.');
    }

    public function storeOption(Request $request, Product $product, ProductCustomField $field)
    {
        if ($field->product_id !== $product->id) {
            abort(404);
        }

        if (!in_array($field->type, ['select', 'checkbox', 'radio'])) {
            return back()->with('error', 'Solo los campos de selección pueden tener opciones.');
        }

        $data = $request->validate([
            'option_label'       => ['required', 'string', 'max:120'],
            'option_extra_price' => ['nullable', 'numeric', 'min:0'],
            'option_stock'       => ['nullable', 'integer', 'min:0'],
        ]);

        ProductCustomFieldOption::create([
            'field_id'            => $field->id,
            'label'               => $data['option_label'],
            'extra_price'         => (float) ($data['option_extra_price'] ?? 0),
            'stock'               => $data['option_stock'] ?? 0,
            'controls_inventory'  => !is_null($data['option_stock']),
            'sort_order'          => ((int) ProductCustomFieldOption::where('field_id', $field->id)->max('sort_order')) + 1,
        ]);

        return back()->with('success', 'Opción agregada correctamente.');
    }

    public function destroyOption(Product $product, ProductCustomField $field, ProductCustomFieldOption $option)
    {
        if ($field->product_id !== $product->id || $option->field_id !== $field->id) {
            abort(404);
        }

        $option->delete();

        return back()->with('success', 'Opción eliminada.');
    }
}
