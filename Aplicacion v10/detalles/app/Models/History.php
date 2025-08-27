<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'comentario',
        'estrellas',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'estrellas' => 'integer',
    ];

    /**
     * Scope for filtering by star rating
     */
    public function scopeByStars($query, $stars)
    {
        return $query->where('estrellas', $stars);
    }

    /**
     * Scope for getting high-rated histories (4+ stars)
     */
    public function scopeHighRated($query)
    {
        return $query->where('estrellas', '>=', 4);
    }

    /**
     * Get the star rating as a formatted string
     */
    public function getStarRatingAttribute()
    {
        return str_repeat('★', $this->estrellas) . str_repeat('☆', 5 - $this->estrellas);
    }

    /**
     * Validation rules
     */
    public static function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'comentario' => 'required|string',
            'estrellas' => 'required|integer|min:1|max:5',
        ];
    }
}
