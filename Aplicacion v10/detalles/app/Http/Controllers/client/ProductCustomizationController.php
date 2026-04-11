<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductCustomizationController extends Controller
{
    public function edit(Product $product)
    {
        $product->load([
            'colors' => function ($query) {
                $query->where('activo', 1)
                    ->orderBy('nombre');
            },

            'customFields' => function ($query) {
                $query->where('is_active', 1)
                    ->orderBy('sort_order');
            },

            'customFields.options' => function ($query) {
                $query->orderBy('sort_order');
            },

            'extras' => function ($query) {
                $query->where('activo', 1)
                    ->orderBy('nombre');
            },
        ]);

        $fields = $product->customFields ?? collect();

        $dedicatoriaField = $fields->first(function ($field) {
            return in_array($field->type, ['text', 'textarea']) &&
                str_contains(mb_strtolower($field->label), 'dedicatoria');
        });

        $fotoField = $fields->first(function ($field) {
            return $field->type === 'image' &&
                str_contains(mb_strtolower($field->label), 'foto');
        });

        $colorField = $fields->first(function ($field) {
            return in_array($field->type, ['select', 'radio']) &&
                str_contains(mb_strtolower($field->label), 'color');
        });

        $customFields = $fields->filter(function ($field) use ($dedicatoriaField, $fotoField, $colorField) {
            return !in_array($field->id, array_filter([
                optional($dedicatoriaField)->id,
                optional($fotoField)->id,
                optional($colorField)->id,
            ]));
        })->values();

        $colors = $product->colors ?? collect();
        $extras = $product->extras ?? collect();

        return view('client.customization.editor', compact(
            'product',
            'dedicatoriaField',
            'fotoField',
            'colorField',
            'customFields',
            'colors',
            'extras'
        ));
    }
}
