<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Message;
use App\Services\Emails\EmailSplitterService;
use Illuminate\Http\Request;

final class EmailsController extends Controller
{
    public function __construct(
        public EmailSplitterService $emailSplitterService
    ) {}

    public function index(Request $request)
    {
        //todo: sort here to frontend
        $query = Email::orderByDesc('id');

        return $query->paginate(60);
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request) {

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
        //call to api
        $message = Message::create([
           'email_id' => $email->id,
            'value' => 'this is a joke'
        ]);

        return [
            'message' => $message
        ];
    }
}
