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
        // ✅ Relación con usuario (si existe en tu tabla)
        'user_id',

        // ✅ Datos personales (soporta ambos nombres)
        'nombre',
        'apellido',
        'nombres',
        'apellidos',

        //Otros campos comunes que estás usando en la vista / controller
        'identificacion',
        'genero',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'provincia',
        'codigo_postal',
        'fnacimiento',
        'fingreso',
        'activo',
    ];

    protected $casts = [
        'fnacimiento' => 'date',
        'activo' => 'boolean',
    ];

    // Si tus orders tienen client_id, esto está bien.
    // Si tus orders usan user_id, dime y lo ajustamos.
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Nombre completo robusto (funciona con nombre/apellido o nombres/apellidos)
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
}
