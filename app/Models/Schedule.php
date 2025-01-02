<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'location_id',
        'date',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
