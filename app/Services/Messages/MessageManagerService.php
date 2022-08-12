<?php

use App\Jobs\MessageCreatedJob;
use App\Models\Email;
use App\Models\Message;
use http\Exception\RuntimeException;
use Illuminate\Support\Facades\Http;

final class MessageManagerService
{
    public const HTTP_API_ICNDB_COM_JOKES_RANDOM = 'http://api.icndb.com/jokes/random';

    public function handle(Email $email): Message
    {
        try {
            $response = Http::get(self::HTTP_API_ICNDB_COM_JOKES_RANDOM);
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage());
        }

        $response = json_decode($response->body());

        $message = Message::create([
            'email_id' => $email->id,
            'value' => $response->value->joke
        ]);

        MessageCreatedJob::dispatch($email->value, $message->value);

        return $message;
    }
}
