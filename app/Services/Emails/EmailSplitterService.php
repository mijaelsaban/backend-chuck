<?php

namespace App\Services\Emails;

final class EmailSplitterService
{
    public function handle(string $email): array
    {
        $parts = explode('@',  $email);

        return [
            'name' => $parts[0],
            'domain' => $parts[1],
        ];
    }
}
