<?php
namespace Tv\Channel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Router\RouteResult;
use Zend\Diactoros\Response\HtmlResponse;

class Controller
{
    public function __construct(TemplateRendererInterface $template, ServiceInterface $service)
    {
        $this->template = $template;
        $this->service = $service;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedRoute = $request->getAttribute(RouteResult::class, false)
                                ->getMatchedRouteName();

        switch ($matchedRoute) {
            case 'channel':
                return $this->indexAction($request, $response, $next);
                break;
            case 'channel/list':
                return $this->listAction($request, $response, $next);
                break;

        }
    }

    public function indexAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedParams = $request->getAttribute(RouteResult::class, false)
                                 ->getMatchedParams();

        $channel = $this->service->getChannelByUrl($matchedParams['channel']);

        if (!$channel) return new HtmlResponse($this->template->render('error::404'));

        return new HtmlResponse($this->template->render('channel::index', ['channel' => $channel]));
    }

    public function listAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $channels = $this->service->getFeaturedChannels();

        return new HtmlResponse($this->template->render('channel::list', ['channels' => $channels]));
    }
}
