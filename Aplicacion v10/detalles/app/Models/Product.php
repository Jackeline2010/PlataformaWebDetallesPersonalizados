<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'descripcion_corta',
        'precio',
        'stock',
        'stock_minimo',
        'fingreso',
        'descuento',
        'imagen_principal',
        'imagenes_adicionales',
        'peso',
        'sku',
        'activo',
        'destacado',
        'personalizable',
        'opciones_personalizacion',
        'orden',
    ];

    protected $casts = [
        'fingreso' => 'date',
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
        'peso' => 'decimal:2',
        'activo' => 'boolean',
        'destacado' => 'boolean',
        'personalizable' => 'boolean',
        'imagenes_adicionales' => 'array',
        'opciones_personalizacion' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->nombre);
            }
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(Str::random(8));
            }
        });
    }

    /**
     * Relationship with categories (many-to-many)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_products');
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('destacado', true);
    }

    /**
     * Get the price with discount applied
     */
    public function getPriceWithDiscountAttribute()
    {
        return $this->precio - ($this->precio * $this->descuento / 100);
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Check if product needs restocking
     */
    public function needsRestocking()
    {
        return $this->stock <= $this->stock_minimo;
    }
}
