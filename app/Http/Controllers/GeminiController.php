<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;

class GeminiController extends Controller
{
    public function chat(Request $request)
    {
        $geminiService = new GeminiService();
        $request->validate([
            'message' => 'required|string',
        ]);

        // GeminiService::version();

        $reply = $geminiService->generate($request->input('message'));
        $books = [];

        foreach ($reply->books as $book) {
            $books[] = BookService::getByID($book->id);
        }


        return response()->json([
            'books' => $books,
        ]);
    }

    public function listCache()
    {
        $geminiService = new GeminiService();
        $caches = $geminiService->listCachedContents();
        return response()->json(['cached_contents' => $caches]);
    }
}
