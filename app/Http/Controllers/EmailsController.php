<?php

namespace App\Http\Controllers;

use App\Models\Email;
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
}
