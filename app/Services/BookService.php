<?php

namespace App\Services;
use App\Models\Book;

class BookService
{
    public static function getByID($id)
    {
        return Book::find($id);
    }

    public static function getAllJSON()
    {
        $books_url = env("APP_URL").env('BOOKS_JSON_URL');
        $booksJson = json_encode(json_decode(file_get_contents($books_url), true), JSON_UNESCAPED_UNICODE);
        return $booksJson;
    }

    public static function getCategoriesJSON()
    {
        $categories_url = env("APP_URL").env('BOOKS_CATEGORIES_URL');
        $categoriesJson = json_encode(json_decode(file_get_contents($categories_url), true), JSON_UNESCAPED_UNICODE);
        return $categoriesJson;
    }
}
