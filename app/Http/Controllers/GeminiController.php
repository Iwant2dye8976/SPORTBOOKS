<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class GeminiController extends Controller
{
    public function index()
    {
        return view('user.gemini');
    }

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
            'data' => $books,
        ]);
    }
}
