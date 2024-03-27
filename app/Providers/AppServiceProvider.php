<?php

namespace App\Providers;

use App\Services\TaskProviders\TaskProviderRequestClient;
use App\Services\TaskProviders\TaskProviderRequestHandler;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(TaskProviderRequestClient::class, function () {
            $handler = new TaskProviderRequestHandler();
            $stack = HandlerStack::create(new CurlHandler());
            $stack->push($handler);

            return new TaskProviderRequestClient([
                'handler' => $stack,
            ]);
        });
    }
}
