<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'book_id',
        'action',
        'weight',
        'session_id',
        'source',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];
}
