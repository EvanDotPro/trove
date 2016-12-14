<?php
namespace Tv\Channel\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router\RouteResult;
use Tv\Channel\Finder\ChannelFinder;
use Tv\Channel\Finder\VideoFinder;

class Manage
{
    public function __construct(TemplateRendererInterface $template, ChannelFinder $channelFinder, VideoFinder $videoFinder)
    {
        $this->template = $template;
        $this->channelFinder = $channelFinder;
        $this->videoFinder = $videoFinder;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedParams = $request->getAttribute(RouteResult::class)
                                 ->getMatchedParams();

        $channel = $this->channelFinder->findChannelByPath($matchedParams['channel']);

        $videoCount = $this->videoFinder->videoCountByChannel($channel->id);
        return new HtmlResponse($this->template->render('channel::manage', ['vidcount' => $videoCount]));
    }

}
