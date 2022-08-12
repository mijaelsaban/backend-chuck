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

    public function update(Email $email)
    {
        try {
            $response = Http::get('http://api.icndb.com/jokes/random');
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage());
        }

        $response = json_decode($response->body());

        $message = Message::create([
            'email_id' => $email->id,
            'value' => $response->value->joke
        ]);

        MessageCreatedJob::dispatch($email->value, $message->value);

        return [
            'message' => $message
        ];
    }
}
