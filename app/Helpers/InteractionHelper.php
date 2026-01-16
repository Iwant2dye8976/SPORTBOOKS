<?php
namespace App\Helpers;
use App\Models\Interaction;
use Illuminate\Support\Str;

class InteractionHelper
{
    public static function log(
        string $action,
        int $bookId,
        ?int $userId = null,
        array $properties = []
    ): void {
        Interaction::create([
            'event_id' => Str::uuid(),
            'user_id' => $userId,
            'book_id' => $bookId,
            'action' => $action,
            'weight' => config("reco.weights.$action", 1),
            'session_id' => session()->getId(),
            'source' => 'web',
            'properties' => $properties,
        ]);
    }
}
