<?php

namespace App\Services;

use App\Services\CacheService;
use Gemini\Data\GenerationConfig;
use Gemini\Enums\ResponseMimeType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function generate(string $message)
    {
        $cacheName = CacheService::getOrCreate();
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

    public static function version(): void
    {
        $response = Gemini::models()->list();
        foreach ($response->models as $model) {
            echo $model->name;
        }
    }

    public function clearCache(): void
    {
        $books_url = env("APP_URL") . env('BOOKS_JSON_URL');
        $booksJson = file_get_contents($books_url);
        $dataHash = md5($booksJson);
        $laravelCacheKey = "gemini_cached_content_{$dataHash}";

        Cache::forget($laravelCacheKey);
        Log::info('Cleared Gemini cache');
    }

    /**
     * Liệt kê tất cả cached contents trên Gemini
     */
    public function listCachedContents()
    {
        try {
            $response = Gemini::cachedContents()->list();

            $contents = [];
            if (isset($response->cachedContents)) {
                foreach ($response->cachedContents as $content) {
                    $contents[] = [
                        'name' => $content->name,
                        'displayName' => $content->displayName ?? 'N/A',
                        'createTime' => $content->createTime ?? 'N/A',
                        'expireTime' => $content->expireTime ?? 'N/A',
                    ];
                }
            }

            return $contents;
            // return empty(Gemini::cachedContents()->list()->cachedContents[0]->name);
        } catch (\Exception $e) {
            Log::error('Cannot list cached contents: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy danh sách models có sẵn
     */
    public static function listModels(): array
    {
        try {
            $response = Gemini::models()->list();
            $models = [];

            foreach ($response->models as $model) {
                $models[] = [
                    'name' => $model->name,
                    'displayName' => $model->displayName ?? '',
                    'supportedGenerationMethods' => $model->supportedGenerationMethods ?? []
                ];
            }

            return $models;
        } catch (\Exception $e) {
            Log::error('Cannot list models: ' . $e->getMessage());
            return [];
        }
    }
}
