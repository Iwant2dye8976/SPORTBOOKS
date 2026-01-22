<?php

namespace App\Services;
use App\Models\Book;

class BookService
{
    public static function getByID($id)
    {
        return Book::find($id);
    }
}
