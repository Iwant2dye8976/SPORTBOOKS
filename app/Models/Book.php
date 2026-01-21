<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'category', 'description', 'stock', 'discount', 'origin_price', 'final_price', 'image_url'];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function bookreviews()
    {
        return $this->hasMany(BookReviews::class);
    }

    public function avgRating(): float
    {
        return round(
            $this->bookreviews()
                ->where('verified_purchase', true)
                ->avg('rating') ?? 0,1
        );
    }

    protected static function booted()
    {
        static::saving(function ($book) {
            if ($book->discount && $book->discount > 0) {
                $book->final_price = $book->origin_price * (100 - $book->discount) / 100;
            } else {
                $book->final_price = $book->origin_price;
            }
        });
    }
}
