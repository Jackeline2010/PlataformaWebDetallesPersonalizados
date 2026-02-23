<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'nombre',
        'grupo',        // tipo_producto | ocasion | personalizacion
        'descripcion',
        'imagen',
        'icono',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden'  => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Productos donde esta categoría es FILTRO
     * (ocasión o personalización)
     */
    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'categories_products',
            'category_id',
            'product_id'
        );
    }

    /**
     * Productos donde esta categoría es CATEGORÍA PRINCIPAL
     * (solo grupo = tipo_producto)
     */
    public function mainProducts()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES ÚTILES
    |--------------------------------------------------------------------------
    */

    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorGrupo($query, $grupo)
    {
        return $query->where('grupo', $grupo);
    }
}
