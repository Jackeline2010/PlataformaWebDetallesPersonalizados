<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'cantidad',
        'precio_unitario',
        'descuento',
        'total',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Relationship with Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate total for this order product
     */
    public function calculateTotal()
    {
        $subtotal = $this->precio_unitario * $this->cantidad;
        $discount_amount = $subtotal * ($this->descuento / 100);
        return $subtotal - $discount_amount;
    }

    /**
     * Update the total field
     */
    public function updateTotal()
    {
        $this->total = $this->calculateTotal();
        $this->save();
        return $this->total;
    }
}
