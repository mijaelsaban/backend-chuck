<?php

namespace App\Services\Messages;

use App\Jobs\MessageCreatedJob;
use App\Models\Email;
use App\Models\Message;
use App\Repositories\Messages\MessageRepository;

final class MessageManagerService
{
    public function __construct(
        private ChuckNorrisJokesGateway $chuckNorrisJokesGateway,
        private MessageRepository $messageRepository
    ) {
        //
    }

    public function handle(Email $email): Message
    {
        $response = $this->chuckNorrisJokesGateway->request();
        $response = json_decode($response->body());
        $message = $this->messageRepository->create($email->id, $response->value->joke);

        MessageCreatedJob::dispatch($email->value, $message->value);

        return $message;
    }
}
