<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

final class EmailsController extends Controller
{
    public function index(Request $request)
    {
        $query = Email::orderByDesc('name');

        return $query->paginate(60);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:emails.value|email'
        ]);

        Email::create([
            'value' => $request->get('email')
        ]);
    }
}
