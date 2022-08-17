<?php

namespace App\Repositories\Emails;

use App\Models\Email;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function getEmails(array $sort = null, int $perPage = 60): LengthAwarePaginator
    {
        $query = Email::with('messages');

        if ($sort) {
            $column = array_key_first($sort);
            $query->orderBy(
                array_key_first($sort),
                $sort[$column]
            );
        }

        if (!$sort) {
            $query->orderBy('domain');
            $query->orderBy('name');
        }

        return $query->paginate($perPage);
    }
}
