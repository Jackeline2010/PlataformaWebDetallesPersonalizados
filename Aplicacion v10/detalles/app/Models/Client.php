<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'provincia',
        'codigo_postal',
        'fecha_nacimiento',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Relationship with Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    /**
     * Scope for active clients
     */
    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }
}
