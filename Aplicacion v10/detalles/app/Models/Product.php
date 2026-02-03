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
        'category_id', // ✅ categoría principal
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

            // Slug único (incluye soft-deletes)
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->nombre);
                $slug = $baseSlug;
                $i = 2;

                while (static::withTrashed()->where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $i;
                    $i++;
                }

                $product->slug = $slug;
            }

            // SKU automático
            if (empty($product->sku)) {
                $product->sku = 'PROD-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {

            // si cambió el nombre y el slug está vacío o igual al viejo nombre,
            // puedes recalcular aquí si quieres (opcional).
            // Por ahora NO lo recalculo para no cambiar slugs existentes automáticamente.
        });
    }

    /**
     * Categoría principal (1 producto = 1 categoría principal)
     * Usa products.category_id
     */
    public function principalCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     *Categorías adicionales (many-to-many)
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
        $descuento = $this->descuento ?? 0;
        return $this->precio - ($this->precio * $descuento / 100);
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return ($this->stock ?? 0) > 0;
    }

    /**
     * Check if product needs restocking
     */
    public function needsRestocking()
    {
        return ($this->stock ?? 0) <= ($this->stock_minimo ?? 0);
    }
}
