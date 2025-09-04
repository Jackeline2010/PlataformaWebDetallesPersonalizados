<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'client_id',
        'user_id',
        'forma_pago_id',
        'numero_orden',
        'fpedido',
        'fentrega',
        'estado',
        'subtotal',
        'impuesto',
        'descuento',
        'total',
        'direccion_entrega',
        'contacto_entrega',
        'telefono_contacto',
        'observaciones',
    ];

    protected $casts = [
        'fpedido' => 'date',
        'fentrega' => 'date',
        'subtotal' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relationship with Order Products
     */
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Relationship with Products through OrderProduct
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->withPivot('cantidad', 'precio_unitario', 'descuento', 'total')
                    ->withTimestamps();
    }

    /**
     * Get order status label
     */
    public function getEstadoLabelAttribute()
    {
        $estados = [
            'ING' => 'Ingresado',
            'PEN' => 'Pendiente',
            'PRO' => 'En Proceso',
            'COM' => 'Completado',
            'CAN' => 'Cancelado'
        ];

        return $estados[$this->estado] ?? 'Desconocido';
    }

    /**
     * Scope for getting orders by user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Calculate order totals
     */
    public function calculateTotals()
    {
        $orderProducts = $this->orderProducts;
        
        $subtotal = $orderProducts->sum('total');
        $descuento = $orderProducts->sum(function ($item) {
            return ($item->precio_unitario * $item->cantidad) * ($item->descuento / 100);
        });
        
        $this->subtotal = $subtotal;
        $this->descuento = $descuento;
        $this->total = $subtotal + $this->impuesto;
        
        return $this;
    }
}
