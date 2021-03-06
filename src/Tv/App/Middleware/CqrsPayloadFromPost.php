<?php
namespace Tv\App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class CqrsPayloadFromPost
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $payload = $request->getParsedBody(); // $_POST

        unset($payload['__csrf_value']);
        unset($payload['g-recaptcha-response']);

        return $next($request->withAttribute('cqrs_payload', $payload), $response);
    }
}

