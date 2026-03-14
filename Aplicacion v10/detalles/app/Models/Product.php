<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id', // categoría principal: tipo_producto
        'imagen_principal',
        'nombre',
        'slug',
        'descripcion',
        'descripcion_corta',
        'precio',
        'stock',
        'stock_minimo',
        'fingreso',
        'descuento',
        'peso',
        'sku',
        'activo',
        'destacado',
        'personalizable',
        'opciones_personalizacion',
        'orden',
    ];

    protected $casts = [
        'fingreso'                  => 'date',
        'precio'                    => 'decimal:2',
        'descuento'                 => 'decimal:2',
        'peso'                      => 'decimal:2',
        'activo'                    => 'boolean',
        'destacado'                 => 'boolean',
        'personalizable'            => 'boolean',
        'opciones_personalizacion'  => 'array',
        'orden'                     => 'integer',
        'stock'                     => 'integer',
        'stock_minimo'              => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            // Generar slug único si no viene informado
            if (empty($product->slug) && !empty($product->nombre)) {
                $baseSlug = Str::slug($product->nombre);
                $slug = $baseSlug;
                $i = 2;

                while (static::withTrashed()->where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $i;
                    $i++;
                }

                $product->slug = $slug;
            }

            // Generar SKU único si no viene informado
            if (empty($product->sku)) {
                do {
                    $sku = 'SD-' . Str::upper(Str::random(8));
                } while (static::withTrashed()->where('sku', $sku)->exists());

                $product->sku = $sku;
            }

            // Valores por defecto
            if ($product->activo === null) {
                $product->activo = true;
            }

            if ($product->personalizable === null) {
                $product->personalizable = false;
            }

            if ($product->stock === null) {
                $product->stock = 0;
            }

            if (empty($product->fingreso)) {
                $product->fingreso = now()->toDateString();
            }
        });
    }

    /**
     * Genera un SKU único incluyendo registros soft deleted.
     */
    public static function generateUniqueSku(): string
    {
        do {
            $sku = 'SD-' . Str::upper(Str::random(8));
        } while (static::withTrashed()->where('sku', $sku)->exists());

        return $sku;
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Categoría principal del producto.
     * Debe corresponder al grupo: tipo_producto.
     */
    public function principalCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Alias útil de principalCategory().
     */
    public function category()
    {
        return $this->principalCategory();
    }

    /**
     * Campos de personalización configurables del producto.
     */
    public function customFields()
    {
        return $this->hasMany(ProductCustomField::class, 'product_id')
                    ->orderBy('sort_order');
    }

    /**
     * Categorías secundarias relacionadas al producto
     * (por ejemplo: ocasión especial).
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'categories_products',
            'product_id',
            'category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('destacado', true);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS / HELPERS
    |--------------------------------------------------------------------------
    */

    public function getPriceWithDiscountAttribute()
    {
        $descuento = (float) ($this->descuento ?? 0);
        $precio = (float) ($this->precio ?? 0);

        return $precio - ($precio * $descuento / 100);
    }

    public function isInStock(): bool
    {
        return (int) ($this->stock ?? 0) > 0;
    }

    public function needsRestocking(): bool
    {
        return (int) ($this->stock ?? 0) <= (int) ($this->stock_minimo ?? 0);
    }
}
