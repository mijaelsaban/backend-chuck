<?php

namespace App\Http\Controllers;

use App\Models\Email;

final class EmailMessagesController extends Controller
{
    public function show(Email $email)
    {
        return [
            'email' => $email->value,
            'name' => $email->name,
            'messages' => $email->messages,
        ];
    }
}
