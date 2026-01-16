<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'comment',
        'verified_purchase',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'metadata' => 'array',
    ];

    // Người đánh giá
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Sách được đánh giá
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Chỉ lấy review đã mua hàng
    public function scopeVerified($query)
    {
        return $query->where('verified_purchase', true);
    }

    // Lấy review rating cao
    public function scopeHighRating($query, $min = 4)
    {
        return $query->where('rating', '>=', $min);
    }

    public function stars(): string
    {
        return str_repeat('★', $this->rating)
             . str_repeat('☆', 5 - $this->rating);
    }
}
