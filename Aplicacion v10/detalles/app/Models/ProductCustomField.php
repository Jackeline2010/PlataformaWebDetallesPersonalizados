<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomField extends Model
{
    protected $fillable = [
        'product_id',
        'label',
        'type',
        'is_required',
        'max_length',
        'help_text',   // ← solo una vez
        'sort_order',
        'is_active'
    ];

    // Relación con Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relación con opciones
    public function options()
    {
        return $this->hasMany(\App\Models\ProductCustomFieldOption::class, 'field_id')
                    ->orderBy('sort_order');
    }
}
