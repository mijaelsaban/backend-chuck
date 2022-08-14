<?php

namespace App\Repositories\Messages;

use App\Models\Message;

final class MessageRepository
{
    public function create(int $emailId, string $joke): Message
    {
        return Message::create([
            'email_id' => $emailId,
            'value' => $joke
        ]);
    }
}
