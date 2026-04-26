<?php

namespace App\Models;

use App\Models\ProductColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'imagen_principal',
        'nombre',
        'slug',
        'descripcion',
        'descripcion_corta',
        'precio',
        'photo_print_price',
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
        'tiene_variantes',
        'customization_zones',
        'tipo_arreglo',
        'plantilla_preview',

    ];

    protected $casts = [
        'fingreso'                 => 'date',
        'precio'                   => 'decimal:2',
        'photo_print_price'        => 'decimal:2',
        'descuento'                => 'decimal:2',
        'peso'                     => 'decimal:2',
        'activo'                   => 'boolean',
        'destacado'                => 'boolean',
        'personalizable'           => 'boolean',
        'opciones_personalizacion' => 'array',
        'orden'                    => 'integer',
        'stock'                    => 'integer',
        'stock_minimo'             => 'integer',
        'tiene_variantes'          => 'boolean',
        'customization_zones'      => 'array',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
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

            if (empty($product->sku)) {
                do {
                    $sku = 'SD-' . Str::upper(Str::random(8));
                } while (static::withTrashed()->where('sku', $sku)->exists());

                $product->sku = $sku;
            }

            if ($product->activo === null) {
                $product->activo = true;
            }

            if ($product->personalizable === null) {
                $product->personalizable = false;
            }

            if ($product->stock === null) {
                $product->stock = 0;
            }

            if ($product->stock_minimo === null) {
                $product->stock_minimo = 5;
            }

            if ($product->photo_print_price === null) {
                $product->photo_print_price = 0;
            }

            if (empty($product->fingreso)) {
                $product->fingreso = now()->toDateString();
            }
        });
    }

    public static function generateUniqueSku(): string
    {
        do {
            $sku = 'SD-' . Str::upper(Str::random(8));
        } while (static::withTrashed()->where('sku', $sku)->exists());

        return $sku;
    }

    public function principalCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function category()
    {
        return $this->principalCategory();
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id')
            ->orderBy('nombre');
    }

    public function customFields()
    {
        return $this->hasMany(ProductCustomField::class, 'product_id')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function extras()
    {
        return $this->belongsToMany(\App\Models\Extra::class, 'extra_product')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'categories_products',
            'product_id',
            'category_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('destacado', true);
    }

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
