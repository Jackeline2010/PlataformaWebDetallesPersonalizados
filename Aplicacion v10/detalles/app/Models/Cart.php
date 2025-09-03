<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'client_id',
        'product_id',
        'session_id',
        'cantidad',
        'precio_unitario',
        'descuento',
        'total',
        'personalizacion',
        'fecha_agregado',
        'fecha_expiracion',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
        'fecha_agregado' => 'datetime',
        'fecha_expiracion' => 'datetime',
        'personalizacion' => 'array',
    ];

    /**
     * Relationship with Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate total for this cart item
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

    /**
     * Scope for getting cart items by session or user
     */
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get cart items with products for current session/user
     */
    public static function getCartItems($userId = null, $sessionId = null)
    {
        $query = self::with('product');
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }
        
        return $query->get();
    }

    /**
     * Calculate cart totals
     */
    public static function calculateCartTotals($userId = null, $sessionId = null)
    {
        $cartItems = self::getCartItems($userId, $sessionId);
        
        $subtotal = $cartItems->sum('total');
        $discount = $cartItems->sum(function ($item) {
            return ($item->precio_unitario * $item->cantidad) * ($item->descuento / 100);
        });
        
        // Fixed values for now - can be made dynamic later
        $shipping = 4.50;
        $tax = 0.00;
        
        $total = $subtotal + $shipping + $tax;
        
        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'items_count' => $cartItems->count(),
            'items' => $cartItems
        ];
    }
}
