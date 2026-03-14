<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProductCustomization extends Model
{
    protected $fillable = [
        'order_product_id',
        'field_id',
        'option_id',
        'value_text',
        'extra_price'
    ];

    // Relación con order_products
    public function orderProduct()
    {
        return $this->belongsTo(OrderProduct::class, 'order_product_id');
    }

    // Relación con el campo configurado
    public function field()
    {
        return $this->belongsTo(ProductCustomField::class, 'field_id');
    }

    // Relación con la opción seleccionada
    public function option()
    {
        return $this->belongsTo(ProductCustomFieldOption::class, 'option_id');
    }
}
