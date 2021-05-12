<?php

namespace AGerault\Blog\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class BaseController
{
    protected \Twig\Environment $twig;

    public function __construct(\Twig\Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function render(string $template, ?array $variables = null): ResponseInterface
    {
        return new Response(200, [], $this->twig->render($template, $variables ?? []));
    }
}