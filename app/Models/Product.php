<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; 
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock',
    ];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }
}
