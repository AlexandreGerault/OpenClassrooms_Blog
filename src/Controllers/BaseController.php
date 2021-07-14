<?php

namespace AGerault\Blog\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

abstract class BaseController
{
    protected Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function render(string $template, ?array $variables = null): ResponseInterface
    {
        return new Response(200, [], $this->twig->render($template, $variables ?? []));
    }

    protected function redirect(string $path, ?int $code = 302): ResponseInterface
    {
        return new Response($code, ['location' => $path], 'Login success');
    }
}
