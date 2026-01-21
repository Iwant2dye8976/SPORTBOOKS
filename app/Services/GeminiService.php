<?php

namespace App\Services;

use Gemini\Enums\ModelVariation;
use Gemini\GeminiHelper;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
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
        // $result = Gemini::generativeModel(model: 'gemini-3-flash-preview')->generateContent($message);
        // return  $result->text();
        $books_url = env('BOOKS_JSON_URL');
        $result = Gemini::generativeModel(
            model: GeminiHelper::generateGeminiModel(
                variation: ModelVariation::FLASH,
                generation: 3,
                version: "preview"
            ),
        )->withSystemInstruction(Content::parse('Bạn là trợ lý sách. Chỉ trả lời dựa trên dữ liệu trong URL được cung cấp. Trả về JSON hợp lệ. Không thêm chú thích hay giải thích gì khác.'))
        ->withGenerationConfig(new GenerationConfig(responseMimeType: ResponseMimeType::APPLICATION_JSON))
        ->withTool(new Tool(googleSearch: GoogleSearch::from()))
        ->generateContent('Dựa trên dữ liệu JSON từ URL này: ' . $books_url . ', hãy gợi ý 3 cuốn sách phù hợp với yêu cầu sau bằng định dạng JSON chỉ có id:
        "' . $message . '"');
        return $result->json();
    }

    public static function version(): void
    {
        $response = Gemini::models()->list();
        foreach ($response->models as $model) {
            echo $model->name;
        }
    }
}
