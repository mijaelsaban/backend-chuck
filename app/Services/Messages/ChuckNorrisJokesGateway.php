<?php

namespace App\Services\Messages;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class ChuckNorrisJokesGateway implements GatewayInterface
{
    public const HTTP_API_ICNDB_COM_JOKES_RANDOM = 'http://api.icndb.com/jokes/random';

    public function request(): Response
    {
        return Http::get(self::HTTP_API_ICNDB_COM_JOKES_RANDOM);
    }
}
