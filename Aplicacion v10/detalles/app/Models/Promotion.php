<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'tipo',
        'valor',
        'compra_minima',
        'fecha_inicio',
        'fecha_fin',
        'limite_usos',
        'usos_actuales',
        'activo',
    ];

    public function estaVigente(): bool
    {
        $hoy = now()->toDateString();

        if (!$this->activo) {
            return false;
        }

        if ($this->fecha_inicio && $this->fecha_inicio > $hoy) {
            return false;
        }

        if ($this->fecha_fin && $this->fecha_fin < $hoy) {
            return false;
        }

        if ($this->limite_usos !== null && $this->usos_actuales >= $this->limite_usos) {
            return false;
        }

        return true;
    }

    public function calcularDescuento(float $subtotal): float
    {
        if (!$this->estaVigente()) {
            return 0;
        }

        if ($subtotal < $this->compra_minima) {
            return 0;
        }

        if ($this->tipo === 'porcentaje') {
            return round($subtotal * ($this->valor / 100), 2);
        }

        return min($this->valor, $subtotal);
    }
}
