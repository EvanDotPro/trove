<?php
namespace Tv\App\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Helper\UrlHelper;
use Aura\Session\Session;

final class Redirect
{
    private $session;

    private $urlHelper;

    public function __construct(Session $session, UrlHelper $urlHelper)
    {
        $this->session = $session;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $code = $request->getAttribute('redirect_code', '302');

        if ($routeName = $request->getAttribute('redirect_route')) {
            $routeParams = [];
            $payload = $request->getParsedBody();
            $redirectParams = explode('|', $request->getAttribute('redirect_params', ''));
            foreach ($redirectParams as $param) {
                list($routeParam, $postParam) = explode(':', $param);
                $routeParams[$routeParam] = $payload[$postParam];
            }

            $path = $this->urlHelper->__invoke($routeName, $routeParams);
        } else {
            $path = $request->getAttribute('redirect_path', '/');
        }

        return $response
            ->withStatus($code)
            ->withHeader('Location', $path);
    }
}
