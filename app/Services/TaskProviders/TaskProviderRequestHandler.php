<?php

namespace App\Services\TaskProviders;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class TaskProviderRequestHandler
{
    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            // todo: log request

            return $handler($request, $options)->then(
                function (ResponseInterface $response) {
                    // todo: update log response and response status

                    return $response;
                }
            );
        };
    }
}
