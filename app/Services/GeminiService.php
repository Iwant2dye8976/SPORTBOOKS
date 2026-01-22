<?php

namespace App\Services;

use Gemini\Enums\ModelVariation;
use Gemini\GeminiHelper;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Data\GoogleSearch;
use Gemini\Data\Tool;
use Gemini\Data\UrlContext;
use Gemini\Enums\ResponseMimeType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Http;

class GeminiService
{
    public function generate(string $message)
    {
        // $books_url = env('BOOKS_JSON_URL');

        // try {
        //     $booksJson = file_get_contents($books_url);

        //     $result = Gemini::generativeModel(
        //         model: GeminiHelper::generateGeminiModel(
        //             variation: ModelVariation::FLASH,
        //             generation: 3,
        //             version: "preview"
        //         ),
        //     )
        //         ->withSystemInstruction()
        //         ->withGenerationConfig(
        //             new GenerationConfig(
        //                 responseMimeType: ResponseMimeType::APPLICATION_JSON
        //             )
        //         )
        //         ->generateContent([
        //             'Dựa trên dữ liệu sách bên dưới, gợi ý 3 cuốn phù hợp với: "' . $message . '"',
        //             new Blob(
        //                 mimeType: MimeType::APPLICATION_JSON,
        //                 data: base64_encode($booksJson)
        //             )
        //         ]);

        //     return $result->json();
        // } catch (\Exception $e) {
        //     \Log::error('Gemini error: ' . $e->getMessage());
        //     return ['error' => $e->getMessage()];
        // }
        $response = Gemini::cachedContents()->list(pageSize: 10);
        // $cachedContent = Gemini::cachedContents()->retrieve('books_cache');
        if (empty($response->cachedContents)) {
            $this->cacheContent('gemini-3-flash-preview');
        }
            $cacheName = $response->cachedContents[0]->name;
            $result = Gemini::generativeModel(model: 'gemini-3-flash-preview')
                ->withCachedContent($cacheName)
                ->withGenerationConfig(
                    new GenerationConfig(
                        responseMimeType: ResponseMimeType::APPLICATION_JSON
                    )
                )
                ->generateContent([
                    '"Từ dữ liệu trong URL, hãy gợi ý 3 sách phù hợp với yêu cầu, chú ý đúng thể loại: "' . $message . '"'
                ]);
            return $result->json();
    }

    public function cacheContent($model, $duration = 3600)
    {
        $books_url = env('BOOKS_JSON_URL');
        $booksJson = json_encode(json_decode(file_get_contents($books_url), true), JSON_UNESCAPED_UNICODE);
        $cachedContent = Gemini::cachedContents()->create(
            name: 'books_cache',
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
            ttl: $duration.'s', // Cache for 1 hour
            displayName: 'Books Cache'
        );
        return $cachedContent;
    }

    public static function version(): void
    {
        $response = Gemini::models()->list();
        foreach ($response->models as $model) {
            echo $model->name;
        }
    }
}
