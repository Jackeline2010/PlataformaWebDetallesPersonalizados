<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomFieldOption extends Model
{
    protected $fillable = [
        'field_id',
        'label',
        'extra_price',
        'sort_order',
        'is_active'
    ];

    // Relación con el campo
    public function field()
    {
        return $this->belongsTo(ProductCustomField::class, 'field_id');
    }
}
