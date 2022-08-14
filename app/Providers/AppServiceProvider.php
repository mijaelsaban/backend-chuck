<?php

namespace App\Providers;

use App\Services\Messages\ChuckNorrisJokesGateway;
use App\Services\Messages\GatewayInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            GatewayInterface::class,
            ChuckNorrisJokesGateway::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
