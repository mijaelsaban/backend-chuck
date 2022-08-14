<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Services\Emails\EmailSplitterService;
use App\Services\Messages\MessageManagerService;
use Illuminate\Http\Request;

final class EmailsController extends Controller
{
    public function __construct(public EmailSplitterService $emailSplitterService)
    {}

    public function index(Request $request)
    {
        $query = Email::query();

        if ($request->has('sort')) {
            $column = array_key_first($request->get('sort'));
            $query->orderBy(
                array_key_first($request->get('sort')),
                $request->get('sort')[$column]
            );
        }

        if (!$request->hasAny('sort')) {
            $query->orderByDesc('id');
        }

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

        return [
            'message' => $message
        ];
    }
}
