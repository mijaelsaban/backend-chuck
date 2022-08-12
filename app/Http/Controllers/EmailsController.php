<?php

namespace App\Http\Controllers;

use App\Jobs\MessageCreatedJob;
use App\Models\Email;
use App\Models\Message;
use App\Services\Emails\EmailSplitterService;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

final class EmailsController extends Controller
{
    public function __construct(
        public EmailSplitterService $emailSplitterService
    )
    {
    }

    public function index(Request $request)
    {
        //todo: sort here to frontend
        $query = Email::orderByDesc('id');

        return $query->paginate(60);
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request)
    {

        //request class
        $this->validate($request, [
            'email' => [
                'required',
//                'unique:emails,value',
                'email',
                'string'
            ]
        ]);

        $emailSplitter = $this->emailSplitterService->handle(
            $request->get('email')
        );

        //repo maybe inside service?
        $email = Email::create([
            'value' => $request->get('email'),
            'name' => $emailSplitter['name'],
            'domain' => $emailSplitter['domain'],
        ]);

        return response()->json([
            'isSuccess' => true,
            'email' => $email
        ], 201);
    }

    public function update(Email $email, \MessageManagerService $messageManagerService)
    {
        try {
            $message = $messageManagerService->handle($email);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => __CLASS__ . ' ' . $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }

        return [
            'message' => $message
        ];
    }
}
