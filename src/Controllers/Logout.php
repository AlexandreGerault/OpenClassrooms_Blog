<?php

namespace AGerault\Blog\Controllers;

use AGerault\Blog\Services\AuthService;
use AGerault\Framework\Contracts\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class Logout extends BaseController
{
    public function __construct(
        protected Environment $twig,
        protected SessionInterface $session,
        protected AuthService $auth
    ) {}

    public function __invoke(): ResponseInterface
    {
        $this->auth->logout();
        return $this->redirect('/');
    }
}
