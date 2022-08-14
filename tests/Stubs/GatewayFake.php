<?php

namespace Tests\Stubs;

use App\Services\Messages\GatewayInterface;

final class GatewayFake implements GatewayInterface
{

    public function request()
    {
        return $this;
    }

    public function getJoke(): string
    {
        return 'this is a fake joke';
    }
}
