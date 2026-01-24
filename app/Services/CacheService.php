<?php

namespace App\Services;
use Gemini\Laravel\Facades\Gemini;
use Gemini\Data\Content;

class CacheService
{
    public static function cacheContent($model, $duration = 3600)
    {
        $books_url = env('BOOKS_JSON_URL');
        $booksJson = json_encode(json_decode(file_get_contents($books_url), true), JSON_UNESCAPED_UNICODE);
        $cached = Gemini::cachedContents()->create(
            model: $model,
            systemInstruction: Content::parse(
                'Bạn là trợ lý gợi ý sách. ' .
                    'Phân tích dữ liệu JSON được cung cấp và gợi ý sách phù hợp. ' .
                    'Trả về JSON: {"books": [{"id": "..."}, {"id": "..."}, {"id": "..."}]}'
            ),
            parts: [
                'Dữ liệu danh sách sách (JSON):',
                $booksJson
            ],
            ttl: $duration . 's', // Cache for 1 hour
            displayName: 'Books Cache'
        );
        return $cached->cachedContent->name;
    }

    public static function getOrCreate()
    {
        $response = Gemini::cachedContents()->list();
        $contents = [];
        if (isset($response->cachedContents)) {
            foreach ($response->cachedContents as $content) {
                $contents[] = [
                    'name' => $content->name,
                ];
            }
        }
        if ($contents === []) {
            return CacheService::cacheContent('gemini-3-flash-preview', 3600);
        } else {
            return $contents[0]['name'];
        }
    }
}
