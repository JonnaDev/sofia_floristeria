<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    protected $fillable = ['name', 'price', 'description', 'photo_flower_url', 'stock'];
    protected $table = 'flowers';

        public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

        public function restocks()
    {
        return $this->hasMany(Restock::class);
    }

        public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}
