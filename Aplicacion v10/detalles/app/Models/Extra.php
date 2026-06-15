<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $table = 'extras';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'precio_adicional',
        'tipo',
        'activo',
        'sku',
        'stock',
        'stock_minimo',
        'inventory_id',
        'controla_stock',
        'sincroniza_precio',
    ];

        protected $casts = [
        'precio_adicional' => 'decimal:2',
        'activo' => 'boolean',
        'stock' => 'integer',
        'stock_minimo' => 'integer',
        'controla_stock' => 'boolean',
        'sincroniza_precio' => 'boolean',
]   ;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'extra_product')
            ->withPivot('is_active')
            ->withTimestamps();
    }
}
