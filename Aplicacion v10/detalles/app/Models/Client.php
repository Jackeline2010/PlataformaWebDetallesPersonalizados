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
        'user_id',
        'identificacion',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'direccion',
        'fnacimiento',
        'genero',
        'fingreso',
        'activo',
    ];

    protected $casts = [
        'fnacimiento' => 'date',
        'activo' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute()
    {
        $first = $this->nombres ?? $this->nombre ?? '';
        $last  = $this->apellidos ?? $this->apellido ?? '';

        return trim($first . ' ' . $last);
    }

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
