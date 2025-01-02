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
            if ($trash->type === 'anorganic') {
                $ratePerKg = 2000; // Rp 2.000 per kg
                $trash->earnings = $trash->weight * $ratePerKg;
            } else {
                $trash->earnings = 0;
            }
        });

        static::saved(function ($trash) {
            if ($trash->status === 'processed' && $trash->type === 'anorganic') {
                $user = $trash->collector;
                if ($user) {
                    $user->updateBalanceFromTrash($trash->weight, $trash->type);
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
