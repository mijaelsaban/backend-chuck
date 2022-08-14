<?php

namespace App\Services\Messages;

interface GatewayInterface
{
    public function request();

    public function getJoke(): string;
}
