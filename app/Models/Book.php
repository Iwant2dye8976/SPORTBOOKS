<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'category', 'description', 'price'];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
