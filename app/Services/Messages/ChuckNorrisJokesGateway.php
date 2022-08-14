<?php

namespace App\Services\Messages;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class ChuckNorrisJokesGateway implements GatewayInterface
{
    public const HTTP_API_ICNDB_COM_JOKES_RANDOM = 'http://api.icndb.com/jokes/random';
    private mixed $response;

    public function request(): self
    {
        $response = Http::get(self::HTTP_API_ICNDB_COM_JOKES_RANDOM);
        $this->response = json_decode($response->body());

        return $this;
    }

    public function getJoke(): string
    {
        return $this->response->value->joke;
    }
}
