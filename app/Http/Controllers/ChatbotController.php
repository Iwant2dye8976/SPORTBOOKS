<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatbotService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Book;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        return app(ChatbotService::class)
            ->handle($request->message, auth()->id());
    }
}
