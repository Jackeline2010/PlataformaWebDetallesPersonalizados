<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCustomField extends Model
{
    protected $table = 'product_custom_fields';

    protected $fillable = [
        'product_id',
        'label',
        'type',
        'selection_type',
        'is_required',
        'min_options',
        'max_options',
        'max_length',
        'help_text',
        'sort_order',
        'is_active',
        'preview_type',
        'preview_target',
        'preview_x',
        'preview_y',
        'preview_width',
        'preview_height',
        'font_size',
        'text_color',
        'template_image',
        'mask_shape',
    ];

    protected $casts = [
        'is_required'    => 'boolean',
        'is_active'      => 'boolean',
        'min_options'    => 'integer',
        'max_options'    => 'integer',
        'sort_order'     => 'integer',
        'max_length'     => 'integer',
        'preview_x'      => 'integer',
        'preview_y'      => 'integer',
        'preview_width'  => 'integer',
        'preview_height' => 'integer',
        'font_size'      => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Producto al que pertenece el campo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Opciones del campo (radio, checkbox, select)
     */
    public function options()
    {
        return $this->hasMany(ProductCustomFieldOption::class, 'field_id')
            ->where('is_active', true)
            ->orderBy('sort_order');
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

    public function isText(): bool
    {
        return $this->type === 'text';
    }

    public function isTextarea(): bool
    {
        return $this->type === 'textarea';
    }

    public function isRadio(): bool
    {
        return $this->type === 'radio';
    }

    public function isCheckbox(): bool
    {
        return $this->type === 'checkbox';
    }

    public function isSelect(): bool
    {
        return $this->type === 'select';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isChoiceField(): bool
    {
        return in_array($this->type, ['select', 'checkbox', 'radio']);
    }

    public function usesPreview(): bool
    {
        return !empty($this->preview_type);
    }

    public function isTextPreview(): bool
    {
        return $this->preview_type === 'text_overlay';
    }

    public function isImagePreview(): bool
    {
        return $this->preview_type === 'image_overlay';
    }
}
