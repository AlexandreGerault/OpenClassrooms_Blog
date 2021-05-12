<?php

namespace AGerault\Blog\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController extends BaseController
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('homepage.html.twig');
    }
}
