<?php
namespace Tv\Channel\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Router\RouteResult;
use Tv\Channel\Finder\ChannelFinder;

final class PopulateChannelIdFromPath
{
    private $channelFinder;

    public function __construct(ChannelFinder $channelFinder)
    {
        $this->channelFinder = $channelFinder;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $matchedParams = $request->getAttribute(RouteResult::class, false)
                                 ->getMatchedParams();

        $target  = $request->getAttribute('channel_id_field', 'channelId');
        $payload = $request->getAttribute('cqrs_payload', []);

        $payload[$target] = $this->channelFinder->findChannelByPath($matchedParams['channel'])->id;

        return $next($request->withAttribute('cqrs_payload', $payload), $response);
    }
}
