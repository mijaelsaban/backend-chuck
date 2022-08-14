<?php

namespace App\Services\Messages;

use App\Jobs\MessageCreatedJob;
use App\Models\Email;
use App\Models\Message;
use Illuminate\Support\Facades\Http;

final class MessageManagerService
{
    public function __construct(
        private ChuckNorrisJokesGateway $chuckNorrisJokesGateway,


    ) {
        //
    }

    public function handle(Email $email): Message
    {
        $response = $this->chuckNorrisJokesGateway->request();
        $response = json_decode($response->body());
        $message = Message::create([
            'email_id' => $email->id,
            'value' => $response->value->joke
        ]);

        MessageCreatedJob::dispatch($email->value, $message->value);

        return $message;
    }
}
