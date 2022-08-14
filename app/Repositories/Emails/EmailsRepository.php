<?php

namespace App\Repositories\Emails;

use App\Models\Email;

final class EmailsRepository
{
    public function create(string $email, string $name, string $domain): Email
    {
        return Email::create([
            'value' => $email,
            'name' => $name,
            'domain' => $domain,
        ]);
    }
}
