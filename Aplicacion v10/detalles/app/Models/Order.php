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
        'promotion_id',
        'promotion_code',
        'discount_amount',
        'numero_orden',
        'fpedido',
        'fentrega',
        'estado',
        'tipo_entrega',
        'metodo_pago',
        'estado_pago',
        'fecha_pago_confirmado',
        'referencia_pago',
        'comprobante_pago',
        'costo_entrega',
        'subtotal',
        'impuesto',
        'descuento',
        'total',
        'direccion_entrega',
        'contacto_entrega',
        'telefono_contacto',
        'observaciones',
        'payment_provider',
        'payment_transaction_id',
        'payment_url',
        'payment_token',
        'payment_session_key',
        'payment_response',
    ];

    protected $casts = [
        'fpedido' => 'date',
        'fentrega' => 'date',
        'costo_entrega' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'impuesto' => 'decimal:2',
        'descuento' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'payment_response' => 'array',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function promotion()
    {
    return $this->belongsTo(Promotion::class);
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot(
                'cantidad',
                'precio_unitario',
                'descuento',
                'total',
                'preview_image'
            )
            ->withTimestamps();
    }

    public function getEstadoLabelAttribute()
    {
        $estados = [
            'ING' => 'Ingresado',
            'PEN' => 'Pendiente',
            'PAG' => 'Pagado',
            'PRO' => 'En Proceso',
            'COM' => 'Completado',
            'CAN' => 'Cancelado',
        ];

        return $estados[$this->estado] ?? 'Desconocido';
    }

    public function getEstadoPagoLabelAttribute()
    {
        $estados = [
            'PENDIENTE' => 'Pendiente',
            'PAGADO' => 'Pagado',
            'RECHAZADO' => 'Rechazado',
        ];

        return $estados[$this->estado_pago] ?? 'Pendiente';
    }

    public function getMetodoPagoLabelAttribute()
    {
        $metodos = [
            'transferencia' => 'Transferencia bancaria',
            'efectivo' => 'Pago en efectivo',
            'stripe' => 'Tarjeta con Stripe',
            'tarjeta_debito' => 'Tarjeta de débito',
        ];

        return $metodos[$this->metodo_pago] ?? 'No registrado';
    }

    public function getTipoEntregaLabelAttribute()
    {
        $tipos = [
            'domicilio' => 'Entrega a domicilio',
            'retiro_tienda' => 'Retiro en tienda física',
        ];

        return $tipos[$this->tipo_entrega] ?? 'No registrado';
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function calculateTotals()
    {
        $orderProducts = $this->orderProducts;

        $subtotal = $orderProducts->sum('total');

        $descuento = $orderProducts->sum(function ($item) {
            return ($item->precio_unitario * $item->cantidad) * ($item->descuento / 100);
        });

        $this->subtotal = $subtotal;
        $this->descuento = $descuento;
        $this->total = $subtotal + $this->impuesto - $descuento;

        return $this;
    }
}
