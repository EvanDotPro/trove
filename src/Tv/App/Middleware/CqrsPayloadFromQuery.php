<?php
namespace Tv\App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class CqrsPayloadFromQuery
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request->withAttribute('cqrs_payload', $request->getQueryParams()), $response);
    }
}
