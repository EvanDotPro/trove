<?php
namespace Tv\Auth\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tv\Auth\Model\PasswordHash;

class VerifyCaptcha
{
    /**
     * PHP 7.1, make private constant.
     */
    private $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s';
    private $recaptchaSecret = '6Lf6lQ4UAAAAAH8GrhGjBE-U7od1x905hSF_-7Zl';

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $post = $request->getParsedBody();

        $captchaResponse = $post['g-recaptcha-response'] ?? 'null';

        $url = sprintf($this->recaptchaUrl, $this->recaptchaSecret, $captchaResponse, $_SERVER['REMOTE_ADDR']);

        $result = json_decode(file_get_contents($url), true);

        if ($result['success'] !== true) {
            throw new \Exception('Captcha failure.');
        }

        return $next($request, $response);
    }
}
