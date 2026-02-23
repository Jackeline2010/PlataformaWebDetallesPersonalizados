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
        'category_id', // categoría principal (solo tipo_producto)
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
        'fingreso' => 'date',
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
        'peso' => 'decimal:2',
        'activo' => 'boolean',
        'destacado' => 'boolean',
        'personalizable' => 'boolean',
        'opciones_personalizacion' => 'array',
        'orden' => 'integer',
        'stock' => 'integer',
        'stock_minimo' => 'integer',
    ];

   protected static function booted()
{
    static::creating(function (Product $product) {

        // Slug único (incluye soft-deletes)
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

        // SKU automático + ÚNICO (incluye soft-deletes)
        if (empty($product->sku)) {
            do {
                $sku = 'SD-' . Str::upper(Str::random(8));
            } while (static::withTrashed()->where('sku', $sku)->exists());

            $product->sku = $sku;
        }

        // Defaults útiles
        if ($product->activo === null) $product->activo = true;
        if ($product->personalizable === null) $product->personalizable = false;
        if ($product->stock === null) $product->stock = 0;
        if (empty($product->fingreso)) $product->fingreso = now()->toDateString();
    });
}

    /**
     * Genera un SKU único (incluye soft deletes).
     */
    public static function generateUniqueSku(): string
    {
        do {
            // Mantengo tu estilo pero con tu prefijo de marca
            $sku = 'SD-' . Str::upper(Str::random(8));
        } while (static::withTrashed()->where('sku', $sku)->exists());

        return $sku;
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Categoría principal (products.category_id -> categories.id)
    public function principalCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Alias útil
    public function category()
    {
        return $this->principalCategory();
    }

    /**
     * Categorías/Filtros (many-to-many)
     *
     * ⚠️ MUY IMPORTANTE:
     * Confirma el nombre REAL de tu tabla pivote.
     * Si tu tabla se llama "categories_products" déjalo así.
     * Si se llama "categorias_products" cambia el nombre abajo.
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'categories_products', // <-- cambia a 'categorias_products' si tu tabla se llama así
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
