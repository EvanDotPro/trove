<?php
namespace Tv\App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;
use EvantSource\DomainDispatcher;
use EvantSource\MessageSerializer;
use Ramsey\Uuid\Uuid;
use Tv\Auth\AuthService;

class CqrsMiddleware
{
    private $dispatcher;

    private $serializer;

    private $authService;

    public function __construct(
        DomainDispatcher $dispatcher,
        MessageSerializer $serializer,
        AuthService $authService
    )
    {
        $this->dispatcher = $dispatcher;
        $this->serializer = $serializer;
        $this->authService = $authService;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        if ($request->getMethod() === 'GET') return $this->get($request, $response, $next);
        if ($request->getMethod() === 'POST') return $this->post($request, $response, $next);
    }

    private function get(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $target = $request->getAttribute('cqrs_target');
        $payload = $request->getQueryParams();
        $dispatchee = $this->serializer->unserialize($target, $payload);
        $result = $this->dispatcher->dispatch($dispatchee);

        if ($view = $request->getAttribute('view')) {

            $viewData = [];
            $key = $request->getAttribute('cqrs_render_key', 'data');
            $viewData[$key] = $result;

            if ($layout = $request->getAttribute('cqrs_render_layout')) {
                $viewData['layout'] = $layout;
            }

            return $next($request->withAttribute('viewData', $viewData), $response);

        }

        return new JsonResponse($result);
    }

    private function post(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $payload = $request->getAttribute('cqrs_payload', []);

        $payload = \Zend\Stdlib\ArrayUtils::merge($payload, $request->getParsedBody());

        //if ($key = $request->getAttribute('cqrs_new_uuid_field')) {
        //    $payload[$key] = Uuid::uuid4()->toString();
        //}

        if ($key = $request->getAttribute('cqrs_current_user_uuid_field')) {
            $payload[$key] = $this->authService->getIdentity()->id;
        }

        $target = $request->getAttribute('cqrs_target');

        if (is_callable([$target, 'preprocessPayload'])) {
            $payload = $target::{'preprocessPayload'}($payload);
        }

        if ($fields = $request->getAttribute('cqrs_ignore_fields')) {
            $fields = explode('|', $request->getAttribute('cqrs_ignore_fields'));
            foreach ($fields as $field) {
                unset($payload[$field]);
            }
        }

        $dispatchee = $this->serializer->unserialize($target, $payload);

        $result = $this->dispatcher->dispatch($dispatchee);

        return $next($request, $response);
    }
}
