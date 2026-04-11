<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomFieldOption extends Model
{
    protected $table = 'product_custom_field_options';

    protected $fillable = [
        'field_id',
        'label',
        'image_thumb',
        'image_preview',
        'extra_price',
        'controls_inventory',
        'stock',
        'preview_x',
        'preview_y',
        'preview_width',
        'preview_height',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'extra_price'        => 'decimal:2',
        'controls_inventory' => 'boolean',
        'is_active'          => 'boolean',
        'stock'              => 'integer',
        'preview_x'          => 'decimal:2',
        'preview_y'          => 'decimal:2',
        'preview_width'      => 'decimal:2',
        'preview_height'     => 'decimal:2',
        'sort_order'         => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Campo de personalización al que pertenece la opción
     */
    public function field()
    {
        return $this->belongsTo(ProductCustomField::class, 'field_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica si la opción tiene precio adicional
     */
    public function hasExtraPrice(): bool
    {
        return (float) $this->extra_price > 0;
    }

    /**
     * Verifica si controla inventario
     */
    public function controlsStock(): bool
    {
        return $this->controls_inventory === true;
    }

    /**
     * Verifica si hay stock disponible
     */
    public function inStock(): bool
    {
        if (!$this->controls_inventory) {
            return true;
        }

        return (int) $this->stock > 0;
    }

    /**
     * Verifica si tiene miniatura para mostrar en selección
     */
    public function hasThumb(): bool
    {
        return !empty($this->image_thumb);
    }

    /**
     * Verifica si tiene imagen de vista previa
     */
    public function hasPreviewImage(): bool
    {
        return !empty($this->image_preview);
    }
}
