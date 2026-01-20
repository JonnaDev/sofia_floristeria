<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'flower_id',
        'original_stock',
        'available_stock'
    ];

    protected $table = 'inventories';

    // Relación inverse one-to-one con flower, de "pertenece"
    public function flower()
    {
        return $this->belongsTo(Flower::class);
    }
}
