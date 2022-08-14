<?php

namespace App\Services\Messages;

use App\Jobs\MessageCreatedJob;
use App\Models\Email;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

final class MessageManagerService
{
    public const HTTP_API_ICNDB_COM_JOKES_RANDOM = 'http://api.icndb.com/jokes/random';

    public function handle(Email $email): Message
    {

        $response = Http::get(self::HTTP_API_ICNDB_COM_JOKES_RANDOM);
        $response = json_decode($response->body());
        $message = Message::create([
            'email_id' => $email->id,
            'value' => $response->value->joke
        ]);

        MessageCreatedJob::dispatch($email->value, $message->value);

        return $message;
    }
}
