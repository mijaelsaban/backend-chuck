<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Http\Requests\Emails\IndexRequest;
use App\Http\Requests\Emails\EmailRequest;
use App\Models\Message;
use App\Repositories\Emails\EmailsRepository;
use App\Services\Emails\EmailSplitterService;
use App\Services\Messages\MessageManagerService;

final class EmailsController extends Controller
{
    public function __construct(public EmailSplitterService $emailSplitterService)
    {}

    public function index(IndexRequest $request, EmailsRepository $emailsRepository)
    {
        return $emailsRepository->getEmails($request->get('sort'));
    }

    /**
     * @throws \Exception
     */
    public function store(EmailRequest $request, EmailsRepository $emailsRepository)
    {
        $emailSplitter = $this->emailSplitterService->handle(
            $request->get('email')
        );

        $email = $emailsRepository->create(
            $request->get('email'),
            $emailSplitter['name'],
            $emailSplitter['domain']
        );

        return response()->json([
            'isSuccess' => true,
            'email' => [
                'value' => $email->value,
                'name' => $email->name,
                'domain' => $email->domain,
            ]
        ], 201);
    }

    public function update(
        Email $email,
        MessageManagerService $messageManagerService
    ) {
        try {
            $message = $messageManagerService->handle($email);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => __CLASS__ . ' ' . $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }

        /**
         * @var Message $message
         */
        return [
            'message' => $message
        ];
    }
}
