<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    protected $fillable = [
        'location_id', 
        'type', 
        'volume', 
        'weight', 
        'collection_date', 
        'status'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
