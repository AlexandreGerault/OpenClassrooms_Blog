<?php

namespace AGerault\Blog\Controllers;

use AGerault\Framework\Contracts\Session\SessionInterface;
use GuzzleHttp\Psr7\Response;
use Twig\Environment;

class Logout extends BaseController
{
    public function __construct(protected Environment $twig, protected SessionInterface $session) {}

    public function __invoke(): Response
    {
        $this->session->forget('user');
        return $this->redirect('/');
    }
}
