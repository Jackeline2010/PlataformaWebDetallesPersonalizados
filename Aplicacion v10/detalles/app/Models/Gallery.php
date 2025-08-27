<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'foto',
        'activo',
        'orden',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Scope for active gallery items
     */
    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope for ordering gallery items
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('orden', 'asc');
    }

    /**
     * Scope for active and ordered gallery items
     */
    public function scopeActiveOrdered($query)
    {
        return $query->active()->ordered();
    }

    /**
     * Get the full photo URL
     */
    public function getPhotoUrlAttribute()
    {
        return asset('assets/photos/' . $this->foto);
    }

    /**
     * Validation rules
     */
    public static function rules()
    {
        return [
            'foto' => 'required|string|max:255',
            'activo' => 'boolean',
            'orden' => 'integer|min:0',
        ];
    }
}
