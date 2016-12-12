<?php
namespace Tv\Channel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Router\RouteResult;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Tv\Video\ServiceInterface as VideoServiceInterface;

class Controller
{
    public function __construct(TemplateRendererInterface $template, ServiceInterface $service, VideoServiceInterface $videoService)
    {
        $this->template = $template;
        $this->service = $service;
        $this->videoService = $videoService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedRoute = $request->getAttribute(RouteResult::class, false)
                                ->getMatchedRouteName();

        switch ($matchedRoute) {
            case 'ping':
                return $this->pingAction($request, $response, $next);
                break;
            case 'channel':
            case 'channel/videoid':
                return $this->indexAction($request, $response, $next);
                break;
            case 'channel/submit':
                return $this->submitAction($request, $response, $next);
                break;
            case 'channel/video':
                return $this->videoAction($request, $response, $next);
                break;

        }
    }

    public function videoAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedParams = $request->getAttribute(RouteResult::class, false)
                                 ->getMatchedParams();

        $channel = $this->service->getChannelByUrl($matchedParams['channel']);

        $videos = $this->videoService->getChannelVideos($channel['id'], 1);

        return new JsonResponse($videos[0]);
    }

    public function indexAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedParams = $request->getAttribute(RouteResult::class, false)
                                 ->getMatchedParams();

        $channel = $this->service->getChannelByUrl($matchedParams['channel']);

        if (!$channel) return new HtmlResponse($this->template->render('error::404'));

        $videos = $this->videoService->getChannelVideos($channel['id'], 5);

        $video = isset($matchedParams['video']) ? $matchedParams['video'] : false;

        return new HtmlResponse($this->template->render('channel::index', ['channel' => $channel, 'videos' => $videos, 'video' => $video]));
    }

    public function submitAction(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $matchedParams = $request->getAttribute(RouteResult::class, false)
                                 ->getMatchedParams();
        $channel = $this->service->getChannelByUrl($matchedParams['channel']);
        $viewData = ['channel' => $channel];



        if ($request->getMethod() === 'GET') {
            $url = $request->getQueryParams()['url'];
            if ($url) {
                parse_str( parse_url( $url, PHP_URL_QUERY ), $params );
                $videoID = $params['v'];
                $viewData['videoID'] = $videoID;
            }

            return new HtmlResponse($this->template->render('channel::submit', $viewData));
        }

        if ($request->getMethod() === 'POST') {
            $videoIDs = $request->getParsedBody()['videos'];
            $this->videoService->addVideosToChannel($channel['id'], $videoIDs);

            return $response
                ->withStatus(302)
                ->withHeader('Location', '/channels');
        }
    }
}
