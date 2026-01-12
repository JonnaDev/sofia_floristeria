<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    protected $fillable = [
        'flower_id',
        'user_id',
        'previous_stock',
        'added_quantity',
        'new_stock',
        'notes'
    ];

    // Relación con flower
    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }

    // Relación con user (quien hizo el restock)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
