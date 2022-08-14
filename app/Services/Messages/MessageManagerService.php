<?php

namespace App\Services\Messages;

use App\Jobs\MessageCreatedJob;
use App\Models\Email;
use App\Models\Message;
use App\Repositories\Messages\MessageRepository;

final class MessageManagerService
{
    public function __construct(
        private GatewayInterface $gateway,
        private MessageRepository $messageRepository
    ) {
        //
    }

    public function handle(Email $email): Message
    {
        $joke = $this->gateway->request()->getJoke();
        $message = $this->messageRepository->create($email->id, $joke);

        MessageCreatedJob::dispatch($email->value, $message->value);

        return $message;
    }
}
