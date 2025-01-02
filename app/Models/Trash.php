<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'user_id',
        'type',
        'weight',
        'collection_date',
        'status',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($trash) {
            $ratePerKg = 2000; // Rp 2.000 per kg
            $trash->earnings = $trash->weight * $ratePerKg;
        });

        static::saved(function ($trash) {
            if ($trash->status === 'processed') {
                $user = $trash->collector;
                if ($user) {
                    $user->updateBalanceFromTrash($trash->weight);
                }
            }
        });
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
