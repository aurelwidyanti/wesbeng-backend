<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'latitude',
        'longitude',
    ];

    /**
     * The available categories.
     *
     * @var array<int, string>
     */
    public static $categories = [
        'Sampah Bakar',       
        'Sampah Tidak Bakar',  
        'Sampah Daur Ulang',  
        'Sampah Besar'
    ];

    /**
     * Scope a query to only include locations of a given category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the coordinates as a string.
     *
     * @return string
     */
    public function getCoordinatesAttribute()
    {
        return "{$this->latitude}, {$this->longitude}";
    }
}
